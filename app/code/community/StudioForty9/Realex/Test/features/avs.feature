Feature: AVS
   Scenario: Customer transaction does not match or only partially matches AVS
      Given I place an order using the Realex payment method
      And the AVS result returned is N or P
      Then the order should be placed in XXX status
      #@todo not entirely sure what is the best thing to do here - proceed/review/reject - have asked Sean in Realex for some guidance
      #@todo according to the docs the transaction will proceed and be authorised by the bank, so maybe the best thing to do is to put into review and not auto-settle even if this is what's in the config?