Feature: Backend Rebate
   Scenario: Successful Rebate
      Given I have an order that is settled
      When I view the invoice for this order in the Magento backend
      When I press "Credit Memo"
      And I wait for "5" Seconds
      And I press "Submit Credit Memo"
      Then the order should be refunded
      And the order status should be "closed"

   Scenario: Transaction already refunded
      Given I have an order that is refunded
      When I view the invoice for this order in the Magento backend
      When I press "Credit Memo"
      And I wait for "5" Seconds
      And I press "Submit Credit Memo"
      Then I should see "This order has already been refunded"

   Scenario: Transaction cannot be found
      Given I have an order that is settled
      And the Pasref for the order is empty
      When I view the invoice for this order in the Magento backend
      When I press "Credit Memo"
      And I wait for "5" Seconds
      And I press "Submit Credit Memo"
      Then the order should not be refunded
      And I should see "Original Transaction could not be found"

   Scenario: Not all fields specified
      Given I have an order that is settled
      And the Authcode for the order is empty
      When I view the invoice for this order in the Magento backend
      When I press "Credit Memo"
      And I wait for "5" Seconds
      And I press "Submit Credit Memo"
      Then the order should not be refunded
      And I should see "All required fields were not specified"

   Scenario: Refund Password is incorrect
      Given I have an order that is settled
      And the Realex Configuration Refund Password is "password"
      When I view the invoice for this order in the Magento backend
      When I press "Credit Memo"
      And I wait for "5" Seconds
      And I press "Submit Credit Memo"
      Then the order should not be refunded
      And I should see "Your Refund Password is Incorrect"

   Scenario: Refund Password is empty so no communication takes place
      Given I have an order that is settled
      When I view the invoice for this order in the Magento backend
      When I press "Credit Memo"
      And I wait for "5" Seconds
      Then I should see "The Realex Refund Password is not specified in the configuration"
      And the "Refund" button is disabled