Feature: DCC

   Scenario Outline: Customer makes a purchase using DCC with a foreign card
     Given that DCC is enabled in the Realex Configuration
     And I add a product to the cart
     And I am on "/checkout/onepage"
     When I choose "Guest Checkout"
     And I fill in my Billing Address
     And I fill in my Shipping Address
     And I choose a Shipping Method
     And I choose Realex as the Payment Method
     And I select "Visa" from "Credit Card Type"
     And I fill in "Name as it appears on Credit Card" with "John Smith"
     And I fill in "Credit Card Number" with "<cc_number>"
     And I fill in "CVC" with "333"
     And I select "January" from "Expiration Date Month"
     And I select "2020" from "Expiration Date Year"
     And I press "Continue"
     And I wait "5" Seconds
     Then I should see "We notice that you have a <currency> card."
     And I should see "For your convenience you can opt to have	this transaction charged as"
     And I should see "Please select from the options below to continue: Yes - charge me in <currency>. No - I prefer to be charged in <base_currency>."
     When I click "Yes - charge me in <currency>"
     And I wait "5" Seconds
     And I press "Place Order"
     And I wait "5" Seconds
     Then the Realex Response Code should be <response_code>

     Examples:
     | base_currency | cc_number        | currency | response_code |
     | USD           | 4006097467207025 | AUD      | 00            |
     | USD           | 4002933640008365 | EUR      | 00            |

   Scenario: Customer makes a purchase with same card currency as base currency
      #should be just like a normal transaction

   Scenario: DCC but timestamp is out of date
	#Realex Payments must receive the authorisation request before this
	#expiry date, so as to ensure that the rate received from FEXCO is still valid.

#must be auto-settled
#DCC is only available on Visa and MasterCard card brands.
#can use elavon or fexco