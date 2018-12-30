<?php
/**
 * @author shahroq <shahroq \at\ yahoo.com>
 * @copyright Copyright (c) 2018 shahroq.
 * http://concrete5.killerwhalesoft.com/addons/
 */
namespace Concrete\Package\WhaleOptions\Controller\SinglePage\Dashboard\Pages;

use Page;
use Core; 
use Asset;
use Package;
use Request;
use AssetList;
use \Concrete\Core\Page\Controller\DashboardPageController;

defined('C5_EXECUTE') or die('Access denied.');

class Options extends DashboardPageController
{

    public $fieldTypes = array();
    public $options = array();
    public $configNamespace;
    public $configGroup;

    public function on_start()
    {
        $this->error = Core::make('helper/validation/error');

        $this->fieldTypes = array(
                                'text',
                                'textarea',
                                'checkbox',
                                'radio',
                                'select',
                                'color',
                                'image',
                                'page',
                                'date',
                                'divider',
                                'header',
                                );

        $this->configNamespace = 'whale_options'; //=active theme handle or current package handle(whale_options)
        $this->configGroup = 'options';

        //Prepare Options
        $config = Core::make('config/database');
        $pkg = Package::getByHandle('whale_options');
        $pkgPath = $pkg->getPackagePath();

        /*
        get options.php file from any of these paths in consecutive order:
        1- /application/config/options/options.php
        2- <active theme>/options/options.php
        3- /packages/whale_options/options/options.php
        */

        $optionFile = false;

        //1
        $optionFile1 = DIR_CONFIG_SITE.DIRECTORY_SEPARATOR.'options'.DIRECTORY_SEPARATOR.'options.php'; 
        if (file_exists($optionFile1)) $optionFile = $optionFile1;

        //2
        if (!$optionFile) {
            $page = Page::getByID(1);
            $theme = $page->getCollectionThemeObject();
            $themePath = $theme->getThemeDirectory(); //dd($themePath);
            $themeHandle = $theme->getThemeHandle(); //dd($themeHandle);
            $optionFile2 = $themePath.DIRECTORY_SEPARATOR.'options'.DIRECTORY_SEPARATOR.'options.php'; //dd($optionFile);
            if (file_exists($optionFile2)) $optionFile = $optionFile2;
        }    

        //3
        if (!$optionFile) {
            $optionFile3 = $pkgPath.DIRECTORY_SEPARATOR.'options'.DIRECTORY_SEPARATOR.'options.php';
            if (file_exists($optionFile3)) $optionFile = $optionFile3;
        }    


        if ($optionFile) { 
            include($optionFile); 
            $this->options = $options;
            $this->configNamespace = $themeHandle;
        }


        //check if provided data via options.php is valid
        $this->validateOptions($this->options);

        //check and replace value of options from db
        foreach ((array)$this->options['tabs'] as $key1 => $tab) {
        foreach ((array)$tab['panels'] as $key2 => $panel) {    
        foreach ((array)$panel['fields'] as $key3 => $field) {

            $key = $this->configNamespace.'::'.$this->configGroup.'.'.$field['id'];
            $value = $config->get($key);
            if ($value){
                $this->options['tabs'][$key1]['panels'][$key2]['fields'][$key3]['value'] = $value;
            }

        }
        }
        }

    }    

    public function view()
    {
        $this->loadResources();
        
        //generate ui tabs:
        //for test
        //$tabs[] = array('general', 'General', FALSE);
        //$tabs[] = array('settings', 'Settings', FALSE);
        $tabs = array();
        foreach ((array)$this->options['tabs'] as $tab) {
            $selected = ( isset($tab['selected']) && (boolean)$tab['selected'] ) ? TRUE : FALSE;
            $tabs[] = array($tab['id'], $tab['title'], $selected);
        }

        $this->set('tabs', $tabs);
        $this->set('options', $this->options);
        $this->set('fieldTypeViews', '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'field_types' . DIRECTORY_SEPARATOR);
        $this->set('welcomeView', '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'welcome');
    }

    public function update()
    {
        if (Request::isPost()) {
            $this->_validate();
            if (!$this->error->has()) {
                $this->_save();
                $this->redirect('/dashboard/pages/options/', 'record_updated');
            }
        }
    }

    private function _save()
    {
        //$pkg = Package::getByHandle('whale_options');
        $config = Core::make('config/database');

        //save value of options to db
        foreach ((array)$this->options['tabs'] as $tab) {
        foreach ((array)$tab['panels'] as $panel) {
        foreach ((array)$panel['fields'] as $field) {
            //if (Request::post($field['id']) && Request::post($field['id'])!=''){ 
            $key = $this->configNamespace.'::'.$this->configGroup.'.'.$field['id'];
            $value = Request::post($field['id'], '');
            $config->save($key, $value);
            //if any additional method specified call it here

            if (isset($field['method']) && method_exists($this, $field['method'])){
                $method = $field['method'];
                $this->$method($value);
            }

            //}
        }
        }
        }

    }
        
    private function _validate()
    {
        $hvs = Core::make('helper/validation/strings');

        //$this->error->add('error1');
        if ($this->error->has()) {
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function record_updated()
    {
        $this->set('message', t('Options updated.'));
        $this->view();
    }

    private function validateOptions()
    {
        //validate options
        
        $fields = array();

        foreach ((array)$this->options['tabs'] as $key => $tab) {
        foreach ((array)$tab['panels'] as $key2 => $panel) {
        foreach ((array)$panel['fields'] as $key3 => $field) {

            //check type validity
            if (!in_array($field['type'], $this->fieldTypes)){
                $this->options['tabs'][$key]['panels'][$key2]['fields'][$key3]['type'] = 'error';
                $this->options['tabs'][$key]['panels'][$key2]['fields'][$key3]['error'] = t('Invalid Type');
            }

            //check id uniqueness
            if (!isset($field['id']) || !in_array($field['id'], $fields)){
                $fields[] = $field['id'];
            }else{
                $this->options['tabs'][$key]['panels'][$key2]['fields'][$key3]['type'] = 'error';
                $this->options['tabs'][$key]['panels'][$key2]['fields'][$key3]['error'] = t('Duplicate id');
            }
        }
        }
        }

        return;
    }    

    //load resource (js, css)
    private function loadResources()
    {
        $pkg = Package::getByHandle('whale_options');

        $al = AssetList::getInstance();

        $al->register( 'css', 'dashboard.whale_options', 'css/dashboard.whale_options.css' , array(), $pkg ); 
        $al->register( 'javascript', 'dashboard.whale_options', 'js/dashboard.whale_options.js' , array('position' => Asset::ASSET_POSITION_FOOTER), $pkg ); 

        $this->requireAsset('css', 'dashboard.whale_options');
        $this->requireAsset('javascript', 'dashboard.whale_options');
    }

    //field specfic methods
    private function my_method($value)
    {
        //do something with $value here
        //..
    }

}
