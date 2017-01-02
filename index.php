<?php

// based on 
// http://blog.adnansiddiqi.me/develop-your-first-facebook-messenger-bot-in-php/
// alternative https://github.com/Program-O/Program-O
// https://www.producthunt.com/posts/init-ai-2
// https://docs.api.ai/#section-cards
//https://b656144b.ngrok.io/chatbot/

// TODO
date_default_timezone_set("UTC");

include( './ConfigClass.inc.php' );
include( './SessionClass.inc.php' );
include( './LogClass.inc.php' );
include( './PersonClass.inc.php' );
include( './ChatReplyClass.inc.php' );
include( './CommunicationClass.inc.php' );
include( './NaturalLanguageProcessingClass.inc.php' );
include( './PosTagger.inc.php' );

include( './bot_brain_replace.inc.php' );
include( './bot_brain_terms.inc.php' );

$config = new Config();
$session = new Session();
$session->config = $config;

// https://github.com/gehaxelt/PHP-Logger-Class/blob/master/tests/index.php

$log = new FileLogger( __DIR__.'/log/logger.txt' );
$conversation = new FileLogger( __DIR__.'/log/conversation.txt' );
$log->log( "----------------------------------------------------------------", "--------------" );

$session->log = $log;
$config->debug = true;

if ( isset( $_REQUEST['debug'] ) ) { $config->show_form = true; $config->debug = true; }

if ( $config->debug === true && 1 == 2 ) $start_memory = memory_get_usage();

// in case of verification
// https://developers.facebook.com/apps/245593865870595/messenger/settings/
if ( $_REQUEST['hub_verify_token']) {
	$communication_verify = new Communication();
	echo $communication_verify->fbVerify( $_REQUEST, $config );
} 

$communication = new Communication();

if ( $config->show_form === true ) {
	include( './InputForm.tpl.inc.php' );
	$userMessage['userMessage'] = $_POST['userMessage'];
	$userMessage['sender'] = '007';
    $userMessage['language'] = 'en';

} else {
	// get user's message
	$userMessage = $communication->getInputs();
}

// no receive notification // my user
if ( $userMessage['sender'] == '559855984223933' || isset( $userMessage['input']['entry'][0]['messaging'][0]['delivery']['watermark'] ) || isset( $userMessage['input']['entry'][0]['messaging'][0]['read']['watermark'] ) ) { 
	$log->dontlog = true; 
}

if ( 1 == 2 ) {
	$log->log( $start_memory, $userMessage['sender'] . "-memory-start"  );
	$log->log( $userMessage['input']['entry'][0]['messaging'][0]['message']['text'], $userMessage['sender'] . "-message of user" );
	$log->log( serialize($userMessage['input']), $userMessage['sender'] . "-messages complete" );
	$log->log( $userMessage['input']['entry'][0]['messaging'][0]['delivery'][0]['watermark'], $userMessage['sender'] . "-watermark" );
}

$session->session = unserialize( $session->loadSession( $userMessage['sender'] ) );
if ( 1 == 2 ) {
	$log->log( serialize( $session->session ), "session from last request" );
}

// get user-object from session
if ( $session->getSession( $userMessage['sender'], false ) === null ) {
	$person = new Person( $session );
} else {
	$person = unserialize( $session->getSession( $userMessage['sender'], false ) );
}

$person->last_activity = time();

// set sender id from fb messenger
if ( isset( $userMessage['sender'] ) ) {
	$person->fb_sender_id = $userMessage['sender'];
}

$nlp = new NaturalLanguageProcessing( $pattern, $session, $person, $log );

/*
if ( $config->debug === true && 1 == 2 ) {

// http://phpir.com/part-of-speech-tagging
// https://en.wikipedia.org/wiki/Brown_Corpus#Part-of-speech_tags_used

	$tagger = new PosTagger( 'lexicon.en.txt' );
	$tags = $tagger->tag( $userMessage['userMessage'] );
	$tagger->printTag( $tags );

}
*/

// initiate chat typing
$chat = new ChatReply();
$chat->log = $log;

if ( $config->show_form === false ) {

	$jsonDataReply = $chat->createTypingMessage( $config, $userMessage );

	// send reply
	$communication->initCommunication( $config, $jsonDataReply, $userMessage );

	//sleep(1);
}

// initiate chat reply
$jsonDataReply = $chat->findReply( $config, $userMessage, $nlp );

if ( $config->show_form === false ) {

	// send reply
	$communication->initCommunication( $config, $jsonDataReply, $userMessage );

} else {

	if ( $config->show_form === true ) echo "<strong>" . $jsonDataReply . "</strong>\n";

	$logtxt = "Reply-JSON: " . $jsonDataReply . "\n";
	$logtxt .= "Input of user - replaced: " . $chat->input_message . "\n";	
	$logtxt .= "person->firstname: " . $person->firstname . "\n";
	$logtxt .= "person->lastname: " . $person->lastname . "\n";
	$logtxt .= "person->email: " . $person->email . "\n";
	$logtxt .= "person->mood: " . $person->mood . "\n";
	$logtxt .= "person->age: " . $person->age . "\n";
	$logtxt .= "person->birthday: " . $person->birthday . "\n";
	$logtxt .= "person->location: " . $person->location . "\n";
	//$logtxt .= "person->likes: " . print_r( $person->likes ) . "\n";

	$log->log( $logtxt, $userMessage['sender'] . "-profile"  );

}

if ( $config->debug === true && 1 == 2 ) {
	$log->log( memory_get_usage(), $userMessage['sender'] . "-memory-end"  );
	$log->log( memory_get_peak_usage(), $userMessage['sender'] . "-memory-peak"  );
}

if ( isset( $userMessage['sender'] ) ) { 
	$session->setSession( $userMessage['sender'], serialize( $person ), false );
	$session->saveSession( $userMessage['sender'], serialize( $session->session ), $nlp->delete_session );
}

if ( isset( $_REQUEST['reset'] ) ) {
	session_unset();
}

if ( $config->debug === true && 1 == 2 ) { 
	$log->log( serialize( $session->session ), $userMessage['sender'] . "-session" );
}
if ( $userMessage['sender'] !== '559855984223933' && !isset( $userMessage['input']['entry'][0]['messaging'][0]['delivery']['watermark'] ) && !isset( $userMessage['input']['entry'][0]['messaging'][0]['read']['watermark'] ) ) {
	// log conversations
	$conversation->log( $userMessage['userMessage'] . " - " . $chat->output_message, $userMessage['sender'] );

}