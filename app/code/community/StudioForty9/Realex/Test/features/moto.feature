Feature: Backend Order Creation

   Scenario: Admin successfully creates order in the backend
      Given I am on "/admin/sales_order/"
      When I press "Create New Order"
      And I choose a customer
      And I choose a product
      And I choose a shipping method
      And I choose the Realex Payment Method
      Then I should see "Credit Card Type"
      When I select "Visa" from "Credit Card Type"
      And I fill in "Name as it appears on Credit Card" with "John Smith"
      And I fill in "Credit Card Number" with "4263971921001307"
      And I fill in "CVC" with "333"
      And I select "January" from "Expiration Date Month"
      And I select "2020" from "Expiration Date Year"
      And I press "Submit Order"
      And I wait for "5" Seconds
      Then I should not use 3D Secure
      And auto-settle should be enabled
      And I should see a message "The order has been created"
      And the order should have a status of "processing"