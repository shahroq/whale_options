<?php
/**
 * @author shahroq <shahroq \at\ yahoo.com>
 * @copyright Copyright (c) 2018 shahroq.
 * http://concrete5.killerwhalesoft.com/addons/
 */
namespace Concrete\Package\WhaleOptions;
use Package;
use SinglePage;

defined('C5_EXECUTE') or die('Access denied.');

class Controller extends Package {

	protected $pkgHandle = 'whale_options';
    protected $appVersionRequired = '5.7.3';
    protected $pkgVersion = '1.1.0';

	public function getPackageDescription() 
	{
        return t("Whale Options");
    }

    public function getPackageName() 
    {
        return t("Whale Options");
    }

	public function install() 
	{
		$pkg = parent::install();

		$this->createSinglePage($pkg);
	}

 	private function createSinglePage($pkg)
 	{
        //options
        $p = SinglePage::add('/dashboard/pages/options',$pkg);
        if (is_object($p)) {
            $p->update(array('cName'=>'Theme Options'));
        }
	}

}