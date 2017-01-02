<?php

class Config {
   
   public $access_token_brommo =            "EAABtwoXA9ZBgBABT82krgPkPbBbvWOM88ZCxbro2MObtBQogeDTngGKyrYl4wZBdXZBfZCrf3D5jFdFmssghMbUtAiRGTOtzXSdEKjL0os5ZC9JZC24cB0kO0mzDZBSbeQlI1ndTbVJsbOZBEkRSHz2liQ9Omgc6ZBpTLLWvwbnNYNtgZDZD";
   public $access_token_talkingtorobbi =    "EAAaBBmi7fnYBAOwToWZCP539zbnp8CaCSPSAOsp5brKLescJTeWhvTnZBC6jZCW16jVrk2CT3CzEY6HfhoDkCjZAUDs35bscPEzVx71cVroC5Nw5qOp6z9CbCikkaidUpZBYVs2ttq5EB9gM5XVQ3pL8hM0thsZAG768SV2aS8owZDZD";
   public $access_token;

   public $verify_token = "fb_chatbot";
   public $fb_graph_messages_url = "https://graph.facebook.com/v2.6/me/messages?access_token=";
   public $languageDetector_url = "http://ws.detectlanguage.com/0.2/detect?key=cd92cab868d4caaab1da676116158189&q=";
   public $default_language = "en";
   public $language_guessing = true;
   public $debug = false;
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
      //$this->access_token = $this->access_token_talkingtorobbi;
      $this->access_token = $this->access_token_brommo;

   		$result = $this->fb_graph_messages_url . $this->access_token;

   		return $result;
   }
 
}
