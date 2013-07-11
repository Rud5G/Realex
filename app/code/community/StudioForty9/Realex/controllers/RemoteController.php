<?php

/**
 * Studioforty9_Realex extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Studioforty9
 * @package    Studioforty9_Realex
 * @copyright  Copyright (c) 2013 StudioForty9
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Studioforty9
 * @package    Studioforty9_Realex
 * @author     Studioforty9 <info@sf9.ie>
 */
class Studioforty9_Realex_RemoteController extends Mage_Core_Controller_Front_Action
{
    /**
     * indexAction()
     *
     * This is probably unnecessary
     *
     * @todo Remove this method and possibly class
     *
     * @return void
     */
    public function indexAction()
    {
        
    }
    
    /**
     * failureAction()
     *
     * This is probably no longer necessary as it is better to redirect to the default
     * Magento success and failure pages as certain events are fired when these pages are loaded
     * and 3rd party modules will depend on this. Also Google Analytics E-commerce tracking
     * code is loaded on the success page.
     *
     * @todo Remove this method and possibly class
     * 
     * @return void
     */
    public function failureAction()
    {
        
    }
}
