<?php

class Communication {

   public $message = "";

   function __construct() {

   }
   
   /*
   verify facebook request initially
   */
   function fbVerify( $hub_challenge, $hub_verify_token, $verify_token ) {

      if ( isset( $hub_challenge ) ) {
         $challenge = $hub_challenge;
         if ( $hub_verify_token === $verify_token ) {
            return $challenge;
         }         
      } else {
         return false;
      }
   }
   
   function getInputs() {
      // get input from message
      $input = json_decode(file_get_contents('php://input'), true);

      $result = array();

      // ID of FB user 
      $senderID = $input['entry'][0]['messaging'][0]['sender']['id'];
      // message in messenger chat
      $userMessage = $input['entry'][0]['messaging'][0]['message']['text'];
      // get whole message
      $inputArray = $input;

      return array( $senderID, $userMessage, $inputArray );
   }

   function initCommunication( $init_url, $jsonDataReply ) {
      // initiate cURL
      $curl = curl_init( $init_url );

      curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
      
      curl_setopt($curl, CURLOPT_COOKIESESSION, true);
      curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie-name');  //could be empty, but cause problems on some hosts
      curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__.'/log/cookie.txt');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
      
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonDataReply);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

      // execute the request
      $result = curl_exec($curl);
      curl_close($curl); 
      return true;
   }

}
