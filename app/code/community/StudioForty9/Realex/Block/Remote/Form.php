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
class Studioforty9_Realex_Block_Remote_Form extends Mage_Payment_Block_Form_Cc
{
    /**
     * _construct()
     *
     * see the following URL for an explanation of __construct() versus _construct()
     * http://www.magentocommerce.com/boards/viewthread/76027/#t282659
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        
        $method = Mage::getModel('realex/remote');
        $info   = Mage::getModel('payment/info');
        
        $this->setMethod($method);
        $method->setData('info_instance', $info);
        
        $this->setTemplate('realex/remote/form.phtml');
    }
    
    /**
     * getCcStartYears()
     *
     * Generate years for display in an HTML select box
     *
     * @deprecated
     * There is actually a core method that handles this functionality
     * Mage_Payment_Block_Form_Cc::getSsStartYears()
     * This is for Switch and Solo cards as they have a start date as well
     * as an expiry date.
     * This is used on the form for the Remote method in the payment step of the checkout
     *
     * @todo Test that this method returns an array of 10 years
     * @todo Test that the array returned contains the correct years
     *
     * @todo Remove this method
     *
     * @return array
     */
    public function getCcStartYears()
    {
        $years = array();
        $first = date("Y");
        
        for ($index = 0; $index < 10; $index++) {
            $years[$year] = $year;
        }

        return $years;
    }
}
