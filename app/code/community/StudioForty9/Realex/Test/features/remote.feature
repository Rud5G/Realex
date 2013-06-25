Feature: Remote Method

   Scenario Outline: Customer makes a purchase with main CC Type
      Given I add a product to the cart
      And I am on "/checkout/onepage"
      When I choose "Guest Checkout"
      And I fill in my Billing Address
      And I fill in my Shipping Address
      And I choose a Shipping Method
      And I choose Realex as the Payment Method
      And I select <cc_type> from "Credit Card Type"
      And I fill in "Name as it appears on Credit Card" with "John Smith"
      And I fill in "Credit Card Number" with <cc_number>
      And I fill in "CVC" with "333"
      And I select "January" from "Expiration Date Month"
      And I select "2020" from "Expiration Date Year"
      And I press "Continue"
      And I wait "5" Seconds
      And I press "Place Order"
      And I wait "5" Seconds
      Then I should be on <url>
      And the Realex Response Code should be <response_code>

      Examples:
         | cc_type    | cc_number           | url                       | response_code |
         | Visa       | 4263971921001307    | /checkout/onepage/success | 00            |
         | Visa       | 4000126842489127    | /checkout/onepage/failure | 101           |
         | Visa       | 4000136842489878    | /checkout/onepage/failure | 102           |
         | Visa       | 4000166842489115    | /checkout/onepage/failure | 103           |
         | Visa       | 4009837983422344    | /checkout/onepage/failure | 205           |
         | Mastercard | 5425232820001308    | /checkout/onepage/success | 00            |
         | Mastercard | 5114617896541284    | /checkout/onepage/failure | 101           |
         | Mastercard | 5114634523652350    | /checkout/onepage/failure | 102           |
         | Mastercard | 5121229875643585    | /checkout/onepage/failure | 103           |
         | Mastercard | 5135024345352238    | /checkout/onepage/failure | 205           |
         | Laser      | 6304939304310009610 | /checkout/onepage/success | 00            |
         | Laser      | 6304908620589523057 | /checkout/onepage/failure | 101           |
         | Laser      | 6304936989767381455 | /checkout/onepage/failure | 102           |
         | Laser      | 6304902235219564797 | /checkout/onepage/failure | 103           |
         | Laser      | 6304907892020719666 | /checkout/onepage/failure | 207           |
         | Laser      | 6304902507676842597 | /checkout/onepage/failure | 200           |
         | Laser      | 6304907393951371312 | /checkout/onepage/failure | 205           |
         | Delta      | 4544321006384999    | /checkout/onepage/success | 00            |
         | Delta      | 4544325493312389    | /checkout/onepage/success | 00            |
         | Delta      | 4544325149487510    | /checkout/onepage/success | 00            |
         | Delta      | 4544320775588335    | /checkout/onepage/success | 00            |
         | Delta      | 4544329965362542    | /checkout/onepage/success | 00            |
         | Delta      | 4544320477812827    | /checkout/onepage/success | 00            |
         | Delta      | 4544324877993401    | /checkout/onepage/success | 00            |
         | Diners     | 36256052780018      | /checkout/onepage/success | 00            |
         | Diners     | 36256052800014      | /checkout/onepage/failure | 101           |
         | Diners     | 36256052790017      | /checkout/onepage/failure | 102           |
         | Diners     | 38865030565503      | /checkout/onepage/failure | 103           |
         | Diners     | 30450000000001      | /checkout/onepage/failure | 205           |
         | Visa Debit | 4263971921001307    | /checkout/onepage/success | 00            |
         | Visa Debit | 4000126842489127    | /checkout/onepage/failure | 101           |
         | Visa Debit | 4000136842489878    | /checkout/onepage/failure | 102           |
         | Visa Debit | 4000166842489115    | /checkout/onepage/failure | 103           |
         | Visa Debit | 4009837983422344    | /checkout/onepage/failure | 205           |


   Scenario Outline: Customer makes a purchase with Switch / Solo
      Given I add a product to the cart
      And I am on "/checkout/onepage"
      When I choose "Guest Checkout"
      And I fill in my Billing Address
      And I fill in my Shipping Address
      And I choose a Shipping Method
      And I choose Realex as the Payment Method
      And I select <cc_type> from "Credit Card Type"
      Then I should see "Issue No."
      And I should see "Start Date"
      When I fill in "Name as it appears on Credit Card" with "John Smith"
      And I fill in "Credit Card Number" with <cc_number>
      And I fill in "CVC" with "333"
      And I select "January" from "Expiration Date Month"
      And I select "2020" from "Expiration Date Year"
      And I fill in "Issue No." with <issue_no>
      And I select "January" from "Expiration Start Month"
      And I select "2012" from "Expiration Start Year"
      And I press "Continue"
      And I wait "5" Seconds
      And I press "Place Order"
      And I wait "5" Seconds
      Then I should be on <url>
      And the Realex Response Code should be <response_code>

      Examples:
         | cc_type | cc_number          | issue_no | url                       | response_code |
         | Solo    | 633478111298873700 | 2        | /checkout/onepage/success | 00            |
         | Solo    | 633478254819816400 | 6        | /checkout/onepage/failure | 101           |
         | Solo    | 633478219790925900 | 1        | /checkout/onepage/failure | 102           |
         | Solo    | 633478809869242300 | 3        | /checkout/onepage/failure | 103           |
         | Solo    | 633478384467574900 | 3        | /checkout/onepage/failure | 200           |
         | Solo    | 633478033217574500 | 2        | /checkout/onepage/failure | 204           |
         | Solo    | 633478955263546000 | 6        | /checkout/onepage/failure | 205           |
         | Switch  | 6331101999990073   | 17       | /checkout/onepage/success | 00            |
         | Switch  | 490303400005710388 | 1        | /checkout/onepage/failure | 101           |

   Scenario Outline: Customer makes a purchase with American Express
      Given I add a product to the cart
      And I am on "/checkout/onepage"
      When I choose "Guest Checkout"
      And I fill in my Billing Address
      And I fill in my Shipping Address
      And I choose a Shipping Method
      And I choose Realex as the Payment Method
      And I select <cc_type> from "Credit Card Type"
      When I fill in "Name as it appears on Credit Card" with "John Smith"
      And I fill in "Credit Card Number" with <cc_number>
      And I fill in "CVC" with "3333"
      And I select "January" from "Expiration Date Month"
      And I select "2020" from "Expiration Date Year"
      And I press "Continue"
      And I wait "5" Seconds
      And I press "Place Order"
      And I wait "5" Seconds
      Then I should be on <url>
      And the Realex Response Code should be <response_code>

      Examples:
         | cc_type | cc_number       | url                       | response_code |
         | Amex    | 374101012180018 | /checkout/onepage/success | 00            |
         | Amex    | 375425435431    | /checkout/onepage/success | 101           |
         | Amex    | 375425435431347 | /checkout/onepage/success | 102           |
         | Amex    | 343452345245640 | /checkout/onepage/success | 103           |
         | Amex    | 372349658273959 | /checkout/onepage/success | 205           |

   Scenario Outline: Client-Side Validation of CC Number
      Given I am at the payment step of the checkout
      And I choose the Realex payment method
      And I select <cc_type> from "Credit Card Type"
      And I fill in "Credit Card Number" with <cc_number>
      And I press "Continue"
      Then I should get error message <valdation_message>

      Examples:
         | cc_type    | cc_number           | message                                           |
         | Visa       | 4263971921001307    |                                                   |
         | Visa       | 5432673658133162    | Credit Card Number doesn't match Credit Card Type |
         | Mastercard | 5432673658133161    |                                                   |
         | Mastercard | 4263971921001307    | Credit Card Number doesn't match Credit Card Type |
         | Visa Debit | 4263971921001307    |                                                   |
         | Visa Debit | 5432673658133162    | Credit Card Number doesn't match Credit Card Type |
         | Maestro    | ?                   | ?                                                 |
         | Maestro    | ?                   | ?                                                 |
         | Maestro UK | ?                   | ?                                                 |
         | Maestro UK | ?                   | ?                                                 |
         | Laser      | 6304905395014573919 |                                                   |
         | Laser      | 4263971921001307    | Credit Card Number doesn't match Credit Card Type |
         | Delta      | 4544321006384999    |                                                   |
         | Delta      | 4263971921001307    | Credit Card Number doesn't match Credit Card Type |
         | Diners     | 36256052780018      |                                                   |
         | Diners     | 4263971921001307    | Credit Card Number doesn't match Credit Card Type |
         | Switch     | 6331101999990073    |                                                   |
         | Switch     | 4263971921001307    | Credit Card Number doesn't match Credit Card Type |
         | Solo       | 633478111298873700  |                                                   |
         | Solo       | 4263971921001307    | Credit Card Number doesn't match Credit Card Type |
         | Amex       | 374101012180018     |                                                   |
         | Amex       | 4263971921001307    | Credit Card Number doesn't match Credit Card Type |

   Scenario: Transaction Already Processed
      #@todo how should this work?

	Scenario: Successful Transaction empties cart
		When I put through a successful transaction using the Realex payment method
		Then I am on "/checkout/onepage/success"
		And the number of items in my cart is 0

	Scenario: Unsuccessful Transaction leaves items in cart	
       When I put through an unsuccessful transaction using the Realex payment method
       Then I am on "/checkout/onepage/failure"
       And the number of items in my cart is greater than 0

   Scenario: Logging Enabled
      Given logging is enabled in the Realex configuration
      And I place an order using the Remote method
      Then "4263971921001307" should not appear in realex.log
      And "333" should not appear in realex.log
      And "1307" should appear in realex.log