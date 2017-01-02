<?php

class Communication {

   public $message = "";
   private $hub_verify_token = null;

   function __construct() {

   }
   
   /*
   verify facebook request initially
   */
   function fbVerify( $request, $config ) {

      if ( isset( $request['hub_challenge'] ) ) {
         $challenge = $request['hub_challenge'];
         $this->hub_verify_token = $request['hub_verify_token'];
      }

      if ( $this->hub_verify_token === $config->verify_token ) {
         return $challenge;
      } else {
         return false;
      }
   }
   
   function getInputs() {

      $input = json_decode(file_get_contents('php://input'), true);

      $result = array();

      // ID of FB user 
      $result['sender'] = $input['entry'][0]['messaging'][0]['sender']['id'];
      // message in messenger chat
      $result['userMessage'] = $input['entry'][0]['messaging'][0]['message']['text'];
      
      // get whole message
      $result['input'] = $input;

      return $result;
   }

   function initCommunication( $config, $jsonDataReply, $message ) {

      $init_url = $config->createFbUrl();

      //Initiate cURL.
      $curl = curl_init( $init_url );

      //Encode the array into JSON.
      $jsonDataEncoded = $jsonDataReply;

      //curl_setopt($curl, CURLOPT_URL, 'http://www.example.com/login.php');
      curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
      
      curl_setopt($curl, CURLOPT_COOKIESESSION, true);
      curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie-name');  //could be empty, but cause problems on some hosts
      curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__.'/log/cookie.txt');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
      
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonDataEncoded);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

      //Execute the request
      if ( !empty( $message['userMessage'] ) ) {
         $result = curl_exec($curl);
         curl_close($curl); 
         return true;
      } else {
         return false;
      }

   }

}
