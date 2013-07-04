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
class Studioforty9_Realex_Model_Redirect extends Mage_Payment_Model_Method_Abstract
{
	/**
	 * Payment gateway code.
	 *
	 * @var string $code
	 */
	protected $_code  = 'realex';
	
	/**
	 * The type of form block.
	 *
	 * Maps to /Studioforty9/Realex/Block/Redirect/Form.php
	 *
	 * @var string $_formBlockType
	 */
	protected $_formBlockType = 'realex/redirect_form';
	
	/**
	 * An array of allowed currency codes.
	 *
	 * @var array $_allowCurrencyCode
	 */
	protected $_allowCurrencyCode = array(
		'AUD', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 
		'HUF', 'JPY', 'NOK', 'NZD', 'PLN', 'SEK', 'SGD', 'USD'
	);

	/**
	 * assignData()
	 *
	 * This method is required by Magento to assign data...
	 *
	 * @todo Explain in greater detail how this method works.
	 * @todo Explain in greater detail how Magento uses this method.
	 * @param  Varien_Object $data
	 * @return Studioforty9_Realex_Model_Redirect
	 */
 	public function assignData($data)
	{
		if (!($data instanceof Varien_Object)) {
			$data = new Varien_Object($data);
		}

		$info = $this->getInfoInstance();
		$info->setCcType($data->getAmex());

		return $this;
	}

	/**
	 * getCheckout()
	 *
	 * Get checkout session namespace.
	 *
	 * @todo Explain why we get the checkout namespace.
	 * @todo Refactor the method name to getCheckoutNamespace()
	 * 
	 * @return Mage_Checkout_Model_Session
	 */
	public function getCheckout()
	{
		return Mage::getSingleton('checkout/session');
	}

	/**
	 * getQuote()
	 *
	 * Get current quote
	 *
	 * @return Mage_Sales_Model_Quote
	 */
	public function getQuote()
	{
		return $this->getCheckout()->getQuote();
	}

	/**
	 * canUseInternal()
	 *
	 * Using internal pages for input payment data.
	 *
	 * @todo Explain why one would use an internal page for input payment data.
	 *
	 * @return bool
	 */
	public function canUseInternal()
	{
		return false;
	}
	
	/**
	 * canUseForMultishipping()
	 *
	 * Using for multiple shipping address
	 *
	 * @todo Explain why one would use an internal page for input payment data.
	 *
	 * @return bool
	 */
	public function canUseForMultishipping()
	{
		return false;
	}
	
	/**
	 * createFormBlock()
	 *
	 * @todo Explain why _this_ method is in _this_ class.
	 *
	 * @param  string $name
	 * @return Mage_Core_Block_Abstract
	 */
	public function createFormBlock($name)
	{
		$block = $this->getLayout()->createBlock('realex/redirect_form', $name)
								   ->setMethod('realex_redirect')
								   ->setPayment($this->getPayment())
								   ->setTemplate('realex/redirect/form.phtml');

		return $block;
	}

	/**
	 * validate()
	 *
	 * Validate the currency code is avaialable to use for Realex or not
	 *
	 * @return SF9_Realex_Model_Redirect
	 */
	public function validate()
	{
		parent::validate();
		
		$currency_code = $this->getQuote()->getBaseCurrencyCode();
		
		if (! in_array($currency_code, $this->_allowCurrencyCode)) {
			Mage::throwException(Mage::helper('realex')->__(sprintf(
				'Selected currency code (%s) is not compatabile with Realex',
				$currency_code
			)));
		}
		
		return $this;
	}

	/**
	 * onOrderValidate()
	 *
	 * @param  Mage_Sales_Model_Order_Payment $payment
	 * @return Studioforty9_Realex_Model_Redirect
	 */
	public function onOrderValidate(Mage_Sales_Model_Order_Payment $payment)
	{
	   return $this;
	}

	/**
	 * @param Mage_Sales_Model_Invoice_Payment $payment
	 * @return void
	 */
	public function onInvoiceCreate(Mage_Sales_Model_Invoice_Payment $payment)
	{

	}

	/**
	 * canCapture()
	 * 
	 * The canCapture method is used by Magento to ...
	 *
	 * @todo Explain what this method does
	 * @return bool
	 */
	public function canCapture()
	{
		return true;
	}

	/**
	 * getOrderPlaceRedirectUrl()
	 *
	 * @todo Explain why we need to set the credit card type on the session.
	 * @todo Explain why we need to set the credit card type in this method.
	 * @todo Explain why we cant set the secure url to false.
	 *
	 * @return string
	 */
	public function getOrderPlaceRedirectUrl()
	{
		// First we get the checkout session, then we get the Quote object,
		// we find the Payment object and return the Credit Card Type.
		$ccType = Mage::getSingleton('checkout/session')
					  ->getQuote()
					  ->getPayment()
					  ->getCcType();
		// Here we set the Credit Card Type on core/session for use later.
		Mage::getSingleton('core/session')->setRealexCcType($ccType);
		
		// Finally, we return the secure URL to redirect to.
		return Mage::getUrl('realex/redirect/', array('_secure' => true));
	}

	/**
	 * getCheckoutRedirectUrl()
	 *
	 * @todo Explain why this method is different to getOrderPlaceRedirectUrl.
	 * @todo Explain why we cant set the secure url to false.
	 * @return string
	 *
	public function getCheckoutRedirectUrl()
	{
		  return Mage::getUrl('realex/redirect/', array('_secure' => true));
	}
	*/

	/**
	 * getSuccessUrl()
	 *
	 * The getSuccessUrl is used by x to do x
	 *
	 * @todo Explain why _this_ method is in _this_ class.
	 * @return string
	 */
	public function getSuccessUrl()
	{
		return Mage::getUrl('realex/response/');
	}

	/**
	 * getCancelUrl()
	 *
	 * The getSuccessUrl is used by x to do x
	 *
	 * @todo Explain why _this_ method is in _this_ class.
	 * @return string
	 */
	public function getCancelUrl()
	{
		return Mage::getUrl('realex/redirect/cancel');
	}

	/**
	 * getRealexUrl()
	 *
	 * The getSuccessUrl is used by x to do x
	 *
	 * @todo Explain why _this_ method is in _this_ class.
	 * @return string
	 */
	public function getRealexUrl()
	{
		return "https://epage.payandshop.com/epage.cgi";
	}

	/**
	 * isInitializeNeeded()
	 *
	 * @return bool
	 */
	public function isInitializeNeeded()
	{
		return true;
	}

	/**
	 * initialize()
	 *
	 * The initialize method is run by Magento when...
	 *
	 * @todo Check the type of $paymentAction
	 * @todo Explain what _this_ method is doing and why _this_ method is in _this_ class.
	 * @param  string $paymentAction
	 * @param  object $stateObject
	 * @return void
	 */
	public function initialize($paymentAction, $stateObject)
	{
		//$state = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
		$state = "Realex Processing";
		$stateObject->setState($state);
		//$stateObject->setStatus(Mage::getSingleton('sales/order_config')->getStateDefaultStatus($state));
		$stateObject->setIsNotified(false);
	}

	/**
	 * processRedirectResponse()
	 *
	 
	 * @return bool
	 */
	public function processRedirectResponse($post)
	{
		if ($this->isLoggingEnabled()) {
			Mage::log($post);
		}
		// Save the transaction response to the DB
		$this->saveRealexTransaction($post);
		// Create a new instance of a Authorize response
		$response = new Studioforty9_Realex_Model_Response_Authorize($post);
		// Get the result
		$result   = $response->getResult();
		$message  = $response->getMessage();
		$authcode = $response->getAuthcode();
		// Get the orderId from the response
		$orderId  = $response->getOrderId();
		$order    = Mage::getModel('sales/order')->loadByIncrementId($orderId);
		// Set the orderId on the session
		$session  = Mage::getSingleton('checkout/session');
		$session->setOrderId($orderId);

		//Check to see if hashes match or not
		if (!$response->isValid()) {
			//TODO: Check if we have to call getId() here? Can we quit early 
			// if (!$order->getId()) { return false; }
			if ($order->getId()) {
				$order->cancel();
				$order->addStatusToHistory('cancelled', 'The hashes do not match - response not authenticated!', false);
				$order->save();
			}
			
			return false;
		}
		
		if ($result === Studioforty9_Realex_Model_Response::SUCCESS) {
			if ($order->getId()) {
				$order->addStatusToHistory('processing', 'Payment Successful: ' . $result . ': ' . $message, false);
				$order->addStatusToHistory('processing', 'Authorisation Code: ' . $authcode, false);
				$order->sendNewOrderEmail();
				$order->setEmailSent(true);

				$session->setLastSuccessQuoteId($order->getId());
				$session->setLastQuoteId($order->getId());
				$session->setLastOrderId($order->getId());

				$order->save();
			}
			
			if ($redirect->getConfigData('capture')) {
				Mage::helper('realex')->createInvoice($orderId);
			}
			
			return true;
		}
		else {
			$session->addError('There was a problem completing your order. Please try again');
			
			if ($order->getId()) {
				$order->addStatusToHistory('cancelled', $result . ': ' . $message, false);
				$order->cancel();
			}
			
			$order->save();
			
			return false;
		 }
	}
	
	public function __processRedirectResponse($post)
	{
		if ($this->isLoggingEnabled()) {
			Mage::log($post);
		}
	
		$response = new Studioforty9_Realex_Model_Response_Authorize($post);
		$this->saveRealexTransaction($post);
		
		$timestamp	= $post['TIMESTAMP'];
		$result	  = $post['RESULT'];
		$orderId	  = $post['ORDER_ID'];
		$message	  = $post['MESSAGE'];
		$authcode	  = $post['AUTHCODE'];
		$pasref	  = $post['PASREF'];
		$realexsha1 = $post['SHA1HASH'];

		//get the information from the module configuration
		$redirect	= Mage::getModel('realex/redirect');
		$merchantId = $redirect->getConfigData('login');
		$secret		= $redirect->getConfigData('pwd');

		$tmp = "$timestamp.$merchantId.$orderId.$result.$message.$pasref.$authcode";
		$sha1hash = sha1($tmp);
		$tmp = "$sha1hash.$secret";
		$sha1hash = sha1($tmp);
		$order = Mage::getModel('sales/order')->loadByIncrementId($orderId);

		$session = Mage::getSingleton('checkout/session');
		$session->setOrderId($orderId);

		//Check to see if hashes match or not
		if ($sha1hash != $realexsha1) {
			if ($order->getId()) {
				$order->cancel();
				$order->addStatusToHistory('cancelled', 'The hashes do not match - response not authenticated!', false);
				$order->save();
			}
			
			return false;
		}
		else {
			if ($result === '00') {
				if ($order->getId()) {
					$order->addStatusToHistory('processing', 'Payment Successful: ' . $result . ': ' . $message, false);
					$order->addStatusToHistory('processing', 'Authorisation Code: ' . $authcode, false);
					$order->sendNewOrderEmail();
					$order->setEmailSent(true);

					$session->setLastSuccessQuoteId($order->getId());
					$session->setLastQuoteId($order->getId());
					   $session->setLastOrderId($order->getId());

					$order->save();
				}
				
				  if ($redirect->getConfigData('capture')) {
					Mage::helper('realex')->createInvoice($orderId);
				}
				
				return true;
			}
			else {
				$session->addError('There was a problem completing your order. Please try again');
				
				if ($order->getId()) {
					$order->addStatusToHistory('cancelled', $result . ': ' . $message, false);
					$order->cancel();
				}
				
				$order->save();
				
				return false;
			 }
		 }
	}
	
	public function saveRealexTransaction($post)
	{
		$realex = Mage::getModel('realex/realex');

		try {
			 $realex->setOrderId($post['ORDER_ID'])
					->setTimestamp(Mage::helper('realex')->getDateFromTimestamp($post['TIMESTAMP']))
					->setMerchantid($post['MERCHANT_ID'])
					->setAccount($post['ACCOUNT'])
					->setAuthcode($post['AUTHCODE'])
					->setResult($post['RESULT'])
					->setMessage($post['MESSAGE'])
					->setPasref($post['PASREF'])
					->setCvnresult($post['CVNRESULT'])
					->setBatchid($post['BATCHID'])
					->setTssResult($post['TSS'])
					->setAvspostcoderesponse($post['AVSPOSTCODERESULT'])
					->setAvsaddressresponse($post['AVSADDRESSRESULT'])
					->setHash($post['SHA1HASH'])
					->setFormKey($post['form_key'])
					->setPasUuid($post['pas_uuid'])
					->save();
		}
		catch (Exception $e) {
			Mage::logException($e);
		}
	}
}
