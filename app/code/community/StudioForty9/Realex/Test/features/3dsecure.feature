Feature: 3D Secure
   Scenario: Customer makes purchase via 3D Secure via iFrame
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
      Then I should see an iFrame
      And I should see "Enter Your Password"
      When I enter my 3D Secure password
      And press "Submit"
      #@todo what happens here if it's not successful or any of the other error scenarios?
      #@todo can i auto-submit to go to order review here?
      And I press "Place Order"
      And I wait "5" Seconds
      Then I should be on "/checkout/onepage/success"
      #@todo need to specify more information about the order/transaction status

   Scenario Outline: Not-Enrolled Customer makes purchase via 3D Secure via Redirect
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
      And the ECI should be <eci>
      And the Message should be <message>

      Examples:
         | cc_type | cc_number        | url                       | response_code | message                                                         | eci |
         | Visa    | 4012001038443335 | /checkout/onepage/success | 00            | Cardholder Not Enrolled. Shift in liability.                    | 6   |
         | Visa    | 4012001038488884 | /checkout/onepage/success | 00            | Unable to Verify Enrollment. No shift in liability.             | 7   |
         | Visa    | 4012001036298889 | /checkout/onepage/success | 00            | Invalid response from Enrollment Server. No shift in liability. | 7   |
         | Visa    | 4012001038011116 | /checkout/onepage/success | 00            | Enrolled but invalid response from ACS.  No shift in liability. | 7   |


   Scenario Outline: Enrolled Customer makes purchase via 3D Secure via Redirect
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
      Then I should be on "/realex/ACS/redirect"
      And I wait "5" Seconds
      Then the state of the newly created order should be "Pending Payment"
      And the status of the newly created order should be "3D Secure"
      #@todo this step in selenium will actually just hit the submit button of the test system
      And I enter my 3D Secure password
      Then I should be on <url>
      And the Realex Response Code should be <response_code>
      And the ECI should be <eci>
      And the Message should be <message>

      Examples:
         | cc_type | cc_number           | url                       | response_code | message                                                                                                | eci |
         | Visa    | 4012001037141112    | /checkout/onepage/success | 00            | Successful authentication.  Shift in liability.                                                        | 5   |
         | Visa    | 4012010000000000009 | /checkout/onepage/success | 00            | Successful authentication (19 digit).                                                                  | 5   |
         | Visa    | 4012001037167778    | /checkout/onepage/success | 00            | Issuing bank with Attempt server. Shift in liability (attempt server means ACS not fully implemented). | 6   |
         | Visa    | 4012001037461114    | /checkout/onepage/success | 00            | Incorrect password entered.  No shift in liability.                                                    | 7   |
         | Visa    | 4012001037484447    | /checkout/onepage/success | 00            | Authentication Unavailable.  No shift in liability.                                                    | 7   |
         | Visa    | 4012001037490006    | /checkout/onepage/success | 00            | Invalid response from ACS.  No shift in liability.                                                     | 7   |