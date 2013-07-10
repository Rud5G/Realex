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
class StudioForty9_Realex_Model_Source_OrderStatus{
	
    public function toOptionArray()
    {
        return array(
	        array('value' => 'canceled', 'label' => Mage::helper('realex')->__('Canceled')),
            array('value' => 'pending', 'label' => Mage::helper('realex')->__('Pending')),
            array('value' => 'processing', 'label' => Mage::helper('realex')->__('Processing')),
        );
    }
}