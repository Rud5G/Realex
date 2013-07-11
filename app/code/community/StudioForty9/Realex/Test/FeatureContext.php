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
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Step;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class StudioForty9_Realex_Test_FeatureContext extends \Behat\MinkExtension\Context\RawMinkContext
{
    /**
     * @When /^I choose Realex$/
     */
    public function iChooseRealex()
    {
        $session = $this->getSession();
        $page    = $session->getPage();
        $el      = $page->find('css', '#p_method_realex');
        
        $el->check();
        $session->executeScript("payment.switchMethod('realex')");
        $session->executeScript("jQuery('#payment_form_realex').show();");
        $session->executeScript("jQuery('#payment_form_realex input').attr('disabled', false);");
    }

    /**
     * @BeforeScenario @admin
     */
    public function disableAdminSecretKey()
    {
        //turn off secret key
        Mage::app()->getConfig()
                   ->saveConfig('admin/security/use_form_key', 0)
                   ->reinit();
    }

    /**
     * @AfterScenario @admin
     */
    public function enableAdminSecretKey()
    {
        //turn on secret key
        Mage::app()->getConfig()
                   ->saveConfig('admin/security/use_form_key', 1)
                   ->reinit();
    }

    /**
     * @BeforeFeature
     */
    public static function deleteOldScreenshots($event)
    {
        $files = glob(Mage::getBaseDir() . '/var/screenshots/*');
        
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * @AfterScenario
     */
    public function takeScreenshotForFailedScenario($event)
    {
        if ($event->getResult() === 4) {
            $driver = $this->getSession()->getDriver();
            if ($driver instanceof Selenium2Driver) {
                $this->saveScreenshot(null, Mage::getBaseDir() . '/var/screenshots');
            }
        }
    }
}
