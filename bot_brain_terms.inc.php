<?php

$pattern['answers']['salutation']['question'] = "/HELLO/";
$pattern['answers']['salutation']['replies']['alreadyasked'][] = "Hello again. ";
$pattern['answers']['salutation']['replies']['alreadyasked'][] = "We already greeted. ";
$pattern['answers']['salutation']['replies']['morning'] = "Good morning. ";
$pattern['answers']['salutation']['replies']['noon'] = "Happy noon. ";
$pattern['answers']['salutation']['replies']['afternoon'] = "Good afternoon. ";
$pattern['answers']['salutation']['replies']['evening'] = "Good evening. ";
$pattern['answers']['salutation']['replies']['night'] = "I wish you a great night. ";
$pattern['answers']['salutation']['replies']['botname'] = ""; //My name is {bot.name}. ";
$pattern['answers']['salutation']['replies']['feeling'] = "Type 'HELP' for some hints. How are you doing? ";

$pattern['answers']['feeling']['question'] = "/HOW ARE YOU|HOW R U/";
$pattern['answers']['feeling']['replies']['directanswer'][] = "How am I? Great. Thanks. ";
$pattern['answers']['feeling']['replies']['directanswer'][] = "How am I? Awesome. At least my mood-chip is telling me this ;). ";
$pattern['answers']['feeling']['replies']['alreadyasked'][] = "Great Thanks. My mood didn't change from the last time you asked ;). ";
$pattern['answers']['feeling']['replies']['alreadyasked'][] = "Still great. Thanks. ";

$pattern['answers']['feeling_good_answer']['question'] = "/I AM FINE/";
$pattern['answers']['feeling_good_answer']['replies'][] = "Perfect, I'm really glad to hear that! ";
$pattern['answers']['feeling_good_answer']['replies'][] = "Great, then my mood is skyrocketing :). ";


$pattern['answers']['feeling_bad_answer']['question'] = "/I AM UNHAPPY/";
$pattern['answers']['feeling_bad_answer']['replies'][] = "I'm really sorry to hear that. ";
$pattern['answers']['feeling_bad_answer']['replies'][] = "All of us have bad days. But good ones will follow :). ";

$pattern['answers']['help_unhappy']['replies'] = "Then how can I help you and maybe improve your mood? ";

$pattern['answers']['askname']['question'] = "/WHAT IS YOUR NAME/";
$pattern['answers']['askname']['replies'][] = "Great that you ask. My name is {bot.name}! ";
$pattern['answers']['askname']['replies'][] = "Sire, you can call me {bot.name}! ";
$pattern['answers']['askname']['replies'][] = "You can call me however you want :). But I'm {bot.name}. ";
$pattern['answers']['already_askname']['replies'][] = "Same name as you asked before - {bot.name} :) ";

$pattern['find']['askyourname'] = "/MY NAME IS (.+)|I AM (^IN )(.+)\./";
$pattern['answers']['askyourname']['replies'][] = "What's your name please? ";
$pattern['answers']['askyourname']['replies'][] = "I want to get to know you. What's your name? ";
$pattern['answers']['askyourname_reply']['replies'] = "Great to meet you, {user.firstname} ";

$pattern['find']['askyouremail'] = "/MY EMAIL IS (.+)/";
$pattern['answers']['askyouremail']['replies'][] = "As I need it to help you, can you tell me your email please? (Say NO to make me stop asking) ";
$pattern['answers']['askyouremail_reply']['replies'] = "Great {user.firstname}. I saved it for our later conversations. ";
$pattern['answers']['askyouremail_wrongemail']['replies'] = "Nope, no valid email. Guess, you don't wanna tell me :(. ";
$pattern['answers']['askyouremail_reply_no']['replies'] = "/^NO($|\s|\.|!)/";
$pattern['answers']['askyouremail_reply_no_ok']['replies'] = "Okily dokily. You can tell me later. ";

$pattern['answers']['time']['question'] = "/WHAT TIME IS IT/";
$pattern['answers']['time']['replies'][] = "Time for a chat :). It is {bot.time}. ";
$pattern['answers']['time']['replies'][] = "Always too late. It is {bot.time}. ";
$pattern['answers']['time']['replies'][] = "Look on your device ;). It is {bot.time}. ";
$pattern['answers']['time']['replies_nolocation'] = "But only where I live. I need your location to give you your time. Accept location service or sent city and country please. ";

$pattern['answers']['date']['question'] = "/WHAT DATE IS TODAY/";
$pattern['answers']['date']['replies'][] = "Today is {bot.date}. ";

$pattern['answers']['age']['question'] = "/HOW OLD ARE YOU|WHEN IS YOUR BIRTHDAY/";
$pattern['answers']['age']['replies'][] = "I'm young. I'm " . round( ( time() - strtotime( "24.12.2016" ) ) / 86400, 2 ) . " days old. ";
$pattern['answers']['age_askback']['replies'] = "By the way, when is your birthday?? ";

$pattern['find']['age']['question'] = "/I AM (.+) YEARS OLD/";

$pattern['find']['birthday']['question'] = "/MY BIRTHDAY IS ON THE (.+)/";
$pattern['answers']['birthday']['replies'][] = "Young as young can be. ";
$pattern['answers']['birthday']['replies'][] = "Now I can congratulate on your birthday. Awesome. ";
$pattern['answers']['birthday_today']['replies'] = "Hej. This is today. Happy birthday! https://www.youtube.com/watch?v=inS9gAgSENE ";
$pattern['answers']['birthday_toyoung']['replies'] = "Sorry, you're tooooo young. Please try again. ";
$pattern['answers']['no_birthday']['replies'] = "You don't wanna tell me your birthday :(. I'm sad. Tell me 'No' in case I should stop bothering you. ";
$pattern['find']['no_birthday']['replies'] = "/NO/";

$pattern['answers']['weather']['question'] = "/WHAT IS THE WEATHER LIKE/";
$pattern['answers']['weather']['replies'][] = "Not the weather is your problem, it's always the equipment :). The weather forecast for your area is ";
$pattern['answers']['weather_location']['replies'] = "I need your location to give you an accurate forecast. :) Please enter city and country. ";

$pattern['find']['location']['question'] = "/I AM IN (.+)(\s|$|!|\.)/";
$pattern['find']['location']['question2'] = "/^(.+)(,)(.+)$|^(.+)$/";

$pattern['answers']['location']['replies'][] = "Nice place. I will remember your location. ";
$pattern['answers']['location']['replies'][] = "I wish I could be there. Awesome place. Will try to remember this. ";
$pattern['answers']['nolocation']['replies'][] = "It would be super interesting to know where you are? Either you enable your location or send me the city and country where you are right now. Thanks. ";
$pattern['answers']['nocountry_location']['replies'] = "Can you add the country to the city where you are right now, please. My capabilities are a little bit limited yet. Or maybe I have not record of your country. Thanks. ";

$pattern['answers']['likes']['question'] = "/I LIKE (.+)|I LOVE (.+)/";

$pattern['answers']['profile']['question'] = "/SHOW MY PROFILE|SHOW PROFILE/";
$pattern['find']['reset'] = "/RESET PROFILE/";

$pattern['find']['rule']['questions'][] = array( "/WHAT IS MY NAME/", array( "Your name is {user.firstname}." ), "firstname", "I'm sorry. You didn't tell me or I forgot it :(. " );
$pattern['find']['rule']['questions'][] = array( "/WHERE AM I/", array( "You are in {user.location}." ), "location", "I'm sorry. You didn't tell me or I forgot it :(. " );
$pattern['find']['rule']['questions'][] = array( "/HOW AM I/", array( "You are {user.mood}." ), "mood", "I'm sorry. You didn't tell me or I forgot it :(. " );

$pattern['find']['questions'][] = array( "/TI AMO/", array("Ti voglio un mondo di bene. ") );
$pattern['find']['questions'][] = array( "/WHO ARE YOU|WHAT ARE YOU/", array("I'm {bot.name} and a simple chatbot for Facebook messenger. ") );
$pattern['find']['questions'][] = array( "/I LOVE YOU|KISS ME|I WANT YOU|I LIKE YOU|^LIKE YOU|^LOVE YOU/", array("I heard this many times today. But it's good to hear :) <3. ", "I can only send this back <3 <3 <3. ") );
$pattern['find']['questions'][] = array( "/IDIOT /", array("1$ into the swear glass!!! ", "Lalala La Bamba. I ignore your swearing. ", "I have a repository of 3.98 millions insults, but I won't use it. :) ") );
$pattern['find']['questions'][] = array( "/GOOD BYE/", array("Thank you for chatting with us today. Have a nice day. Good bye. ", "If any other questions arise, please feel free to contact us at any time. Thanks so much for calling. Good bye. ") );
$pattern['find']['questions'][] = array( "/KANNST DU (AUCH) DEUTSCH|SPRICHST DU (AUCH) DEUTSCH|STERREICHISCH\?/", array( "Noch nicht. Ein bisschen noch warten :). " ) );
$pattern['find']['questions'][] = array( "/^HELP|WHAT CAN I DO/", array( "You can talk with my about the following topics: - your name/my name, how you are and how I am, email, birthday, weather, location, time, date, search for topic, 'reset profile', 'show my profile' " ) );

$pattern['answers']['weathertimedate']['replies'][] = "You can also ask me about the weather, time or date - just in case you wanted to know ;). ";

$pattern['find']['help']['question'] = "/I HAVE A PROBLEM|I HAVE GOT A PROBLEM|CAN YOU HELP ME|^HELP ME|THERE IS A PROBLEM/";
$pattern['answers']['help']['replies'][] = "How may I help you today? You can ask me anything (especially about the weather, time, date) ;) ";

$pattern['find']['askforsearch'] = "/SEARCH FOR /";
$pattern['answers']['askforsearch']['question'] = "/SEARCH FOR (.+)(\s|$|!|\.)/";
$pattern['answers']['search']['replies'][] = "Here is what I found: ";
$pattern['answers']['nosearch']['replies'][] = "Couldn't find anything for this topic. Sorry. ";

$pattern['variables']['bot.name'] = "Robbi";
$pattern['variables']['bot.time'] = date( "H:i", time() );
$pattern['variables']['bot.date'] = date( "Y-m-d", time() );

$pattern['noidea']['replies'][] = "I have absolutely no idea what you're talking about. I feel like a Intel 386 :(. ";
$pattern['noidea']['replies'][] = "Hablo Espanol? :) ";
$pattern['noidea']['replies'][] = "Ich nix verstehn. Anderes Baustelle? :) ";

