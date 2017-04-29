<?php
/**
 * @author shahroq <shahroq \at\ yahoo.com>
 * @copyright Copyright (c) 2017 shahroq.
 * http://concrete5.killerwhalesoft.com/addons/
 */
namespace Concrete\Package\WhaleOptions\Controller\SinglePage\Dashboard\Pages;
use \Concrete\Core\Page\Controller\DashboardPageController;
use Package;
use Asset;
use AssetList;
use Request;
use Core; 
use Page;

defined('C5_EXECUTE') or die('Access denied.');

class Options extends DashboardPageController
{

    public $fieldTypes = array();
    public $options = array();

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
                                'divider',
                                'header',
                                );

        //Prepare Options
        $config = Core::make('config/database');
        $pkg = Package::getByHandle('whale_options');
        $pkgPath = $pkg->getPackagePath();

        //first check active theme root, then this package root for options.php file
        $page = Page::getByID(1);
        $theme = $page->getCollectionThemeObject();
        $themePath = $theme->getThemeDirectory(); //echo $themePath;
        //$themeUrl = $theme->getThemeURL(); echo $themeUrl;

        $optionFile = $themePath.DIRECTORY_SEPARATOR.'options'.DIRECTORY_SEPARATOR.'options.php';
        if(file_exists($optionFile)) {
            include($optionFile); 
            $this->options = $options;
        }else{    
            //then check package default option file        
            $optionFile = $pkgPath.DIRECTORY_SEPARATOR.'options'.DIRECTORY_SEPARATOR.'options.php';
            if(file_exists($optionFile)) {
                include($optionFile); 
                $this->options = $options;
            }else{
                //no option file
            }    
        }        

        //check if provided data via options.php is valid
        $this->validateOptions($this->options);

        //check and replace value of options from db
        foreach ((array)$this->options['tabs'] as $key => $tab) {
        foreach ((array)$tab['panels'] as $key2 => $panel) {    
        foreach ((array)$panel['fields'] as $key3 => $field) {
            if($val = $config->get('options.'.$field['id'])){
                $this->options['tabs'][$key]['panels'][$key2]['fields'][$key3]['value'] = $val;
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
            //if(Request::post($field['id']) && Request::post($field['id'])!=''){ 
            $config->save('options.'.$field['id'], Request::post($field['id'], ''));
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
            if(!in_array($field['type'], $this->fieldTypes)){
                $this->options['tabs'][$key]['panels'][$key2]['fields'][$key3]['type'] = 'error';
                $this->options['tabs'][$key]['panels'][$key2]['fields'][$key3]['error'] = t('Invalid Type');
            }

            //check id uniqueness
            if(!isset($field['id']) || !in_array($field['id'], $fields)){
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

}