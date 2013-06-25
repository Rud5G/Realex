Feature: Realex Module Configuration
   In order to specify how I wish the Realex module to function
   As an admin
   I should be able to configure the module from the Magento System Configuration

   Scenario: Admin enables the module
      Given I am logged in to the Magento backend
      And I am on the System Configuration page
      When I visit "Payment Methods"
      Then I should see "Realex"

      When I select "Yes" from "Enabled"
      Then I should see "Title"
      And I should see "Use 3D Secure?"
      And I should see "Mode"
      And I should see "Merchant ID"
      And I should see "Shared Secret"
      And I should see "Account Name"
      And I should see "Refund Password"
      And I should see "Credit Card Types"
      And I should see "American Express Account"
      # @todo should this option be renamed - is it confusing?
      And I should see "Settle Immediately?"
      # @todo should this be a choice?
      And I should see "New Order Status"
      And I should see "Transaction Currency"
      And I should see "Debug"

      And I should see "Use TSS?"
      And I should see "Use AVS?"
      # @todo may need further fields here to handle this fraud detection - depends on what Sean says

      When I select "Yes" from "Use 3D Secure?"
      Then I should see "3D Secure Mode"
      And I select "iFrame" from "3D Secure Mode"
      And I select "Redirect" from "3D Secure Mode"

      When I select "No" from "Use 3D Secure?"
      Then I should not see "3D Secure Mode"

      When I select "Yes" from "Use TSS?"
      Then I should see "TSS Score Threshold"
      When I select "No" from "Use TSS?"
      Then I should not see "TSS Score Threshold"

      When I select "No" from "Enabled"
      Then I should not see "Title"