<?php

// http://php.net/preg_replace

class NaturalLanguageProcessing {
   
   	public $debug = true;
   	public $input_message = "";
   	public $output_message = "";
   	public $config;
   	public $pattern;
   	public $session;
   	public $log;
   	public $person;
   	public $ask_for_location = false;
   	public $ask_for_topic = false;
   	public $answer = array();
   	public $delete_session = false;

   	private $language = 'en';

   	function __construct( $pattern, $session, $person, $log ) {
   		$this->pattern = $pattern;
   		$this->session = $session;
   		$this->person = $person;
   		$this->log = $log;
   	}

	function analyzeText() {

		$this->guessLanguage();
		$this->upperCaseText();
		// remove breaks
		$this->input_message = str_replace(array("\r\n", "\r", "\n", '<BR>', '<BR />'), "", $this->input_message);
		$this->replaceSlang();

		$sentences = $this->input_message;

		// split sentences by endpoints
		// smileys are also endpoints
		$sentences = preg_split("/(?<=[.?!])\s+(?=[a-z])/i", $sentences, -1, PREG_SPLIT_NO_EMPTY );
		$sentences_split = array();
		$sentences_new = array();

		foreach ( $sentences as $sentence ) {
			$sentence_split = preg_split("/(:D|:\/|:\)|:\(|:-\(|:-\))(?=\s|[^[:alnum:]+-]|)/i", $sentence, -1, PREG_SPLIT_NO_EMPTY );
			$sentences_new = array_merge( $sentences_new, $sentence_split );
		}
		$sentences = $sentences_new;

		/*
		// go through all sentences // NOT USED YET
		for ( $i = 0; $i < count( $sentences ); $i++ ) {

			$sentence = $sentences[$i];

			if ( strpos( $sentence, '?' ) !== FALSE ) {
				$sentence_type = 'question';
			}
			
			// split words
			$words = preg_split('/ /', $sentence);
			//print_r($words); echo "<br />";
		}
		*/

		for ( $i = 0; $i < count( $sentences ); $i++ ) {
			
			if ( preg_replace( "/\s\./", "", $sentences[$i] ) === "" ) continue;

				$this->log->log( " $i - " . $sentences[$i] . "---- reset profile next", "for-each" );
			$this->resetprofile( $sentences[$i], $i );

			if ( $this->delete_session === false ) {

					$this->log->log( " $i ----- saluation next", "for-each"  );
				$this->salutation( $sentences[$i], $i );

					$this->log->log( " $i ----- feeling user next", "for-each" );
				$this->feeling_user( $sentences[$i], $i );

					$this->log->log( " $i ----- feeling bot next", "for-each" );
				$this->feeling_bot( $sentences[$i], $i );

					$this->log->log( " $i ----- name next", "for-each" );
				$this->askname( $sentences[$i], $i );

					$this->log->log( " $i ----- email next", "for-each" );
				$this->askemail( $sentences[$i], $i );

					$this->log->log( " $i ----- age next", "for-each" );
				$this->askage( $sentences[$i], $i );

					$this->log->log( " $i ----- time next", "for-each" );
				$this->asktime( $sentences[$i], $i );

					$this->log->log( " $i ----- date next", "for-each" );
				$this->askdate( $sentences[$i], $i );

					$this->log->log( " $i ----- weather next", "for-each" );
				$this->askweather( $sentences[$i], $i );

					$this->log->log( " $i ----- location next", "for-each" );
				$this->asklocation( $sentences[$i], $i );

					$this->log->log( " $i ----- likes next", "for-each" );
				$this->asklikes( $sentences[$i], $i );
				
					$this->log->log( " $i ----- topic next", "for-each" );
				$this->initiateTopic( $sentences[$i], $i );
				
					$this->log->log( " $i ----- topic next", "for-each" );
				$this->asksearch( $sentences[$i], $i );

					$this->log->log( " $i ----- everything else next", "for-each" );
				$this->everythingelse( $sentences[$i], $i );

					$this->log->log( " $i ----- profile next", "for-each" );
				$this->askprofile( $sentences[$i], $i );
			}

			//$this->log->log( $sentences[$i], $this->person->fb_sender_id . "-nlp-functions" );

			// http://www.providesupport.com/blog/customer-service-cheat-sheet-for-live-chat-support-operators-with-examples-of-responses/
		}

		$this->noidea();

		$output_message = $this->buildAnswer();

		return $output_message;	
	} 

	private function resetprofile( $sentence, $i ) {
		if ( $this->config->debug === true ) $this->log->log( "RESET PROFILE", "topic " . $this->person->fb_sender_id );

		if ( preg_match( $this->pattern['find']['reset'], $sentence, $matches ) ) {
			$this->delete_session = true;
			$this->answer[$i] .= "Session will be destroyed and profile reset. ";
		}
	}

	private function noidea() {
		if ( $this->config->debug === true ) $this->log->log( "NOIDEA", "topic " . $this->person->fb_sender_id );

		if ( count( $this->answer ) == 0 ) {
			$rand_max = count( $this->pattern['noidea']['replies'] )-1;
			$rand = rand( 0, $rand_max );
			$this->answer[0] .= $this->pattern['noidea']['replies'][$rand];
		}
	}

	private function everythingelse ( $sentence, $i ) {

		foreach ( $this->pattern['find']['questions'] as $key => $value ) {
			if ( preg_match( $value[0], $sentence ) ) {
				$rand_max = count( $value[1] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $value[1][$rand];
			}
		}	

		foreach ( $this->pattern['find']['rule']['questions'] as $key => $value ) {
			if ( preg_match( $value[0], $sentence ) ) {
				if ( $this->person->$value[2] !== "" ) {
					$rand_max = count( $value[1] )-1;
					$rand = rand( 0, $rand_max );
					$this->answer[$i] .= $value[1][$rand];
				} else {
					$this->answer[$i] .= $value[3];
				}
			}
		}
	}

	private function asksearch( $sentence, $i ) {
		if ( $this->config->debug === true ) $this->log->log( "ASKSEARCH", "topic " . $this->person->fb_sender_id );

		if ( preg_match( $this->pattern['find']['askforsearch'], $sentence ) ) {

	        preg_match( $this->pattern['answers']['askforsearch']['question'], $sentence, $matches );

			if ( count( $matches ) > 0 ) {
				$rand_max = count( $this->pattern['answers']['search']['replies'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['search']['replies'][$rand];

				$this->answer[$i] .= serialize($matches[1]);

				$this->search = true;			
			} else {
				$rand_max = count( $this->pattern['answers']['nosearch']['replies'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['nosearch']['replies'][$rand];
			}
		}
	}

	private function initiateTopic( $sentence, $i ) {
		if ( $this->config->debug === true ) $this->log->log( "ASKTOPIC", "topic " . $this->person->fb_sender_id );

		if ( preg_match( $this->pattern['find']['help']['question'], $sentence ) ) {
			$rand_max = count( $this->pattern['answers']['help']['replies'] )-1;
			$rand = rand( 0, $rand_max );
			$this->answer[$i] .= $this->pattern['answers']['help']['replies'][$rand];

			$this->session->setSession( "already_asked_for_topic", "done" );
			$this->ask_for_topic = true;			
		}

		/*
		if ( count( $this->answer ) == 0 ) {
			$rand_max = count( $this->pattern['answers']['help']['replies'] )-1;
			$rand = rand( 0, $rand_max );
			$this->answer[0] .= $this->pattern['answers']['help']['replies'][$rand];
		}
		*/
	}

	private function askprofile( $sentence, $i ) {
		if ( preg_match( $this->pattern['answers']['profile']['question'], $sentence, $matches ) ) {
			$this->answer[$i] .= serialize( $this->person );
		}
	}

	private function asklikes( $sentence, $i ) {
		if ( preg_match( $this->pattern['answers']['likes']['question'], $sentence, $matches ) ) {
			$like = preg_replace( "/( |!|\.$|\?)/", "", $matches[1] );
			$this->person->likes[$like] = true;
		}
	}

	private function askweather( $sentence, $i ) {
 		// check for answers // if question is asked
		if ( preg_match( $this->pattern['answers']['weather']['question'], $sentence ) ) {
			if ( $this->person->location === "" ) {
				$this->answer[$i] .= $this->pattern['answers']['weather_location']['replies'];
				$this->ask_for_location = true;
				$this->session->setSession( "already_askedforlocation", "done" );
				$this->session->setSession( "already_askedforweather", "done" );
			} else {
				$location = urlencode( $this->person->location );
				// https://en.wikipedia.org/wiki/ISO_3166-1
				$weather_json =  json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/forecast?q=' . $location . '&mode=json&appid=11a042b6ed7207bb28cf91a051994921'));

				$temp_kelvin = round($weather_json->list[0]->main->temp,0);
				$temp_celsius = round(($temp_kelvin-273.15),1);
				$temp_fahrenheit = ( $temp_kelvin * 9 / 5 ) - 459.67;
				$weather = " - " . $weather_json->list[0]->weather[0]->description; 
				$weather .= " (" . $temp_fahrenheit . " F, " . $temp_celsius . " C)";

				$rand_max = count( $this->pattern['answers']['weather']['replies'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['weather']['replies'][$rand] . $weather;
			}
		}

		if ( $this->person->location === "" && 
			$this->person->mood !== "" && 
			$this->person->firstname !== "" && 
			$this->person->birthday !== "" && 
			$this->session->getSession("already_askedyourbirthday") === "done" && 
			$this->session->getSession("already_askedyouremail") === "done" ) {

				$rand_max = count( $this->pattern['answers']['weathertimedate']['replies'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['weathertimedate']['replies'][$rand];			
		}

	}

	private function asklocation( $sentence, $i ) {
		// I'm in ... 
		if ( preg_match( $this->pattern['find']['location']['question'], $sentence, $matches ) ) {
			$this->session->setSession("already_askedforlocation", "done");

			// city (maybe country)
			$sentence = $matches[1];
			$match_iamin = true;
		}

		// if bot asked for location
		if ( $this->session->getSession("already_askedforlocation") === "done" ) {

			$sentence = preg_replace( "/\s|\.|!+/", "", $sentence );

			preg_match( $this->pattern['find']['location']['question2'], $sentence, $matches );	

			if ( count( $matches ) > 0 ) {
				$country_ok = false;

				foreach( $this->config->_countries as $country => $countryname ) {
					if ( strtoupper( $country ) === $matches[3] ) { $country_ok = true; }
				}

				if ( $country_ok === true ) {

					$cname = $matches[3];	

					$this->person->location = $matches[1] . "," . $this->config->_countries[$cname];

					$rand_max = count( $this->pattern['answers']['location']['replies'] )-1;
					$rand = rand( 0, $rand_max );
					$this->answer[$i] .= $this->pattern['answers']['location']['replies'][$rand];
					
					$this->session->setSession("already_askedforlocation","");
				} else {
					if ( $match_iamin === true ) $this->answer[$i] .= $this->pattern['answers']['nocountry_location']['replies'];
				}
			}

		}
			
		if ( count( $this->answer ) == 0 && $this->session->getSession("already_askedforlocation") === "done" ) {
		//if ( $this->session->getSession("already_askedforlocation") === "done" ) {			
			if ( $this->person->location === "" ) {
				$rand_max = count( $this->pattern['answers']['nolocation']['replies'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['nolocation']['replies'][$rand];
				$this->ask_for_location = true;

				$this->session->setSession("already_askedforlocation", "done");
			}
		}
		if ( $this->person->location === "" && 
			$this->person->mood !== "" && 
			$this->person->firstname !== "" && 
			$this->person->birthday !== "" && 
			$this->session->getSession("already_askedyourbirthday") === "done" && 
			$this->session->getSession("already_askedyouremail") === "done" ) {
			$rand_max = count( $this->pattern['answers']['nolocation']['replies'] )-1;
			$rand = rand( 0, $rand_max );
			$this->answer[$i] .= $this->pattern['answers']['nolocation']['replies'][$rand];
			$this->ask_for_location = true;

			$this->session->setSession("already_askedforlocation", "done");
		}
	}

	private function asktime( $sentence, $i ) {
 		// check for answers // if question is asked
		if ( preg_match( $this->pattern['answers']['time']['question'], $sentence ) ) {
			$rand_max = count( $this->pattern['answers']['time']['replies'] )-1;
			$rand = rand( 0, $rand_max );
			$this->answer[$i] .= $this->pattern['answers']['time']['replies'][$rand];

			if ( $this->person->location === "" ) {
				$this->answer[$i] .= $this->pattern['answers']['time']['replies_nolocation'];
				// TODO
				$this->ask_for_location = true;
				$this->session->setSession("already_askedforlocation", "done");
			}
		}
	}

	private function askdate( $sentence, $i ) {
 		// check for answers // if question is asked
		if ( preg_match( $this->pattern['answers']['date']['question'], $sentence ) ) {
			$rand_max = count( $this->pattern['answers']['date']['replies'] )-1;
			$rand = rand( 0, $rand_max );
			$this->answer[$i] .= $this->pattern['answers']['date']['replies'][$rand];
		}
	}

	private function askage( $sentence, $i ) {
		// User said his birthday
        preg_match( $this->pattern['find']['birthday']['question'], $sentence, $matches );
        
        // If user said her/his email or I asked him
		if ( $this->session->getSession("already_askedyourbirthday") === "done" || count( $matches ) > 0 ) {
			if ( count( $matches ) === 0 ) $matches[1] = $sentence;

			$matches[1] = preg_replace( "/( |!|\.$|\?)/", "", $matches[1] );

			if ( isset( $matches[1] ) && (bool)strtotime( $matches[1] ) ) {
				$today = date('Y', time());
				if ( strtotime( $matches[1] ) < strtotime( "$today -10 years" ) ) {
					$this->person->birthday = strtotime( $matches[1] );
					$this->session->setSession("already_knowyourbirthday", "done");
					$this->session->setSession("already_askedyourbirthday", "");

					$rand_max = count( $this->pattern['answers']['birthday']['replies'] )-1;
					$rand = rand( 0, $rand_max );
					$this->answer[$i] .= $this->pattern['answers']['birthday']['replies'][$rand];

					if ( date( "m-d", time() ) === date( "m-d", strtotime( $matches[1] ) ) ) {
						$this->answer[$i] .= $this->pattern['answers']['birthday_today']['replies'];
					}

				} else {
					$this->answer[$i] .= $this->pattern['answers']['birthday_toyoung']['replies'];
					$this->session->setSession("already_askedyourbirthday", "done");	
				}

			} elseif ( preg_match( $this->pattern['find']['no_birthday']['replies'], $sentence, $matches ) ) {
				$this->answer[$i] .= $this->pattern['find']['no_birthday']['replies'];
				$this->session->setSession("already_askedyourbirthday", "");
			}
		}

 		// check for answers // if question is asked
		if ( preg_match( $this->pattern['answers']['age']['question'], $sentence ) ) {
			$rand_max = count( $this->pattern['answers']['age']['replies'] )-1;
			$rand = rand( 0, $rand_max );
			$this->answer[$i] .= $this->pattern['answers']['age']['replies'][$rand];
			if ( $this->person->age == "" && $this->person->birthday == "" ) {
				$this->answer[$i] .= $this->pattern['answers']['age_askback']['replies'];
				$this->session->setSession("already_askedyourbirthday", "done");
			}
		}

		if ( ( $this->person->mood !== "" ) && 
			( $this->person->firstname !== "" ) && 
			( $this->person->birthday === "" ) && 
			( $this->session->getSession('already_knowyouremail') === "done" ) ) {
			/*
			$rand_max = count( $this->pattern['answers']['age_askback']['replies'] )-1;
			$rand = rand( 0, $rand_max );
			$this->answer[$i] .= $this->pattern['answers']['age_askback']['replies'][$rand];
			$this->session->setSession("already_askedyourbirthday", "done");
			*/
			$this->answer[$i] .= $this->pattern['answers']['age_askback']['replies'];
			$this->session->setSession("already_askedyourbirthday", "done");
		}		
	}

	private function askemail( $sentence, $i ) {
		// User said his email
        preg_match( $this->pattern['find']['askyouremail'], $sentence, $matches );
        
        // If user said her/his email or I asked him
		if ( $this->session->getSession("already_askedyouremail") === "done" || count( $matches ) > 0 ) {

			// in case user says NO don't replace the searchvariable
			if ( count( $matches ) === 0 && 
				!preg_match( $this->pattern['answers']['askyouremail_reply_no']['replies'], $sentence ) ) {
				$matches[1] = $sentence;
			} elseif ( count( $matches ) === 0 && 
				preg_match( $this->pattern['answers']['askyouremail_reply_no']['replies'], $sentence ) ) {
				$this->answer[$i] .= $this->pattern['answers']['askyouremail_reply_no_ok']['replies'];
				$this->session->setSession("already_knowyouremail", "done");
				$this->session->setSession("already_askedyouremail", "");
			} 

			$matches[1] = preg_replace( "/( |!|\.$|\?)/", "", $matches[1] );

			if ( isset( $matches[1] ) && filter_var( $matches[1], FILTER_VALIDATE_EMAIL ) ) {
				$this->person->email = $matches[1];
				$this->session->setSession("already_knowyouremail", "done");
				$this->session->setSession("already_askedyouremail", "done");
				$this->answer[$i] .= $this->pattern['answers']['askyouremail_reply']['replies'];
			} elseif ( isset( $matches[1] ) && preg_match( "@", $sentence ) ) {
				$this->answer[$i] .= $this->pattern['answers']['askyouremail_wrongemail']['replies'];
				$this->session->setSession("already_askedyouremail", "");
				$have_to_ask_again = true;
			}
		}

		if ( $this->person->mood !== "" && 
			$this->person->firstname !== "" && 
			$this->person->email === "" && 
			$this->session->getSession('already_knowyouremail') !== "done" ) {
			$rand_max = count( $this->pattern['answers']['askyouremail']['replies'] )-1;
			$rand = rand( 0, $rand_max );
			if ( $have_to_ask_again !== true )
				$this->answer[$i] .= $this->pattern['answers']['askyouremail']['replies'][$rand];
			$this->session->setSession("already_askedyouremail", "done");
		}
	}


	private function askname( $sentence, $i ) {	

        preg_match( $this->pattern['find']['askyourname'], $sentence, $matches );

        $this->log->log( $this->session->getSession("already_askedyourname"), "askyourname session" );

		if ( $this->session->getSession("jump_name_question") !== "done" && 
			( ( $this->session->getSession("yourname_answered") !== "done" && 
				$this->session->getSession("already_askedyourname") === "done" ) || 
					count( $matches ) > 0 ) ) {
			if ( count( $matches ) === 0 ) $matches[1] = $sentence;

			$matches[1] = preg_replace( "/(!|\.|\?)/", "", $matches[1] );
			$this->log->log( $matches[1], $this->person->fb_sender_id . "-name" );

			$fullname = preg_split( "/ /", $matches[1], 0, PREG_SPLIT_NO_EMPTY );

			if ( count($fullname) == 2 ) { 
				$firstname = $fullname[0]; $lastname = $fullname[1]; 
				if ( $firstname !== "" ) $this->person->firstname = $firstname;
				if ( $lastname !== "" ) $this->person->lastname = $lastname;
				$this->session->setSession("yourname_answered","done");
			} elseif ( count($fullname) == 1 ) { 
				$firstname = $fullname[0]; 
				if ( $firstname !== "" ) $this->person->firstname = $firstname;
				$this->session->setSession("yourname_answered","done");
			}
			if ( $this->person->firstname !== "" ) {
				$this->answer[$i] .= $this->pattern['answers']['askyourname_reply']['replies'];
			}

			$this->session->setSession("already_askedyourname", "");
		}
		$this->session->setSession("jump_name_question", "");

		if ( preg_match( $this->pattern['answers']['askname']['question'], $sentence ) ) {
			if ( $this->session->getSession("already_askedmyname") !== "done" ) {
				$rand_max = count( $this->pattern['answers']['askname']['replies'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['askname']['replies'][$rand];
				$this->session->setSession("already_askedmyname", "done");
			} else {
				$rand_max = count( $this->pattern['answers']['already_askname']['replies'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['already_askname']['replies'][$rand];
			}

			// ask user her/his name
			if ( $this->session->getSession("yourname_answered") !== "done" ) {
				$rand_max = count( $this->pattern['answers']['askyourname']['replies'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['askyourname']['replies'][$rand];
				$this->session->setSession("already_askedyourname", "done");
			}				
		}
	}

	private function feeling_user( $sentence, $i ) {
		
		// check for answers // I AM HAPPY
		if ( 
			preg_match( $this->pattern['answers']['feeling_good_answer']['question'], $sentence ) && 
			$this->session->getSession("yourname_answered") !== "done" 
		) {
			$rand_max = count( $this->pattern['answers']['feeling_good_answer']['replies'] )-1;
			$rand = rand( 0, $rand_max );
			$this->answer[$i] .= $this->pattern['answers']['feeling_good_answer']['replies'][$rand];
			
			// stop asking after answer
			$this->session->setSession("already_asked_howfeels", "done");
			$this->person->mood = "happy";
			$this->person->mood_date = time();

			// if we don't know the name, we ask
			if ( $this->person->firstname == "" ) {
				$rand_max = count( $this->pattern['answers']['askyourname']['replies'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['askyourname']['replies'][$rand];
				$this->session->setSession("already_askedyourname", "done");
				$this->session->setSession("jump_name_question", "done");
			}
		}

		// check for answers // I AM UNHAPPY
		if ( preg_match( $this->pattern['answers']['feeling_bad_answer']['question'], $sentence ) && $this->session->getSession("yourname_answered") !== "done" ) {
			$rand_max = count( $this->pattern['answers']['feeling_bad_answer']['replies'] )-1;
			$rand = rand( 0, $rand_max );
			$this->answer[$i] .= $this->pattern['answers']['feeling_bad_answer']['replies'][$rand];

			// stop asking after answer
			$this->session->setSession("already_asked_howfeels", "done");
			$this->person->mood = "unhappy";
			$this->person->mood_date = time();	

			$this->answer[$i] .= $this->pattern['answers']['help_unhappy']['replies'];
		}
	}	

	private function feeling_bot( $sentence, $i ) {
		// How does the bot feel?
		if ( preg_match( $this->pattern['answers']['feeling']['question'], $sentence ) ) {
			// didn't tell the user how it feels
			if ( $this->session->getSession('already_bot_feeling') !== "done" ) {
				$rand_max = count( $this->pattern['answers']['feeling']['replies']['directanswer'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['feeling']['replies']['directanswer'][$rand];
				$this->session->setSession('already_bot_feeling', "done");
			
			// already told user how it feels
			} else {
				$rand_max = count( $this->pattern['answers']['feeling']['replies']['alreadyasked'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['feeling']['replies']['alreadyasked'][$rand];
			}

			// did bot ask back how the user is feeling?
			if ( $this->person->mood === "" && $this->session->getSession('already_asked_howfeels') !== "done" ) {
				$this->answer[$i] .= $this->pattern['answers']['salutation']['replies']['feeling'];
			}				
		}
	}

	private function salutation( $sentence, $i ) {

		// SALUTATION only if regex matches HELLO
		if ( preg_match( $this->pattern['answers']['salutation']['question'], $sentence ) ) {
		
			// already greeted? remember if you greeted user
			if ( $this->session->getSession('already_greeted') === "done" ) {
				$rand_max = count( $this->pattern['answers']['salutation']['replies']['alreadyasked'] )-1;
				$rand = rand( 0, $rand_max );
				$this->answer[$i] .= $this->pattern['answers']['salutation']['replies']['alreadyasked'][$rand];
				// TODO remember if you tell user.
				$this->log->log( "already greeted", "salutation" );
			} else {
				// greet depending on time of day
				date_default_timezone_set("UTC");
				$time_now = date("H", time());
				if ( $time_now > 20 || $time_now < 6 ) $this->answer[$i] = $this->pattern['answers']['salutation']['replies']['night'];
				if ( $time_now >= 6 && $time_now < 12 ) $this->answer[$i] = $this->pattern['answers']['salutation']['replies']['morning'];
				if ( $time_now >= 12 && $time_now < 14 ) $this->answer[$i] = $this->pattern['answers']['salutation']['replies']['noon'];
				if ( $time_now >= 14 && $time_now < 18 ) $this->answer[$i] = $this->pattern['answers']['salutation']['replies']['afternoon'];
				if ( $time_now >= 18 && $time_now < 20 ) $this->answer[$i] = $this->pattern['answers']['salutation']['replies']['noon'];

				$this->session->setSession("already_greeted", "done");
			}

			// tell bot name
			if ( $this->session->getSession('already_toldname') !== "done" ) {
				$this->answer[$i] .= $this->pattern['answers']['salutation']['replies']['botname'];
				$this->session->setSession("already_toldname", "done");

				$this->log->log( $this->session->getSession("already_toldname"), "session" );
			}	

			// asked for feeling
			if ( $this->session->getSession('already_asked_howfeels') !== "done" ) {
				$this->answer[$i] .= $this->pattern['answers']['salutation']['replies']['feeling'];
				// stop asking after answer
				$this->session->setSession("already_asked_howfeels", "done");
			}	

		} // end regex
		
	}





	private function buildAnswer() {
		$answers = "";

		$i = 1;
		foreach( $this->answer as $single_answer ) {
			$answers .= $single_answer;
			$i++;
		}

		// replace variables in answers
		foreach ( $this->pattern['variables'] as $key => $val ) {
				$answers = preg_replace( "/\{$key\}/", "$val", $answers );
		}

		if ( $this->person->firstname !== "" ) $answers = preg_replace( "/\{user.firstname\}/", ucfirst($this->person->firstname), $answers );
		if ( $this->person->lastname !== "" ) $answers = preg_replace( "/\{user.lastname\}/", ucfirst($this->person->lastname), $answers );
		if ( $this->person->email !== "" ) $answers = preg_replace( "/\{user.email\}/", strtolower($this->person->email), $answers );
		if ( $this->person->mood !== "" ) $answers = preg_replace( "/\{user.mood\}/", strtolower($this->person->mood), $answers );
		if ( $this->person->location !== "" ) $answers = preg_replace( "/\{user.location\}/", $this->person->location, $answers );
		if ( $this->person->birthday !== "" ) $answers = preg_replace( "/\{user.birthday\}/", date( "Y-m-d", $this->person->birthday ), $answers );

		if ( $this->config->debug === true ) $this->log->log( $answers, $this->person->fb_messenger_id . "answers" );

		return $answers;

	}

	private function upperCaseText() {
		$this->input_message = strtoupper( $this->input_message );
	}

	private function replaceSlang() {
		$pattern = $this->pattern['term'];
		$replace = $this->pattern['replace'];
		$this->input_message = preg_replace( $pattern, $replace, $this->input_message );
	}

   	private function guessLanguage() {
   		if ( $this->config->debug === false && $this->config->language_guessing === true ) {
			$language_json = json_decode( @file_get_contents( $this->config->languageDetector_url . urlencode( $this->input_message ) ) );
	    	$this->language = $language_json->data->detections[0]->language;
	    } else {
	    	$this->language = $this->config->default_language;
	    }
   	}


}
