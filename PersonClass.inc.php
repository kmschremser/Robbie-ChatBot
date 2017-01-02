<?php

class Person {
   
   public $session;
   public $firstname = "";
   public $lastname = "";
   public $fb_sender_id = "";
   public $email = "";
   public $age = "";
   public $birthday = "";
   public $location = "";
   public $gender = "";
   public $mood = "";
   public $mood_date;
   public $last_activity;
   public $likes = array();
   public $topic = array();

   function __construct( $session ) {
      $this->session = $session;
   }

}
