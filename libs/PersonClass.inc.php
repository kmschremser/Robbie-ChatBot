<?php

class Person {
   
   public $props = array();

   // initial properties
   // firstname
   // lastname
   // fb_sender_id
   // email
   // age
   // birthday
   // location
   // gender
   // mood
   // mood_date
   // last_activity
   // likes = array()
   // topic = array()

   function __construct( ) {
      
   }

   public function setPersonProperty( $property_name = "", $property_value = "" ) {
      $this->props[$property_name] = $property_value;
      /*
      echo "<br><br>" . $property_name . " ";
      print_r($property_value);
      echo "<br><br>";
      */
      return true;
   }

   public function getPersonProperty( $property_name = "" ) {
      if ( isset( $this->props[$property_name] ) ) 
         return $this->props[$property_name];
      else 
         return false;
   }


   public function saveUserProfile( $person_id, $content, $intention_to_reset ) {

      if ( isset( $person_id ) ) {
         if ( "$intention_to_reset" === "done" ) {
            file_put_contents( "./log/" . $person_id . ".txt", "{}" );
            $logmessage = array( "Reseting user profile " . $person_id, "remove profile" );
         } else {
          @file_put_contents( "./log/" . $person_id . ".txt", $content);
          $logmessage = array( "Saving user profile " . $person_id, "save profile" );
         }
         return $logmessage;
      }
   }

   public function loadUserProfile( $person_id ) {
      if ( isset( $person_id ) ) $content = @file_get_contents( "./log/" . $person_id . ".txt");
      return $content;
   }

}
