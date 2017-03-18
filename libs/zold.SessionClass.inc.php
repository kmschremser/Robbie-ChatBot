<?php

class Session {
   
   public $session;
   public $debug = false;
   public $config;
   public $log;

   function __construct() {

      // Start the session
      session_start();

   }
 
   public function setSession( $key, $value, $log = true ) {
      $this->session[$key] = $value;
      if ( $this->config->debug == true && $log === true && $value !== "" ) $this->log->log( "setSession $key = |".$value."|", "session" );
      return true;  
   }

   public function getSession( $key, $log = true ) {
      if ( $this->config->debug == true && $log === true && $value !== "" ) $this->log->log( "getSession $key = |".$value."|". $this->session[$key]."|", "session" );
      return $this->session[$key];
   }

   public function saveSession( $person_id, $content, $delete ) {
      if ( isset( $person_id ) ) {
         if ( $delete === true ) {
            file_put_contents( "./log/" . $person_id . ".txt", "{}" );
            //unlink( "./log/" . $person_id . ".txt" );
            if ( $this->config->debug == true ) $this->log->log( "delete profile", "delete in session" );
         } else {
          @file_put_contents( "./log/" . $person_id . ".txt", $content);
         }
      }
   }

   public function loadSession( $person_id ) {
      if ( isset( $person_id ) ) $content = @file_get_contents( "./log/" . $person_id . ".txt");

      return $content;
   }

}
