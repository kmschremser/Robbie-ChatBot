<?php

class ChatReply {
   
   function __construct() {

   }

   public function createTypingMessage( $userID ) {

     $jsonData = '
     {
          "recipient":{
            "id":"' . $userID . '"
          },
          "sender_action":"typing_on"
     }';

     return $jsonData;
   }

   public function createGreetingMessage( $userID ) {

      $jsonData = '{
        "setting_type":"greeting",
        "greeting":{
          "text":"Hi {{user_first_name}}, welcome to Robbi chatbot."
        }
      }';

      return $jsonData;
   }

   public function createSimpleMessage( $userID, $message ) {

      $jsonData = '{ "recipient":{ "id":"' . $userID . '" }, "message":{ "text":"' . $message . '" } }';

      return $jsonData;
   }      

   public function createLocationMessage( $userID, $message ) {

      $quick_replies = '
      ,"quick_replies":[
        { "content_type":"location" }
      ]';

      $jsonData = '{"recipient":{ "id":"' . $userID . '" },"message":{ "text":"' . $message . '"' . $quick_replies . ' } }';

      return $jsonData;
   }

   public function createTopic2Message( $userID, $message ) {
      
      $quick_replies = '
      ,"quick_replies":[
        {
          "content_type":"text",
          "title":"HELP",
          "payload":"X",
          "image_url":"https://scontent.xx.fbcdn.net/v/t1.0-1/p64x64/14202714_10153943944975735_698527639693796816_n.jpg?oh=2ddd96b7e22b049ce9acdfb549c07534&oe=58E7C6D9"
        },
        {
          "content_type":"text",
          "title":"Follow me",
          "payload":"x",
          "image_url":"https://scontent.xx.fbcdn.net/v/t1.0-1/p64x64/14202714_10153943944975735_698527639693796816_n.jpg?oh=2ddd96b7e22b049ce9acdfb549c07534&oe=58E7C6D9"
        },
        {
          "content_type":"text",
          "title":"Charging stations",
          "payload":"x",
          "image_url":"https://scontent.xx.fbcdn.net/v/t1.0-1/p64x64/14202714_10153943944975735_698527639693796816_n.jpg?oh=2ddd96b7e22b049ce9acdfb549c07534&oe=58E7C6D9"
        },
                        {
          "content_type":"text",
          "title":"Triathlon",
          "payload":"X",
          "image_url":"https://scontent.xx.fbcdn.net/v/t1.0-1/p64x64/14202714_10153943944975735_698527639693796816_n.jpg?oh=2ddd96b7e22b049ce9acdfb549c07534&oe=58E7C6D9"
        },
        {
          "content_type":"text",
          "title":"Books",
          "payload":"x",
          "image_url":"https://scontent.xx.fbcdn.net/v/t1.0-1/p64x64/14202714_10153943944975735_698527639693796816_n.jpg?oh=2ddd96b7e22b049ce9acdfb549c07534&oe=58E7C6D9"
        },
        {
          "content_type":"text",
          "title":"Charging stations",
          "payload":"x",
          "image_url":"https://scontent.xx.fbcdn.net/v/t1.0-1/p64x64/14202714_10153943944975735_698527639693796816_n.jpg?oh=2ddd96b7e22b049ce9acdfb549c07534&oe=58E7C6D9"
        } 
      ]';

      $jsonData = '{"recipient":{ "id":"' . $userID . '" },"message":{ "text":"' . $message . '"' . $quick_replies . ' } }';

      return $jsonData;
   }

   public function createTopicMessage( $userID, $message ) {

    $jsonData = '
    {
      "recipient":{
        "id":"' . $userID . '"
      },
      "message":{
          "attachment":{
            "type":"template",
            "payload":{
              "template_type":"generic",
              "elements":[
                 {
                  "title":"' . $message . '",
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

/*
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


      return $jsonData;
   }

*/

}
