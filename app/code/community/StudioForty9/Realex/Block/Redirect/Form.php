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
class SF9_Realex_Block_Redirect_Form extends Mage_Payment_Block_Form
{
    /**
     * _construct()
     *
     * see the following URL for an explanation of __construct() versus _construct()
     * http://www.magentocommerce.com/boards/viewthread/76027/#t282659
     * @return void
     */
    protected function _construct()
    {
        $this->setTemplate('realex/redirect/form.phtml');
        
        parent::_construct();
    }
}
