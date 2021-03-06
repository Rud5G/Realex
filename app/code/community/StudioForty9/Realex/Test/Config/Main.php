<?php

/**
 * StudioForty9_Realex extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   StudioForty9
 * @package    StudioForty9_Realex
 * @copyright  Copyright (c) 2011 StudioForty9
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   StudioForty9
 * @package    StudioForty9_Realex
 * @author     Alan Morkan <alan@StudioForty9.ie>
 */
class StudioForty9_Realex_Test_Config_Main extends EcomDev_PHPUnit_Test_Case_Config
{
    public function testModuleRegistration()
    {
        $this->assertModuleCodePool('community');
        $this->assertModuleVersion('3.0.0');
    }

    public function testControllerRoute(){
        $this->assertRouteFrontName('realex');
    }

    public function testModels()
    {
        $this->assertModelAlias('realex/remote', 'StudioForty9_Realex_Model_Remote');
    }

    public function testBlocks()
    {
        $this->assertBlockAlias('realex/redirect_form', 'StudioForty9_Realex_Block_Redirect_Form');
    }

    public function testHelpers()
    {
        $this->assertHelperAlias('realex', 'StudioForty9_Realex_Helper_Data');
    }
}
