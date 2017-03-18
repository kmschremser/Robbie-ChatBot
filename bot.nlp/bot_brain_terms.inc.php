<?php

$smiley_bot = "🤖";
$smiley_love = "😍";
$smiley_others = "";

$pattern['find']['salutation']['question'] = "/HELLO/";
$pattern['answers']['salutation']['alreadyasked'][] = "Hello again. ^_^ ";
$pattern['answers']['salutation']['alreadyasked'][] = "We already greeted. ^_^ ";
$pattern['answers']['salutation']['morning'] = "Good morning. " . $smiley_love . " " . $smiley_bot . " ";
$pattern['answers']['salutation']['noon'] = "Happy noon. B-) " . $smiley_love . " " . $smiley_bot . " ";
$pattern['answers']['salutation']['afternoon'] = "Good afternoon. " . $smiley_love . " " . $smiley_bot . " ";
$pattern['answers']['salutation']['evening'] = "Good evening. " . $smiley_love . " " . $smiley_bot . " ";
$pattern['answers']['salutation']['night'] = "I wish you a great night. " . $smiley_love . " " . $smiley_bot . " ";

$pattern['answers']['salutation']['feeling'] = "How are you doing? ";

$pattern['find']['feeling']['question'] = "/HOW ARE YOU/";
$pattern['answers']['feeling']['directanswer'][] = "How am I? Great. :D Thanks. :D ";
$pattern['answers']['feeling']['directanswer'][] = "How am I? Awesome. :D At least my mood-chip is telling me this ;). ";
$pattern['answers']['feeling']['alreadyasked'][] = "Great. Thanks. :D  :* My mood didn't change from the last time you asked ;). ";
$pattern['answers']['feeling']['alreadyasked'][] = "Still great. Thanks. :* :* ";

$pattern['find']['feeling_good_answer']['question'] = "/I AM FINE/";
$pattern['answers']['feeling_good_answer'][] = "Perfect, I'm really glad to hear that! ";
$pattern['answers']['feeling_good_answer'][] = "Great, then my mood is skyrocketing :). ";

$pattern['find']['feeling_bad_answer']['question'] = "/I AM UNHAPPY/";
$pattern['answers']['feeling_bad_answer'][] = "I'm really sorry to hear that. ";
$pattern['answers']['feeling_bad_answer'][] = "All of us have bad days. But good ones will follow :). ";

$pattern['answers']['help_unhappy'] = "Then how can I help you and maybe improve your mood? ";

$pattern['find']['askname']['question'] = "/WHAT IS YOUR NAME/";
$pattern['answers']['askname'][] = "Great that you ask. My name is {bot.name}! ";
$pattern['answers']['askname'][] = "Sire, you can call me {bot.name}! ";
$pattern['answers']['askname'][] = "You can call me however you want :). But I'm {bot.name}. ";
$pattern['answers']['already_askname'][] = "Same name as you asked before - {bot.name} :) ";

$pattern['find']['tellsusername'] = "/MY NAME IS (.+)$/";
$pattern['answers']['tellsusername_reply'] = "Great to meet you, {user.firstname} ";

$pattern['answers']['askusername'][] = "What's your name please? ";
$pattern['answers']['askusername'][] = "I want to get to know you. What's your name? ";

$pattern['find']['askyouremail'] = "/MY EMAIL IS (.+)/";
$pattern['answers']['askyouremail'][] = "As I need it to help you, can you tell me your email please? (Say NO to make me stop asking) ";
$pattern['answers']['askyouremail_reply'] = "Great {user.firstname}. I saved it for our later conversations. ";
$pattern['answers']['askyouremail_wrongemail'] = "Nope, no valid email. Please try again. ";
$pattern['answers']['askyouremail_reply_no'] = "/^NO($|\s|\.|!)/";
$pattern['answers']['askyouremail_reply_no_ok'] = "Okily dokily. You can tell me later. ";

$pattern['find']['time']['question'] = "/WHAT TIME IS IT/";
$pattern['answers']['time'][] = "Time for a chat :). It is {bot.time}. ";
$pattern['answers']['time'][] = "Always too late. It is {bot.time}. ";
$pattern['answers']['time'][] = "Look on your device ;). It is {bot.time}. ";
$pattern['answers']['time']['replies_nolocation'] = "But only where I live. I need your LOCATION to show you your time. Accept location service or write me your CITY and COUNTRY please. ";

$pattern['find']['date']['question'] = "/WHAT DATE IS TODAY/";
$pattern['answers']['date'][] = "Today is {bot.date}. ";

$pattern['find']['age']['question'] = "/HOW OLD ARE YOU|WHEN IS YOUR BIRTHDAY/";
$pattern['answers']['age'][] = "I'm young. I'm " . round( ( time() - strtotime( "24.12.2016" ) ) / 86400, 2 ) . " days old. ";

$pattern['answers']['age_askback'][] = "By the way, when is your birthday?? ";

$pattern['find']['birthday']['question'] = "/MY BIRTHDAY IS ON THE (.+)$/";
$pattern['answers']['birthday'][] = "Young as young can be. ";
$pattern['answers']['birthday'][] = "Now I can congratulate on your birthday. Awesome. ";
$pattern['answers']['birthday_today'] = "Hej. This is today. Happy birthday! https://www.youtube.com/watch?v=inS9gAgSENE ";
$pattern['answers']['birthday_toyoung'] = "Sorry, either you're tooooo young or you didn't give me your birthDATE. Please try again. %-) ";
$pattern['answers']['no_birthday'] = "You don't wanna tell me your birthday :(. I'm sad. Tell me 'No' in case I should stop bothering you. ";
$pattern['find']['no_birthday'] = "/^NO($|\s|\.|!)/";

$pattern['find']['weather']['question'] = "/WHAT IS THE WEATHER LIKE/";
$pattern['answers']['weather_location'] = "I need your location to give you an accurate forecast. :) Please enter city and country. ";
$pattern['answers']['weather'][] = "Not the weather is your problem, it's always the equipment :). The weather forecast for your area is ";
$pattern['answers']['weathertimedate'][] = "You can also ask me about the weather, time or date - just in case you wanted to know ;). ";

$pattern['find']['location']['question'] = "/I AM IN (.+)(\s|$|!|\.)/";
$pattern['find']['location']['question2'] = "/^(.+)(,)(.+)$|^(.+)$/";

$pattern['answers']['location'][] = "Nice place. I will remember your location. ";
$pattern['answers']['location'][] = "I wish I could be there. Awesome place. Will try to remember this. ";
$pattern['answers']['nolocation'][] = "It would be interesting to know where you are? Either you enable your LOCATION or write me the CITY and COUNTRY, where you are right now. Thanks. ";
$pattern['answers']['nocountry_location'] = "I need 'city, country' as an answer to understand your request and I know only a few countries. Sorry. Limited brain yet. B-) ";

$pattern['find']['likes']['question'] = "/I LIKE (.+)|I LOVE (.+)/";
$pattern['find']['dontlikes']['question'] = "/I DO NOT LIKE (.+)|I DO NOT LOVE (.+)/";
$pattern['answers']['likes'] = "Ok {user.firstname}. I will remember this. B-) ";

$pattern['find']['profile']['question'] = "/SHOW MY PROFILE|SHOW PROFILE/";
$pattern['find']['reset'] = "/RESET PROFILE|^RESTART/";
$pattern['find']['followme'] = "/I WANT TO FOLLOW YOU/";
$pattern['answers']['followme']['replies'][] = "Awesome. I will send you messages from time to time. ";

$pattern['find']['rule']['questions'][] = array( "/WHAT IS MY NAME/", array( "Your name is {user.firstname}." ), "firstname", "I'm sorry. You didn't tell me or I forgot it :(. " );
$pattern['find']['rule']['questions'][] = array( "/WHERE AM I/", array( "You are in {user.location}." ), "location", "I'm sorry. You didn't tell me or I forgot it :(. " );
$pattern['find']['rule']['questions'][] = array( "/HOW AM I/", array( "You are {user.mood}." ), "mood", "I'm sorry. You didn't tell me or I forgot it :(. " );

$pattern['find']['questions'][] = array( "/TI AMO/", array("Ti voglio un mondo di bene. ") );
$pattern['find']['questions'][] = array( "/WHO IS YOUR MAKER|WHO IS YOUR BUILDER|WHO IS YOUR DEVELOPER/", array("The GREAT KMS. %-) ") );
$pattern['find']['questions'][] = array( "/WHO ARE YOU|WHAT ARE YOU/", array("I'm {bot.name} and a simple chatbot for Facebook messenger. ") );
$pattern['find']['questions'][] = array( "/I LOVE YOU|KISS ME|I WANT YOU|I LIKE YOU|^LIKE YOU|^LOVE YOU/", array("I heard this many times today. But it's good to hear :) <3. ", "I can only send this back <3 <3 <3. ") );
$pattern['find']['questions'][] = array( "/IDIOT /", array("1$ into the swear glass!!! ", "Lalala La Bamba. I ignore your swearing. ", "I have a repository of 3.98 millions insults, but I won't use it. :) ") );
$pattern['find']['questions'][] = array( "/GOOD BYE/", array("Thank you for chatting with us today. Have a nice day. Good bye. ", "If any other questions arise, please feel free to contact us at any time. Thanks so much for calling. Good bye. ") );
$pattern['find']['questions'][] = array( "/KANNST DU (AUCH) DEUTSCH|SPRICHST DU DEUTSCH|STERREICHISCH\?/", array( "Noch nicht. Ein bisschen noch warten :). " ) );
//$pattern['find']['questions'][] = array( "/^HELP|WHAT CAN I DO|CAN YOU HELP ME/", array( "You can talk with my about the following topics: - your name/my name, how you are and how I am, email, birthday, weather, location, time, date, search for topic, 'reset profile', 'show my profile' " ) );

$pattern['find']['help']['question'] = "/I HAVE A PROBLEM|I HAVE GOT A PROBLEM|CAN YOU HELP ME|^HELP ME|THERE IS A PROBLEM/";
$pattern['answers']['help'][] = "How may I help you today? Use the suggested topics or tell me what you're looking for? Search for [TERM]. ;) ";

$pattern['find']['askforsearch']['question'] = "/SEARCH FOR (.+)(\s|$|!|\.)/";
$pattern['answers']['search'][] = "Here is what I found: ";
$pattern['answers']['nosearch'][] = "Couldn't find anything for this topic. Sorry. ";

$pattern['find']['debug'] = "/DEBUG/";

$pattern['variables']['bot.name'] = "Robbi";
$pattern['variables']['bot.time'] = date( "H:i", time() );
$pattern['variables']['bot.date'] = date( "Y-m-d", time() );

$pattern['answers']['noidea'][] = "I have absolutely no idea what you're talking about. I feel like an Intel 386 :(. Try some topics. ";
$pattern['answers']['noidea'][] = "Try to say it in other words. I don't get it. Sorry. :(. Try some topics. ";
//$pattern['answers']['noidea'][] = "Hablo Espanol? :) ";
//$pattern['answers']['noidea'][] = "Ich nix verstehn. Anderes Baustelle? :) ";

