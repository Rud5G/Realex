Feature: Delayed Settlement / Creation of Invoice
   Scenario: Successful Settlement
      Given I have an order that is authorised but not settled
      When I view this order in the Magento backend
      When I press "Invoice"
      And I wait for "5" Seconds
      And I press "Submit Invoice"
      Then the order should be settled
      And the order status should be "processing"

   Scenario: Transaction already settled
      Given I have an order that is settled
      When I view this order in the Magento backend
      When I press "Invoice"
      And I wait for "5" Seconds
      And I press "Submit Invoice"
      Then I should see an error message

   Scenario: Transaction cannot be found
     Given I have an order that is authorised but not settled
     And the Pasref for the order is empty
     When I press "Invoice"
     And I wait for "5" Seconds
     And I press "Submit Invoice"
     Then I should see an error message

   Scenario: Not all fields specified
      Given I have an order that is authorised but not settled
      And the Authcode for the order is empty
      When I press "Invoice"
      And I wait for "5" Seconds
      And I press "Submit Invoice"
      Then I should see an error message