Feature: Backend Void
   Scenario: Successful Void
      Given I have an order that is authorised but not settled
      When I view this order in the Magento backend
      When I press "Cancel"
      Then the order should be cancelled
      #@todo need to say something more than this

   Scenario: Transaction already settled
      Given I have an order that is settled
      When I view this order in the Magento backend
      When I press "Cancel"
      Then the order should not be cancelled
      And I should see "You cannot cancel this order as it is already settled"

   Scenario: Transaction cannot be found
      Given I have an order that is authorised but not settled
      And the Pasref for the order is empty
      When I view this order in the Magento backend
      When I press "Cancel"
      Then the order should not be cancelled
      And I should see "Original Transaction could not be found"

   Scenario: Not all fields specified
      Given I have an order that is authorised but not settled
      And the Authcode for the order is empty
      When I view this order in the Magento backend
      When I press "Cancel"
      Then the order should not be cancelled
      And I should see "All required fields were not specified"