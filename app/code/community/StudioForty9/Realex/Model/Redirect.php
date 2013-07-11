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
     * This method is required by Magento to assign the data entered in the 
     * payment step of the checkout into the payment object attached to the 
     * quote (and ultimately the order).
     *
     * In Checkout/controllers/OnepageController.php on line 509 we have 
     * $this->getOnepage()->getQuote()->getPayment()->importData($data);
     *
     * This payment that calls importData() is Mage_Sales_Model_Quote_Payment 
     * and on line 154 $method->assignData($data) is called where $method is the
     * currently chosen payment method (i.e., an object of this class)
     *
     * For the redirect method, as there is no information entered by the 
     * customer in the checkout this module doesn't really do anything. That is 
     * except in the case where Amex is enabled in which case the customer needs
     * to indicate prior to placing the order whether they intend to use Amex or
     * not, as a different subaccount needs to be sent over to Realex when the 
     * redirect occurs.
     *
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
     * This method may not be necessary
     * @todo Explain why we get the checkout namespace.
     * @todo Refactor the method name to getCheckoutNamespace()
     *
     * @todo Remove this method
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
     * This method may not be necessary
     *
     * @todo Remove this method
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
     * This determines whether the payment method can be used from the Admin.
     * For redirect methods, this should be set to false.
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
     * This determines whether the payment method can be used from the MultiShipping Checkout.
     * Most redirect methods (including Paypal) don't allow the use of the MultiShipping Checkout.
     * I'm not entirely sure why.
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
     * This method does not need to be here. It has been copied from the Paypal module.
     * Ultimately, the form is displayed by Mage_Checkout_Block_Onepage_Payment_Methods
     * calling getPaymentMethodFormHtml() on line 72 which has the following code:
     * $this->getChildHtml('payment.method.' . $method->getCode());
     * This could just as easily be managed by layout XML
     *
     * @todo move this method
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
     * Setting the RealexCcType probabaly isn't necessary. It's currently being
     * used to check whether Amex was selected in the checkout when creating the 
     * form to be sent to Realex /SF9/Realex/Block/Redirect/Form.php on line 61 
     * of the current module I think the idea was that this information would 
     * not be stored for long enough in the Payment object to be used when 
     * redirecting (as CC number, for example, is wiped in the meantime). But
     * this shouldn't be the case for the CC Type.
     *
     * @todo Explain why we cant set the secure url to false.
     * It actually should be fine to use false.
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
     * We should probably remove this method or else decide to implement it 
     * properly. The difference with this method is that it will do the redirect
     * at the point of clicking "Continue" at the payment step of the checkout. 
     * On returning from Realex we would then need to present a page to the 
     * customer to "confirm" their order and accept any applicable terms and 
     * conditions. Allowing this path would also force us to make the redirect 
     * an authorise only transaction, and if the customer were to subsequently 
     * confirm the order, we would then look to see if "settle immediately" was
     * chosen in the Realex configuration and if "yes", that a subsequent XML 
     * based capture request would be sent.
     *
     * @todo Explain why we cant set the secure url to false.
     * It actually should be fine to use false.
     *
     * @todo Decide whether we are going to implement this functionality
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
     * This probably should be renamed at least as it's the Response URL for 
     * Realex. This method is called when the form for the redirect is being 
     * created. There's no need for this method to be in this class.
     *
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
     * This method is not used
     *
     * @todo Remove this method
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
     * This method is called when the form for the redirect is being created.
     * There's no need for this method to be in this class.
     *
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
     *
     * I'm not sure what the purpose of this is. It's called on line 299 of
     * Mage_Sales_Model_Order_Payment. I'd say we can remove it until we have a 
     * use case for why it might be needed. This also goes for the method above.
     *
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
        
        $timestamp  = $post['TIMESTAMP'];
        $result     = $post['RESULT'];
        $orderId    = $post['ORDER_ID'];
        $message    = $post['MESSAGE'];
        $authcode   = $post['AUTHCODE'];
        $pasref     = $post['PASREF'];
        $realexsha1 = $post['SHA1HASH'];

        //get the information from the module configuration
        $redirect   = Mage::getModel('realex/redirect');
        $merchantId = $redirect->getConfigData('login');
        $secret     = $redirect->getConfigData('pwd');

        $tmp      = "$timestamp.$merchantId.$orderId.$result.$message.$pasref.$authcode";
        $sha1hash = sha1($tmp);
        $tmp      = "$sha1hash.$secret";
        $sha1hash = sha1($tmp);
        $order    = Mage::getModel('sales/order')->loadByIncrementId($orderId);

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
