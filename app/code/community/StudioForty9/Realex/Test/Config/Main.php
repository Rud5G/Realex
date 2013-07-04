<?php

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
}