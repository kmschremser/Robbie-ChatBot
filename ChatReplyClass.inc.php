<?php

// example
// https://docs.api.ai/docs/rich-messages#card

class ChatReply {
   
   public $input_message = "";
   public $output_message = "";
   public $log;

   function __construct() {

   }
  
   public function findReply( $config, $userMessage, $nlp ) {

      $nlp->input_message = $userMessage['userMessage'];

      $nlp->config = $config;

      $this->output_message = $nlp->analyzeText();

      $this->input_message = $nlp->input_message;

      // TODO strip slashes in message
      if ( $nlp->ask_for_location === true ) {
        $output_message = $this->createLocationMessage( $config, $userMessage );
      } elseif ( $nlp->ask_for_topic === true ) {
        $output_message = $this->createTopicMessage( $config, $userMessage );
        $this->log->log( $output_message, "findReply" );
      } else {
        $output_message = $this->createSimpleMessage( $config, $userMessage );
      }

      return $output_message;
   }

   public function createTypingMessage( $config, $userMessage ) {

     $jsonData = '
     {
          "recipient":{
            "id":"' . $userMessage['sender'] . '"
          },
          "sender_action":"typing_on"
     }
     ';

     return $jsonData;
   }

   private function createSimpleMessage( $config, $userMessage ) {

      //The JSON data.
      $recipient = '"recipient":{ "id":"' . $userMessage['sender'] . '" },';

      $jsonData = '{' . $recipient . '"message":{ "text":"' . $this->output_message . '" } }';

      return $jsonData;
   }      

   private function createLocationMessage( $config, $userMessage ) {
      //The JSON data.
      $recipient = '"recipient":{ "id":"' . $userMessage['sender'] . '" },';

      /*
      $quick_replies = '
      ,"quick_replies":[
        { "content_type":"location" },
        {
          "content_type":"text",
          "title":"Another topic",
          "payload":"",
          "image_url":"https://scontent.xx.fbcdn.net/v/t1.0-1/p64x64/14202714_10153943944975735_698527639693796816_n.jpg?oh=2ddd96b7e22b049ce9acdfb549c07534&oe=58E7C6D9"
        }
      ]';
      */

      $quick_replies = '
      ,"quick_replies":[
        { "content_type":"location" }
      ]';
      $jsonData = '{' . $recipient . '"message":{ "text":"' . $this->output_message . '"' . $quick_replies . ' } }';

      return $jsonData;
   }

   private function createTopicMessage( $config, $userMessage ) {

    $jsonData = '
    {
      "recipient":{
        "id":"' . $userMessage['sender'] . '"
      },
      "message":{
          "attachment":{
            "type":"template",
            "payload":{
              "template_type":"generic",
              "elements":[
                 {
                  "title":"' . $this->output_message . '",
                  "image_url":"http://www.schremser.com/blog/wp-content/uploads/2016/12/cropped-11864849_10153095746145735_5213170729128279726_o.jpg",
                  "subtitle":"The TOPIC page.",
                  "default_action": {
                    "type": "web_url",
                    "url": "http://schremser.com"
                  },
                  "buttons":[
                    {
                      "type":"web_url",
                      "url":"http://schremser.com",
                      "title":"Topic: Schremser"
                    },
                    {
                      "type":"web_url",
                      "url":"http://tricoretraining.com",
                      "title":"Topic: Triathlon"
                    },                    
                    {
                      "type":"postback",
                      "title":"Start Chatting",
                      "payload":"X"
                    }              
                  ]      
                }
              ]
            }
          }
        }
      }';

      return $jsonData;

   }

   private function createComplexMessage( $config, $userMessage ) {

    // show video
    $jsonData = '
    {
      "recipient":{
        "id":"' . $userMessage['sender'] . '"
      },
      "message":{
        "attachment":{
          "type":"video",
          "payload":{
            "url":"www.sample-videos.com/video/mp4/480/big_buck_bunny_480p_10mb.mp4"
          }
        }
      }
    }';


    $jsonData = '
    {
       "recipient":{
          "id":"' . $userMessage['sender'] . '"
       },
       "message": {
        "attachment": {
            "type": "template",
            "payload": {
                "template_type": "list",
                "elements": [
                  {
                      "title": "Classic T-Shirt Collection (list)",
                      "image_url": "http://www.teesnthings.com/ProductImages/ladies-t-shirts/plain-tee-shirt.jpg",
                      "subtitle": "See all our colors",
                      "default_action": {
                          "type": "web_url",
                          "url": "https://a2530214.ngrok.io/chatbot/"
                      },
                      "buttons": [
                          {
                              "title": "View",
                              "type": "web_url",
                              "url": "https://peterssendreceiveapp.ngrok.io/collection"   
                          }
                      ]
                  },
                  {
                      "title": "Classic White T-Shirt",
                      "image_url": "http://www.teesnthings.com/ProductImages/ladies-t-shirts/plain-tee-shirt.jpg",
                      "subtitle": "100% Cotton, 200% Comfortable",
                      "default_action": {
                          "type": "web_url",
                          "url": "https://peterssendreceiveapp.ngrok.io/view?item=100"
                      },
                      "buttons": [
                       {
                           "type":"phone_number",
                           "title":"Call Representative",
                           "payload":"+15105551234"
                        }

                      ]                
                  },
                  ],
                   "buttons": [
                      {
                          "title": "View More",
                          "type": "postback",
                          "payload": "payload"                        
                      }
                  ]  
            }
        }
      }
    
    }';

   $jsonData[] = '
   {
      "recipient":{
        "id":"' . $userMessage['sender'] . '"
      },
      "message":{
        "attachment":{
          "type":"template",
          "payload":{
            "template_type":"button",
            "text":"What do you want to do next? (button)",
            "buttons":[
              {
                "type":"web_url",
                "url":"https://petersapparel.parseapp.com",
                "title":"Show Website"
              },
              {
                "type":"postback",
                "title":"Start Chatting",
                "payload":"USER_DEFINED_PAYLOAD"
              }
            ]
          }
        }
      }
    }';

   $jsonData[] = '
    {
      "recipient":{
        "id":"' . $userMessage['sender'] . '"
      },
        "message":{
          "attachment":{
            "type":"template",
            "payload":{
              "template_type":"generic",
              "elements":[
                 {
                  "title":"Welcome to be.ENERGISED (generic)",
                  "image_url":"https://beenergisedportalscache.blob.core.windows.net/beenergised-web/2016/08/logo_new.png",
                  "subtitle":"The Charge Point Management Platform. Best one.",
                  "default_action": {
                    "type": "web_url",
                    "url": "https://beenergised.com"
                  },
                  "buttons":[
                    {
                      "type":"web_url",
                      "url":"http://schremser.com",
                      "title":"View Website"
                    },{
                      "type":"postback",
                      "title":"Start Chatting",
                      "payload":"DEVELOPER_DEFINED_PAYLOAD"
                    }              
                  ]      
                }
              ]
            }
          }
        }
      }';

/*
      //The JSON data.
      $recipient = '"recipient":{ "id":"' . $userMessage['sender'] . '" },';

      $quick_replies = ',"quick_replies":[
      { "content_type":"location" },
      {
        "content_type":"text",
        "title":"Green x (text+quick_replies)",
        "payload":"Whatttt",
        "image_url":"https://scontent.xx.fbcdn.net/v/t1.0-1/p64x64/14202714_10153943944975735_698527639693796816_n.jpg?oh=2ddd96b7e22b049ce9acdfb549c07534&oe=58E7C6D9"
      }
      ]';
      $quick_replies = '';

      $jsonDatax[] = '{' . $recipient . '"message":{ "text":"' . $userMessage['to_reply'] . '"' . $quick_replies . ' } }';

      $rand = rand(0, count( $jsonData )-1 );
      if ( $config->debug == true ) {
         echo "Reply: " . $userMessage['to_reply'] . "<br /><br />" . $jsonData[$rand];
      }
*/

      return $jsonData;
   }

}
