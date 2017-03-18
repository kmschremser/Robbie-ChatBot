<?php

ini_set('memory_limit', '1024M');

// morphed object oriented programming to half-functional :)

// TODO
date_default_timezone_set("UTC");

include( './libs/ConfigClass.inc.php' );
include( './libs/LogClass.inc.php' );
include( './libs/PersonClass.inc.php' );
include( './libs/ChatReplyClass.inc.php' );
include( './libs/CommunicationClass.inc.php' );
include( './libs/NaturalLanguageProcessingClass.inc.php' );

include( './bot.nlp/bot_brain_replace.inc.php' );
include( './bot.nlp/bot_brain_terms.inc.php' );

$log_line = array();
$log_status = true;

$config = new Config();

// a new line
$log_line[] = array( "----------------------------------------------------------------", "--------------" );
$log_line[] = array( memory_get_usage(), "memory start" );

$communication = new Communication();

// in case of verification
if ( $_REQUEST['hub_verify_token'] ) {
	
	echo $communication->fbVerify( $_REQUEST['hub_challenge'], $_REQUEST['hub_verify_token'], $config->verify_token );
} 

if ( $_REQUEST['debug'] === "true" ) {
	$config->debug = true;
	$config->show_form = true;

	include( './tpl/InputForm.tpl.inc.php' );

	$senderID = '007';
	$userMessage = $_POST['userMessage'];

} else {
	// get user's message
	list( $senderID, $userMessage, $inputArray ) = $communication->getInputs();
}

// no receive notification // my user
if ( $senderID == '559855984223933' || 
	isset( $inputArray['input']['entry'][0]['messaging'][0]['delivery']['watermark'] ) || 
	isset( $inputArray['input']['entry'][0]['messaging'][0]['read']['watermark'] ) ) { 

	$log_status = false; 
}

if ( $log_status === true ) {
	$log_line[] = array( $start_memory, $senderID . "-memory-start"  );
}

$log_line[] = array( $senderID, "senderID" );

// new person
$person = new Person();

// load person data from fs
if ( isset( $senderID ) ) {
	$props = unserialize( $person->loadUserProfile( $senderID ) );
	$person->props = $props;

	$person->setPersonProperty( "fb_sender_id", $senderID );
} else {
	//echo "Houston, we have a problem! No senderID. ";
}

// initiate chat typing
$chat = new ChatReply();

if ( $config->show_form === false && $senderID ) {

	// Greeting // TODO 
	//$jsonDataReply = $chat->createGreetingMessage( $senderID );

	// send reply
	//$communication->initCommunication( $config->createFbUrl(), $jsonDataReply );

	$log_line[] = array( $config->createFbUrl(), "createTypingMessage" );

	// Typing
	$jsonDataReply = $chat->createTypingMessage( $senderID );

	// send reply
	$communication->initCommunication( $config->createFbUrl(), $jsonDataReply );

	//sleep(1);
}

// initiate nlp
$nlp = new NaturalLanguageProcessing();

// remove breaks
$userMessage_modified = $nlp->removeBreaks( $userMessage );

// replace quotes
$userMessage_modified = $nlp->replaceQuotes( $userMessage_modified );

// guess the language
$language = $nlp->guessLanguage( $config->languageDetector_url, $userMessage_modified, $config->default_language );
if ( isset( $language ) ) $person->setPersonProperty( "chatLanguage", $language );

// bring it to upper case
$userMessage_modified = $nlp->upperCaseText( $userMessage_modified );

// simplify request
$userMessage_modified = $nlp->replaceSlang( $replace_pattern['term'], $replace_pattern['replace'], $userMessage_modified );

$log_line[] = array( $userMessage_modified, "userMessage_modified" );

// analyse answers
list( $returnAnswers, $intentions, $answer_types ) = $nlp->analyzeText( $userMessage_modified, $pattern, $person, $config );

// build answer array
$returnMessages = $nlp->buildAnswer( $returnAnswers, $person, $pattern['variables'] );

$i = 0;
// send message per entry in array
foreach ( $returnMessages as $returnMessage ) {

	// set property to each message
	// TODO strip slashes in message
	if ( "$answer_types[$i]" === "location" ) {
		$jsonDataReply = $chat->createLocationMessage( $senderID, $returnMessage );

	} elseif ( "$answer_types[$i]" === "topic" ) {
		$jsonDataReply = $chat->createTopicMessage( $senderID, $returnMessage );

	} elseif ( "$answer_types[$i]" === "quick_topics" ) {
		$jsonDataReply = $chat->createTopic2Message( $senderID, $returnMessage );
		
	} else {
		$jsonDataReply = $chat->createSimpleMessage( $senderID, $returnMessage );
	}

	$log_line[] = array( serialize($returnMessage), "returnMessage" );

	$log_line[] = array( $jsonDataReply, "jsonDataReply" );

	if ( $config->show_form === false ) {

		// send reply
		$communication->initCommunication( $config->createFbUrl(), $jsonDataReply );

	} else {

		echo "<br><br><strong>" . $returnMessage . "</strong><br><br>"; echo $jsonDataReply . "<br>";

		$log_line[] = array( $jsonDataReply, "Reply-JSON" );
		//$log_line[] = array( serialize( get_object_vars( $person ) ), "Person-Object" );

	}
	// count
	$i++;
}

$log_line[] = array( memory_get_usage(), "memory end - " . $senderID );
$log_line[] = array( memory_get_peak_usage(), "memory peak - " . $senderID );

if ( isset( $senderID ) ) { 
	// set last activitiy
	$person->setPersonProperty( "last_activity", time() );
	$person->saveUserProfile( $senderID, serialize( $person->props ), $intentions['ot']['user_wants_to_reset'] );
	if ( $config->show_form ) echo "<br><br>DEBUG: "; print_r( $person );
}

$log_line[] = array( serialize( $person->props ), $senderID . " - person object" );

if ( $log_status === true )	{
	$conversation = new FileLogger( __DIR__.'/log/' . $senderID . '-conversation.txt' );
	$conversation->log( $senderID . " - " . $userMessage . " - " . implode( ",", $returnMessages ), "conversation-log" );

	$logger = new FileLogger( __DIR__.'/log/logger.txt' );
	$logtext = "";

	for ( $i = 0; $i < count( $log_line ); $i++ ) {
		$logtext .= $log_line[$i][0] . " - " . $log_line[$i][1] . "\n";
	}
	$logger->log( $logtext, "logger" );
}


