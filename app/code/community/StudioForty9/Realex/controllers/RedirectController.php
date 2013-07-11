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
class Studioforty9_Realex_RedirectController extends Mage_Core_Controller_Front_Action
{
    /**
     * indexAction()
     *
     * This would be the action for the placeOrderRedirectUrl - that is the URL that is redirected to
     * after the customer clicks Place Order. This action would display and auto-submit the form that
     * is sent to Realex.
     *
     * @return void
     */
    public function indexAction()
    {
        
    }

    /**
     * cancelAction()
     *
     * This action may not be necessary depending on how the Response URL is handled.
     *
     * @todo Decide how we're going to handle the Response URL
     *
     * @return void
     */
    public function cancelAction()
    {
        
    }
}
