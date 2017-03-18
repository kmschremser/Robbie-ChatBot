<?php

class Config {
   
   // BROMMO APP
   public $fb_access_token_testing =       "EAABtwoXA9ZBgBAOhPaBh5dxZAhIdk2YYKyE1jwJCwEcD5v9TA7fQM8D3Rw6j32Izmj4xNr5RQbcHOWYaN5azAQFpg1taBaCSIXABbL3dqAF8aM6c8bSzs6CHF5NSXueRmADrijWOWfprogZBTIKJTchKiIo8OonO1M3kZA04vQZDZD";
   
   // TALKING TO ROBBI
   public $fb_access_token_production =    "EAAaBBmi7fnYBAOwToWZCP539zbnp8CaCSPSAOsp5brKLescJTeWhvTnZBC6jZCW16jVrk2CT3CzEY6HfhoDkCjZAUDs35bscPEzVx71cVroC5Nw5qOp6z9CbCikkaidUpZBYVs2ttq5EB9gM5XVQ3pL8hM0thsZAG768SV2aS8owZDZD";

   public $server = "testing";

   public $fb_graph_messages_url = "https://graph.facebook.com/v2.6/me/messages?access_token=";
   public $verify_token = "fb_chatbot";

   public $languageDetector_url = "http://ws.detectlanguage.com/0.2/detect?key=cd92cab868d4caaab1da676116158189&q=";
   public $default_language = "en";

   public $show_form = false;
   
   public $_countries = array (
        'UNITED STATES' => 'US',
        'CANADA' => 'CA',
        'MEXICO' => 'MX',
        'FRANCE' => 'FR',
        'BELGIUM' => 'BE',
        'UNITED KINGDOM' => 'UK',
        'SWEDEN' => 'SE',
        'DENMARK' => 'DE',
        'SPAIN' => 'ES',
        'AUSTRALIA' => 'AU',
        'AUSTRIA' => 'AT',
        'ITALY' => 'IT',
        'NETHERLANDS' => 'NL',
        'JAPAN' => 'JP'
   );

   function __construct() {

   }

   function createFbUrl() {  
      if ( $this->server === "testing" ) {
        $result = $this->fb_graph_messages_url . $this->fb_access_token_testing;
      } else {
        $result = $this->fb_graph_messages_url . $this->fb_access_token_production;
      }
   		return $result;
   }
 
}
