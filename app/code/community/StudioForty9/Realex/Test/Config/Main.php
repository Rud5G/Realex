<?php

class StudioForty9_Realex_Test_Config_Main extends EcomDev_PHPUnit_Test_Case_Config
{
    public function testModuleRegistration()
    {
        $this->assertModuleCodePool('community');
        $this->assertModuleVersion('3.0.0');
    }
}