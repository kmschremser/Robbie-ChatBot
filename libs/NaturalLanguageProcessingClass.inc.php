<?php

// http://php.net/preg_replace

class NaturalLanguageProcessing {
  
 	function __construct( ) {

   	}

	public function analyzeText( $message, $pattern, $person, $config ) {

/*
// Initial greeting
// Topics as buttons // add topic context
// emojicons
*/

		// if user has not interacted in the last 12 hours then reset intentions
		$last_activity = $person->getPersonProperty( 'last_activity');
		if ( isset( $last_activity ) && $last_activity < time() - (86400/2) ) {
			$person->setPersonProperty( 'intention', array() );
			$person->setPersonProperty( 'mood', "" );
		} 

		// what does the user want
		$intentions_collection = array();
		
		// one time intentions, do not survive the next chat message
		//$intentions_collection['ot'][];
		// take these intentions to next chat message
		//$intentions_collection['temp'][];
		// copy of the previous temp intentions of messages
		//$intentions_collection['tempprev'][];
		// permanent intentions (at least for 12 hours)
		//$intentions_collection['perm'][];

		$intent_temp = $person->getPersonProperty( 'intention' );
		$intentions_collection['tempprev'] = $intent_temp['temp'];
		if ( !is_array( $intentions_collection['tempprev'] ) ) $intentions_collection['tempprev'] = array();
		$intentions_collection['perm'] = $intent_temp['perm'];
		$intentions_collection['temp'] = array();
		$intentions_collection['ot'] = array();

		// return answers
		$answers = array();
		$answers_types = array();

		// logging
		$log_line[] = array( "---- RESET PROFILE next", "for-each" );

		// check for profile reset
		list( $answer, $intentions_collection ) = $this->user_wants_to_reset( $message, $pattern['find']['reset'], $intentions_collection );
		if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }

		if ( !array_key_exists( "user_wants_to_reset", $intentions_collection['ot'] ) ) {

			$sentences = $this->splitSentences( $message );

			// go through all sentences
			for ( $i = 0; $i < count( $sentences ); $i++ ) {

				$single_sentence = $sentences[$i];

				// if sentence is empty, go on
				if ( preg_replace( "/\s\./", "", $single_sentence ) === "" ) continue;

				// logging
				$log_line = array( "--- analyse " . $single_sentence, " sentencen user said" );

				// logging
				$log_line[] = array( "---- SALUTATION user_wants_to_greet", "for-each" );

				list( $answer, $intentions_collection ) = $this->user_wants_to_greet( $single_sentence, $pattern['find'], $pattern['answers'], $person->getPersonProperty('last_activity'), $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }

				// logging
				$log_line[] = array( "---- FEELING user_wants_to_know_feeling", "for-each" );

				list( $answer, $intentions_collection ) = $this->user_wants_to_know_feeling( $single_sentence, $pattern['find'], $pattern['answers'], $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }

				// logging
				$log_line[] = array( "---- NAME user_wants_to_know_bot_name", "for-each" );

				list( $answer, $intentions_collection ) = $this->user_wants_to_know_bot_name( $single_sentence, $pattern['find'], $pattern['answers'], $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }

				// logging
				$log_line[] = array( "---- AGE user_wants_to_know_bot_age/birthday", "for-each" );

				list( $answer, $intentions_collection ) = $this->user_wants_to_know_bot_age( $single_sentence, $pattern['find'], $pattern['answers'], $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }

				// logging
				$log_line[] = array( "---- TIME user_wants_to_know_time", "for-each" );

				list( $answer, $intentions_collection, $answer_type ) = $this->user_wants_to_know_time( $single_sentence, $pattern['find'], $pattern['answers'], $person->getPersonProperty( 'location' ), $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }
				if ( "$answer_type" !== "" ) { $answers_types[$i] .= $answer_type; unset( $answer_type ); }

				// logging
				$log_line[] = array( "---- DATE user_wants_to_know_date", "for-each" );

				list( $answer, $intentions_collection ) = $this->user_wants_to_know_date( $single_sentence, $pattern['find'], $pattern['answers'], $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }

				// logging
				$log_line[] = array( "---- WEATHER user_wants_to_know_weather", "for-each" );

				list( $answer, $intentions_collection, $answer_type ) = $this->user_wants_to_know_weather( $single_sentence, $pattern['find'], $pattern['answers'], $person->getPersonProperty( 'location' ), $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }
				if ( "$answer_type" !== "" ) { $answers_types[$i] .= $answer_type; unset( $answer_type ); }

				// logging
				$log_line[] = array( "---- PROFILE user_wants_to_know_profile", "for-each" );

				list( $answer, $intentions_collection ) = $this->user_wants_to_know_profile( $single_sentence, $pattern['find'], $pattern['answers'], $person->props, $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }

				// logging
				$log_line[] = array( "---- LIKES DONTLIKES user_wants_to_tell_likes_dontlikes", "for-each" );

				list( $answer, $intentions_collection, $likes ) = $this->user_wants_to_tell_likes_dontlikes( $single_sentence, $pattern['find'], $pattern['answers'], $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }
				if ( is_array( $likes ) && count( $likes ) > 0 ) { foreach ( $likes as $like => $like_value ) { $person->setPersonProperty("likes_".strtolower($like), "true"); } }									

				// logging
				$log_line[] = array( "---- SEARCH user_wants_to_know_something", "for-each" );

				list( $answer, $intentions_collection ) = $this->user_wants_to_know_something( $single_sentence, $pattern['find'], $pattern['answers'], $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }

				// logging
				$log_line[] = array( "---- TOPIC user_wants_to_know_topic", "for-each" );

				list( $answer, $intentions_collection, $answer_type ) = $this->user_wants_to_know_topic( $single_sentence, $pattern['find'], $pattern['answers'], $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }
				if ( "$answer_type" !== "" ) { $answers_types[$i] .= $answer_type; unset( $answer_type ); }

				// logging
				$log_line[] = array( "---- USER NAME user_tells_name", "for-each" );

				list( $answer, $intentions_collection, $firstname, $lastname ) = $this->user_tells_name( $single_sentence, $pattern['find'], $pattern['answers'], $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }
				if ( isset( $firstname ) && strlen( $firstname ) > 0 ) { $person->setPersonProperty("firstname", ucfirst(strtolower($firstname))); $firstname = ""; }
				if ( isset( $lastname ) && strlen( $lastname ) > 0 ) { $person->setPersonProperty("lastname", ucfirst(strtolower($lastname))); $lastname = ""; }

				// logging
				$log_line[] = array( "---- USER FEELING user_tells_feeling", "for-each" );

				list( $answer, $intentions_collection, $person_mood ) = $this->user_tells_feeling( $single_sentence, $pattern['find'], $pattern['answers'], $person->getPersonProperty( 'firstname' ), $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }
				if ( isset( $person_mood ) && strlen( $person_mood ) > 0 ) { $person->setPersonProperty("mood", $person_mood); $person_mood = ""; }

				// logging
				$log_line[] = array( "---- USER LOCATION user_tells_location", "for-each" );

				list( $answer, $intentions_collection, $person_location ) = $this->user_tells_location( $single_sentence, $pattern['find'], $pattern['answers'], $person->getPersonProperty( 'location' ), $config->_countries, $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }
				if ( isset( $person_location ) && strlen( $person_location ) > 0 ) { $person->setPersonProperty("location", $person_location); $person_location = ""; }

				// logging
				$log_line[] = array( "---- USER BIRTHDAY user_tells_birthday", "for-each" );

				list( $answer, $intentions_collection, $person_location ) = $this->user_tells_birthday( $single_sentence, $pattern['find'], $pattern['answers'], $person->getPersonProperty( 'birthday' ), $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }
				if ( isset( $person_birthday ) && strlen( $person_birthday ) > 0 ) { $person->setPersonProperty("birthday", $person_birthday); $person_birthday = ""; }

				// logging
				$log_line[] = array( "---- USER BIRTHDAY user_tells_email", "for-each" );

				list( $answer, $intentions_collection, $person_email ) = $this->user_tells_email( $single_sentence, $pattern['find'], $pattern['answers'], $person->getPersonProperty( 'email' ), $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }
				if ( isset( $person_email ) && strlen( $person_email ) > 0 ) { $person->setPersonProperty("email", $person_email); $person_email = ""; }

				// logging
				$log_line[] = array( "---- USER FOLLOWME user_wants_to_follow_me", "for-each" );

				list( $answer, $intentions_collection ) = $this->user_wants_to_follow_me( $single_sentence, $pattern['find'], $pattern['answers'], $person->getPersonProperty( 'followme' ), $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }

				// logging
				$log_line[] = array( "---- EVERYTHING user_wants_to_know_everything", "for-each" );

				list( $answer, $intentions_collection ) = $this->user_wants_to_know_everything( $single_sentence, $pattern['find'], $pattern['answers'], $person, $intentions_collection );
				if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }

			}	

			$intention_temp = implode( ", ", array_keys( $intentions_collection['temp'] ) );
			$intention_tempprev = implode( ", ", array_keys( $intentions_collection['tempprev'] ) );

			// only if no request from bot is initialized
			if ( ( !preg_match( "/bot_/", $intention_temp ) && count( $answers ) > 0 ) || 
				( preg_match( "/bot_/", $intention_tempprev ) ) ) {

				// start with initial bot question
				if ( !$person->getPersonProperty( 'bot_asks_questions' ) ) {
					$person->setPersonProperty( 'bot_asks_questions', "bot_wants_to_know_feeling" );
				}

				if ( $person->getPersonProperty( 'bot_asks_questions' ) === "bot_wants_to_know_feeling" ) {	
					if ( strlen( $person->getPersonProperty('mood') ) === 0 ) { 
						list( $answer, $intentions_collection ) = $this->bot_wants_to_know_feeling( $single_sentence, $pattern['find'], $pattern['answers'], $person->getPersonProperty( 'mood' ), $intentions_collection );
						if ( "$answer" !== "" ) { $bot_answer .= $answer; unset( $answer ); }
					} else {
						$person->setPersonProperty( "bot_asks_questions", "bot_wants_to_know_name" );
					}
				}

				if ( $person->getPersonProperty( 'bot_asks_questions' ) === "bot_wants_to_know_name" ) {
					if ( strlen( $person->getPersonProperty( 'firstname' ) ) === 0 ) {

						list( $answer, $intentions_collection, $person_firstname, $person_lastname, $bot_asks_questions ) = $this->bot_wants_to_know_name( $single_sentence, $pattern['find'], $pattern['answers'], $intentions_collection );
						if ( "$answer" !== "" ) { $bot_answer .= $answer; unset( $answer ); }
						if ( "$person_firstname" !== "" ) { $person->setPersonProperty( "firstname", $person_firstname ); unset( $person_firstname ); }
						if ( "$person_lastname" !== "" ) { $person->setPersonProperty( "firstlastname", $person_lastname ); unset( $person_lastname ); }
						if ( "$bot_asks_questions" !== "" ) { $person->setPersonProperty( "bot_asks_questions", $bot_asks_questions ); unset( $bot_asks_questions ); }
					} else {
						//$person->setPersonProperty( "bot_asks_questions", "bot_wants_to_know_location" );
						$person->setPersonProperty( "bot_asks_questions", "bot_wants_to_know_topic" );
					}
				}

				if ( $person->getPersonProperty( 'bot_asks_questions' ) === "bot_wants_to_know_location" ) {
					if ( strlen( $person->getPersonProperty( 'location' ) ) === 0 ) {
						list( $answer, $intentions_collection, $person_location, $answer_type, $bot_asks_questions ) = $this->bot_wants_to_know_location( $single_sentence, $pattern['find'], $pattern['answers'], $config->_countries, $intentions_collection );
						if ( "$answer" !== "" ) { $bot_answer .= $answer; unset( $answer ); }
						if ( "$person_location" !== "" ) { $person->setPersonProperty( "location", $person_location ); unset( $person_location ); }
						if ( "$answer_type" !== "" ) { $bot_answer_type = $answer_type; }
						if ( "$bot_asks_questions" !== "" ) { $person->setPersonProperty( "bot_asks_questions", $bot_asks_questions ); unset( $bot_asks_questions ); }
					} else {
						$person->setPersonProperty( "bot_asks_questions", "bot_wants_to_know_birthday" );
					}
				}

				if ( $person->getPersonProperty( 'bot_asks_questions' ) === "bot_wants_to_know_birthday" ) {
					if ( strlen( $person->getPersonProperty( 'birthday' ) ) === 0 ) {
						list( $answer, $intentions_collection, $person_birthday, $bot_asks_questions ) = $this->bot_wants_to_know_birthday( $single_sentence, $pattern['find'], $pattern['answers'], $person->getPersonProperty( 'birthday' ), $intentions_collection );
						if ( "$answer" !== "" ) { $bot_answer .= $answer; unset( $answer ); }
						if ( "$person_birthday" !== "" ) { $person->setPersonProperty( "birthday", $person_birthday ); unset( $person_birthday ); }
						if ( "$bot_asks_questions" !== "" ) { $person->setPersonProperty( "bot_asks_questions", $bot_asks_questions ); unset( $bot_asks_questions ); }
					} else {
						$person->setPersonProperty( "bot_asks_questions", "bot_wants_to_know_email" );
					}
				}

				if ( $person->getPersonProperty( 'bot_asks_questions' ) === "bot_wants_to_know_email" ) {
					if ( strlen( $person->getPersonProperty( 'email' ) ) === 0 ) {
						list( $answer, $intentions_collection, $person_email, $bot_asks_questions ) = $this->bot_wants_to_know_email( $single_sentence, $pattern['find'], $pattern['answers'], $person->getPersonProperty( 'email' ), $intentions_collection );
						if ( "$answer" !== "" ) { $bot_answer .= $answer; unset( $answer ); }
						if ( "$person_email" !== "" ) { $person->setPersonProperty( "email", $person_email ); unset( $person_email ); }
						if ( "$bot_asks_questions" !== "" ) { $person->setPersonProperty( "bot_asks_questions", $bot_asks_questions ); unset( $bot_asks_questions ); }
					} else {
						$person->setPersonProperty( "bot_asks_questions", "bot_wants_to_know_topic" );
					}
				}


				if ( !$this->multiKeyExists( "user_wants_to_know_topic", $intentions_collection ) ) {
					$number_of_answers = count( $answers );
					if ( $number_of_answers > 0 ) { 
						$counter = $number_of_answers - 1; 
						$answers[$counter] .= $bot_answer; 
						if ( strlen( $bot_answer_type ) > 0 ) $answers_types[$counter] = $bot_answer_type;
						// in case user answers questions of bot, no user intention
					} elseif ( strlen( $bot_answer ) > 0 ) {
						$answers[0] = $bot_answer;
						if ( strlen( $bot_answer_type ) > 0 ) $answers_types[0] = $bot_answer_type;
					}
				}
			}

			if ( $intention['ot']["bot_has_no_idea"] !== "done" ) {
				for ( $i = 0; $i < count( $sentences ); $i++ ) {
					// logging
					$log_line[] = array( "---- NO IDEA bot_has_no_idea", "for-each" );

					list( $answer, $intentions_collection, $answer_type ) = $this->bot_has_no_idea( $answers, $i, $pattern['answers'], $intentions_collection );
					if ( "$answer" !== "" ) { $answers[$i] .= $answer; unset( $answer ); }
					if ( "$answer_type" !== "" ) { $answers_types[$i] = $answer_type; }
				}
			}

		}

		$person->setPersonProperty( "intention", $intentions_collection );

if ( $config->show_form === true ) {
		echo "<br />answers: ";
		print_r($answers);
		echo "<br />answers_types: ";
		print_r($answers_types);
		echo "<br /> intention: ";
		print_r($intentions_collection);
		echo "<br />";
}

		return array( $answers, $intentions_collection, $answers_types );	
	} 

	private function email_match( $sentence, $pattern_find, $pattern_answers, $person_email, $intention ) {
		// User said his email
        if ( preg_match( $pattern_find['askyouremail'], $sentence, $matches ) ) {

        } else {
        	$matches[1] = $sentence;
        }

        // If user said her/his email or I asked him
		if ( count ( $matches ) > 0 ) {

			$matches[1] = preg_replace( "/( |!|\.$|\?)/", "", $matches[1] );

			if ( isset( $matches[1] ) && filter_var( $matches[1], FILTER_VALIDATE_EMAIL ) ) {

				$person_email = $matches[1];
				$answer = $pattern_answers['askyouremail_reply'];
				$bot_asks_questions = "bot_wants_to_know_topic";
				$intention['temp']['bot_wants_to_know_email'] = "done";

			} elseif ( isset( $matches[1] ) && !preg_match( "/\@/", $sentence ) ) {

				$answer = $pattern_answers['askyouremail_wrongemail'];
				$intention['temp']['bot_wants_to_know_email'] = "done";

			}
			// user says no
		} elseif ( preg_match( $pattern_find['askyouremail_reply_no'], $sentence, $matches ) ) {
				$answer = $pattern_find['askyouremail_reply_no_ok'];
		}		
		return array( $answer, $intention, $person_email, $bot_asks_questions );
	}

	private function user_tells_email( $sentence, $pattern_find, $pattern_answers, $person_email, $intention ) {
		if ( preg_match( $pattern_find['askyouremail'], $sentence, $matches ) ) {
			list( $answer, $intention, $person_email ) = $this->email_match( $sentence, $pattern_find, $pattern_answers, $person_email, $intention );
		}
		return array( $answer, $intention, $person_email, $bot_asks_questions );
	}

	private function bot_wants_to_know_email( $sentence, $pattern_find, $pattern_answers, $person_email, $intention ) {
		// user might answer with a date only
		if ( $intention['tempprev']['bot_wants_to_know_email'] === "done" ) {

			list( $answer, $intention, $person_email, $bot_asks_questions ) = $this->email_match( $sentence, $pattern_find, $pattern_answers, $person_email, $intention );

		} else {

			$rand_max = count( $pattern_answers['age_askback'] )-1;
			$rand = rand( 0, $rand_max );
			$answer = $pattern_answers['age_askback'][$rand];	
			$intention['temp']['bot_wants_to_know_email'] = "done";

		}
		
		return array( $answer, $intention, $person_email, $bot_asks_questions );
	}

	private function birthday_match( $sentence, $pattern_find, $pattern_answers, $person_birthday, $intention ) {
		// User said his birthday
        if ( preg_match( $pattern_find['birthday']['question'], $sentence, $matches ) ) {
        } elseif ( strtotime( $sentence ) ) {
        	$matches[1] = $sentence;
        }

        // If user said her/his email or I asked him
		if ( count ( $matches ) > 0 ) {

			$matches[1] = preg_replace( "/( |!|\.$|\?)/", "", $matches[1] );

			if ( isset( $matches[1] ) && (bool)strtotime( $matches[1] ) ) {
				$today = date('Y', time());
				if ( strtotime( $matches[1] ) < strtotime( "$today -10 years" ) ) {
					$person_birthday = strtotime( $matches[1] );
					
					$rand_max = count( $pattern_answers['birthday'] )-1;
					$rand = rand( 0, $rand_max );
					$answer = $pattern_answers['birthday'][$rand];

					if ( date( "m-d", time() ) === date( "m-d", strtotime( $matches[1] ) ) ) {
						$answer .= $pattern_answers['birthday_today'];
					}
					$bot_asks_questions = "bot_wants_to_know_email";
					$intention['temp']['bot_wants_to_know_email'] = "done";

				} else {
					$intention['temp']['bot_wants_to_know_birthday'] = "done";
					$answer = $pattern_answers['birthday_toyoung'];
				}

			// user says no
			} elseif ( preg_match( $pattern_find['no_birthday'], $sentence, $matches ) ) {
				$answer = $pattern_find['no_birthday'];
			}
		}
		return array( $answer, $intention, $person_birthday, $bot_asks_questions );
	}

	private function user_tells_birthday( $sentence, $pattern_find, $pattern_answers, $person_birthday, $intention ) {
		if ( preg_match( $pattern_find['birthday']['question'], $sentence, $matches ) ) {
			list( $answer, $intention, $person_birthday, $bot_asks_questions ) = $this->birthday_match( $sentence, $pattern_find, $pattern_answers, $person_birthday, $intention );
		}
		return array( $answer, $intention, $person_birthday, $bot_asks_questions );
	}

	private function bot_wants_to_know_birthday( $sentence, $pattern_find, $pattern_answers, $person_birthday, $intention ) {
		// user might answer with a date only
		if ( $intention['tempprev']['bot_wants_to_know_birthday'] === "done" ) {

			list( $answer, $intention, $person_birthday, $bot_asks_questions ) = $this->birthday_match( $sentence, $pattern_find, $pattern_answers, $person_birthday, $intention );

		} else {
			$rand_max = count( $pattern_answers['age_askback'] )-1;
			$rand = rand( 0, $rand_max );
			$answer = $pattern_answers['age_askback'][$rand];	
			$intention['temp']['bot_wants_to_know_birthday'] = "done";
		}
		
		return array( $answer, $intention, $person_birthday, $bot_asks_questions );
	}

	private function location_match( $sentence, $pattern_find, $pattern_answers, $countries, $intention ) {
		// I'm in ... 
		if ( preg_match( $pattern_find['location']['question'], $sentence, $matches ) ) {
			// city (maybe country)
			$sentence = $matches[1];
		}

		// remove unnecessary letters
		//$sentence = preg_replace( "/\.|!+/", "", $sentence );

		// get city, country
		preg_match( $pattern_find['location']['question2'], $sentence, $matches );	

		if ( count( $matches ) > 0 ) {
			
			// check countries
			$country_ok = false;

			$matches[3] = preg_replace( "/\.$|!$/", "", $matches[3] );

			foreach( $countries as $country => $countryname ) {
				if ( strtoupper( $country ) === $matches[3] ) { $country_ok = true; }
			}

			if ( $country_ok === true ) {

				$cname = $matches[3];
				$person_location = $matches[1] . "," . $countries[$cname];

				$rand_max = count( $pattern_answers['location'] )-1;
				$rand = rand( 0, $rand_max );
				$answer = $pattern_answers['location'][$rand];
				$bot_asks_questions = "bot_wants_to_know_birthday";
				$intention['temp']['bot_wants_to_know_birthday'] = "done";

			} else {
				//$answer .= $pattern_answers['nocountry_location'];
				//$intention['temp']['bot_wants_to_know_location'] = "done";
			}
		}
		return array( $answer, $intention, $person_location, $bot_asks_questions );
	}

	private function user_tells_location( $sentence, $pattern_find, $pattern_answers, $person_location, $countries, $intention ) {
		if ( preg_match( $pattern_find['location']['question'], $sentence, $matches ) ) {
			list( $answer, $intention, $person_location ) = $this->location_match( $sentence, $pattern_find, $pattern_answers, $countries, $intention );
		}
		return array( $answer, $intention, $person_location );
	}

	private function bot_wants_to_know_location( $sentence, $pattern_find, $pattern_answers, $countries, $intention ) {
		
		if ( $intention['tempprev']['bot_wants_to_know_location'] === "done" ) {

			list( $answer, $intention, $person_location, $bot_asks_questions ) = $this->location_match( $sentence, $pattern_find, $pattern_answers, $countries, $intention );

		} else {
			$rand_max = count( $pattern_answers['nolocation'] )-1;
			$rand = rand( 0, $rand_max );
			$answer = $pattern_answers['nolocation'][$rand];	
			$intention['temp']['bot_wants_to_know_location'] = "done";
			$answer_type = "location";
		}
		return array( $answer, $intention, $person_location, $answer_type, $bot_asks_questions );
	}

	private function bot_wants_to_know_name( $sentence, $pattern_find, $pattern_answers, $intention ) {
		// ask user her/his name
		if ( $intention['tempprev']['bot_wants_to_know_name'] === "done" ) {
			if ( preg_match( "/ /", $sentence ) ) {
				preg_match( "/^(.+)(\s)(.+)$/", $sentence, $matches );
				if ( strlen( $matches[1] ) > 0 ) { $person_firstname = $matches[1]; }
				if ( strlen( $matches[3] ) > 0 ) { $person_lastname = $matches[3]; }
			} else {
				preg_match( "/^(.+)$/", $sentence, $matches );
				if ( strlen( $matches[1] ) > 0 ) { $person_firstname = $matches[1]; }
			}
			$answer = $pattern_answers['tellsusername_reply'];
			$bot_asks_questions = "bot_wants_to_know_location";

		} else {
			$rand_max = count( $pattern_answers['askusername'] )-1;
			$rand = rand( 0, $rand_max );
			$answer = $pattern_answers['askusername'][$rand];
			$intention['temp']['bot_wants_to_know_name'] = "done";
		}
		return array( $answer, $intention, $person_firstname, $person_lastname, $bot_asks_questions );		
	}

	/*
	* bot wants to know feeling of user
	*/

	private function bot_wants_to_know_feeling( $sentence, $pattern_find, $pattern_answers, $person_mood, $intention ) {
		// ask user how (s)he feels after salutation.
		$answer = $pattern_answers['salutation']['feeling'];
		$intention['temp']['bot_wants_to_know_feeling'] = "done";
		return array( $answer, $intention );
	}

	private function user_tells_feeling( $sentence, $pattern_find, $pattern_answers, $person_firstname, $intention ) {
		// check for answers // I AM HAPPY
		if ( preg_match( $pattern_find['feeling_good_answer']['question'], $sentence ) ) {
			$rand_max = count( $pattern_answers['feeling_good_answer'] )-1;
			$rand = rand( 0, $rand_max );
			$answer = $pattern_answers['feeling_good_answer'][$rand];
			
			// stop asking after answer
			$intention['ot']['user_tells_feeling'] = "done";
			$person_mood = "happy";
		}

		// check for answers // I AM UNHAPPY
		if ( preg_match( $pattern_find['feeling_bad_answer']['question'], $sentence ) ) {
			$rand_max = count( $pattern_answers['feeling_bad_answer'] )-1;
			$rand = rand( 0, $rand_max );
			$answer = $pattern_answers['feeling_bad_answer'][$rand];

			// stop asking after answer
			$intention['ot']['user_tells_feeling'] = "done";
			$person_mood = "unhappy";

			$answer .= $pattern_answers['help_unhappy'];
		}
		return array( $answer, $intention, $person_mood );
	}

	/*
	* bot has no idea
	*/
	private function bot_has_no_idea( $answers, $i, $pattern_answers, $intention ) {
		// if bot gave no answers, then reply default message
		if ( strlen( $answers[$i] ) === 0 ) {
			$rand_max = count( $pattern_answers['noidea'] )-1;
			$rand = rand( 0, $rand_max );
			$answer = $pattern_answers['noidea'][$rand];
			$answer_type = "quick_topics";
			$intention['ot']["bot_has_no_idea"] = "done";

		}
		return array( $answer, $intention, $answer_type );
	}

	/*
	* go for reset profile
	*/
	private function user_wants_to_reset( $sentence, $pattern_string, $intention ) {
		$matches = array();

		if ( preg_match( $pattern_string, $sentence, $matches ) ) {
			$answer = "Session will be destroyed and profile reset. ";
			$intention['ot']['user_wants_to_reset'] = "done";
		} else {
			// reset intentions
			unset( $intention['ot']['user_wants_to_reset'] );
		}

		return array( $answer, $intention );
	}

	private function user_wants_to_know_feeling( $sentence, $pattern_find, $pattern_answers, $intention ) {
		// How does the bot feel?
		if ( preg_match( $pattern_find['feeling']['question'], $sentence ) ) {
			// didn't tell the user how it feels
			if ( $intention['perm']['user_wants_to_know_feeling'] !== "done" ) {
				$rand_max = count( $pattern_answers['feeling']['directanswer'] )-1;
				$rand = rand( 0, $rand_max );
				$answer = $pattern_answers['feeling']['directanswer'][$rand];
			
			// already told user how it feels
			} else {
				$rand_max = count( $pattern_answers['feeling']['alreadyasked'] )-1;
				$rand = rand( 0, $rand_max );
				$answer = $pattern_answers['feeling']['alreadyasked'][$rand];

			}
			$intention['perm']['user_wants_to_know_feeling'] = "done";
			$intention['temp']['user_wants_to_know_feeling'] = "done";
		}

		return array( $answer, $intention );
	}	

	private function user_wants_to_follow_me( $sentence, $pattern_find, $pattern_answers, $followme, $intention ) {
		// user wants to follow bot
		if ( preg_match( $pattern_find['followme'], $sentence ) ) {
				$rand_max = count( $pattern_answers['followme']['replies'] )-1;
				$rand = rand( 0, $rand_max );
				$answer = $pattern_answers['followme']['replies'][$rand];
		}
		$intention['perm']['user_wants_to_follow_me'] = "done";

		return array( $answer, $intention );
	}	

	private function user_wants_to_greet( $sentence, $pattern_find, $pattern_answers, $last_activity = 0, $intention  ) {
		// SALUTATION only if regex matches HELLO
		if ( preg_match( $pattern_find['salutation']['question'], $sentence ) ) {

			// already greeted? remember if you greeted user
			if ( $intention['perm']['user_wants_to_greet'] === "done" ) {
				$rand_max = count( $pattern_answers['salutation']['alreadyasked'] )-1;
				$rand = rand( 0, $rand_max );
				$answer = $pattern_answers['salutation']['alreadyasked'][$rand];

			} else {

				// greet depending on time of day
				date_default_timezone_set("UTC");
				$time_now = date("H", time());

				if ( $time_now >= 20 || $time_now < 6 ) $answer = $pattern_answers['salutation']['night'];
				if ( $time_now >= 6 && $time_now < 12 ) $answer = $pattern_answers['salutation']['morning'];
				if ( $time_now >= 12 && $time_now < 14 ) $answer = $pattern_answers['salutation']['noon'];
				if ( $time_now >= 14 && $time_now < 18 ) $answer = $pattern_answers['salutation']['afternoon'];
				if ( $time_now >= 18 && $time_now < 20 ) $answer = $pattern_answers['salutation']['noon'];

			}	
			$intention['perm']['user_wants_to_greet'] = "done";
			$intention['temp']['user_wants_to_greet'] = "done";
		}

		return array( $answer, $intention ); 
	}

	private function user_wants_to_know_bot_name( $sentence, $pattern_find, $pattern_answers, $intention ) {
		// What is your name (user intention)
		if ( preg_match( $pattern_find['askname']['question'], $sentence ) ) {

			// user has not asked before
			if ( $intention['perm']['user_wants_to_know_bot_name'] !== "done" ) {
				$rand_max = count( $pattern_answers['askname'] )-1;
				$rand = rand( 0, $rand_max );
				$answer = $pattern_answers['askname'][$rand];

			} else {
				$rand_max = count( $pattern_answers['already_askname'] )-1;
				$rand = rand( 0, $rand_max );
				$answer = $pattern_answers['already_askname'][$rand];
			}
			$intention['perm']['user_wants_to_know_bot_name'] = "done";
		}

		return array( $answer, $intention );
	}

	private function user_wants_to_know_bot_age( $sentence, $pattern_find, $pattern_answers, $intention ) {
 		// check for answers // if question is asked

		if ( preg_match( $pattern_find['age']['question'], $sentence ) ) {
			$rand_max = count( $pattern_answers['age'] )-1;
			$rand = rand( 0, $rand_max );
			$answer = $pattern_answers['age'][$rand];
			$intention['ot']['user_wants_to_know_bot_age'] = "done";
		}
		return array( $answer, $intention );		
	}

	private function user_wants_to_know_time( $sentence, $pattern_find, $pattern_answers, $person_location, $intention ) {
 		// check for answers // if question is asked
		if ( preg_match( $pattern_find['time']['question'], $sentence ) ) {
			$rand_max = count( $pattern_answers['time'] )-1;
			$rand = rand( 0, $rand_max );
			$answer .= $pattern_answers['time'][$rand];
			$intention['ot']['user_wants_to_know_time'] = "done";

			if ( "$person_location" === "" ) {
				$answer .= $pattern_answers['time']['replies_nolocation'];

				$answer_type = "location";
				$intention['temp']['bot_wants_to_know_location'] = "done";
			}
		}
		return array( $answer, $intention, $answer_type );
	}

	private function user_wants_to_know_date( $sentence, $pattern_find, $pattern_answers, $intention ) {
 		// check for answers // if question is asked
		if ( preg_match( $pattern_find['date']['question'], $sentence ) ) {
			$rand_max = count( $pattern_answers['date'] )-1;
			$rand = rand( 0, $rand_max );
			$answer .= $pattern_answers['date'][$rand];
			$intention['ot']['user_wants_to_know_date'] = "done";
		}
		return array( $answer, $intention );
	}

	private function user_wants_to_know_weather( $sentence, $pattern_find, $pattern_answers, $person_location, $intention ) {
 		// check for answers // if question is asked
		if ( preg_match( $pattern_find['weather']['question'], $sentence ) ) {
			if ( "$person_location" === "" ) {
				$answer = $pattern_answers['weather_location'];
				$answer_type = "location";
				$intention['temp']['bot_wants_to_know_location'] = "done";

			} else {
				$location = urlencode( $person_location );
				// https://en.wikipedia.org/wiki/ISO_3166-1
				$weather_json =  json_decode( file_get_contents( 'http://api.openweathermap.org/data/2.5/forecast?q=' . $location . '&mode=json&appid=11a042b6ed7207bb28cf91a051994921' ) );

				$temp_kelvin = round($weather_json->list[0]->main->temp,0);
				$temp_celsius = round(($temp_kelvin-273.15),1);
				$temp_fahrenheit = ( $temp_kelvin * 9 / 5 ) - 459.67;

				$weather = " - " . $weather_json->list[0]->weather[0]->description; 
				$weather .= " (" . $temp_fahrenheit . " F, " . $temp_celsius . " C)";

				$rand_max = count( $pattern_answers['weather'] )-1;
				$rand = rand( 0, $rand_max );
				$answer = $pattern_answers['weather'][$rand] . $weather;
			}
			$intention['temp']['user_wants_to_know_weather'] = "done";
		}
		return array( $answer, $intention, $answer_type );
	}

	private function user_wants_to_know_profile( $sentence, $pattern_find, $pattern_answers, $person_props, $intention ) {
		if ( preg_match( $pattern_find['profile']['question'], $sentence, $matches ) ) {
			$answer = http_build_query($person_props,'',', ');
			$intention['ot']['user_wants_to_know_profile'] = "done";
		}
		return array( $answer, $intention );
	}
	
	private function user_wants_to_tell_likes_dontlikes( $sentence, $pattern_find, $pattern_answers, $intention ) {
		if ( preg_match( $pattern_find['likes']['question'], $sentence, $matches ) ) {
			$like = preg_replace( "/( |!|\.$|\?)/", "", $matches[1] );
			$likes[$like] = true;
			$intention['ot']['user_wants_to_tell_likes_dontlikes'] = "done";
			$answer = $pattern_answers['likes'];
		}
		if ( preg_match( $pattern_find['dontlikes']['question'], $sentence, $matches ) ) {
			$dontlike = preg_replace( "/( |!|\.$|\?)/", "", $matches[1] );
			$likes[$dontlike] = false;
			$intention['ot']['user_wants_to_tell_likes_dontlikes'] = "done";
			$answer = $pattern_answers['likes'];
		}
		return array( $answer, $intention, $likes );
	}

	private function user_wants_to_know_everything( $sentence, $pattern_find, $pattern_answers, $person, $intention ) {
		foreach ( $pattern_find['questions'] as $key => $value ) {
			// if one of the pattern matches
			if ( preg_match( $value[0], $sentence ) ) {
				$rand_max = count( $value[1] )-1;
				$rand = rand( 0, $rand_max );
				$answer .= $value[1][$rand];
				$intention['temp']['user_wants_to_know_everything'] = "done";
			}
		}	

		foreach ( $pattern_find['rule']['questions'] as $key => $value ) {
			$match = "";
			// go through certain questions
			if ( preg_match( $value[0], $sentence ) ) {

				// property name of person object
				if ( "$value[2]" !== "" ) {
					$match = $person->getPersonProperty( $value[2] );
				}
				
				// if person object is set
				if ( "$match" !== "" ) {
					$rand_max = count( $value[1] )-1;
					$rand = rand( 0, $rand_max );
					$answer .= $value[1][$rand];
				} else {
					$answer .= $value[3];
				}
				$intention['temp']['user_wants_to_know_everything'] = "done";
			}
		}
		return array( $answer, $intention );
	}

	// TODO to be improved
	private function user_wants_to_know_something( $sentence, $pattern_find, $pattern_answers, $intention ) {
		// I search for *
		if ( preg_match( $pattern_find['askforsearch']['question'], $sentence, $matches ) ) {

			if ( count( $matches ) > 0 ) {
				$rand_max = count( $pattern_answers['search'] )-1;
				$rand = rand( 0, $rand_max );
				$answer = $pattern_answers['search'][$rand] . ($matches[1]) . ".";			
			} else {
				$rand_max = count( $pattern_answers['nosearch'] )-1;
				$rand = rand( 0, $rand_max );
				$answer = $pattern_answers['nosearch'][$rand];
			}
			$intention['temp']['user_wants_to_know_something'] = "done";
		}
		return array( $answer, $intention );
	}

	private function user_wants_to_know_topic( $sentence, $pattern_find, $pattern_answers, $intention ) {
		if ( preg_match( $pattern_find['help']['question'], $sentence ) ) {
			$rand_max = count( $pattern_answers['help'] )-1;
			$rand = rand( 0, $rand_max );
			$answer .= $pattern_answers['help'][$rand];
			$answer_type = "topic";
			$intention['temp']['user_wants_to_know_topic'] = "done";
		}
		return array( $answer, $intention, $answer_type );
	}

	private function user_tells_name( $sentence, $pattern_find, $pattern_answers, $intention ) {
        if ( preg_match( $pattern_find['tellsusername'], $sentence, $matches ) ) {

			$matches[1] = preg_replace( "/(!|\.|\?)/", "", $matches[1] );
			$fullname = preg_split( "/ /", $matches[1], 0, PREG_SPLIT_NO_EMPTY );

			if ( count($fullname) == 3 ) { 
				$firstname = $fullname[0]; 
				$lastname = $fullname[2]; 
				$intention['ot']['user_tells_name'] = "done";

			} elseif ( count($fullname) == 2 ) { 
				$firstname = $fullname[0]; 
				$lastname = $fullname[1]; 
				$intention['ot']['user_tells_name'] = "done";

			} elseif ( count($fullname) == 1 ) { 
				$firstname = $fullname[0]; 
				$intention['ot']['user_tells_name'] = "done";

			}
			if ( "$firstname" !== "" ) {
				$answer = $pattern_answers['tellsusername_reply'];
			}
		}
		return array( $answer, $intention, $firstname, $lastname );
	}

	/*
	* build answer_string
	*/
	public function buildAnswer( $answers, $person, $pattern_variables ) {
		$return_answers = array();
		
		foreach( $answers as $single_answer ) {

			// replace variables in answers
			foreach ( $pattern_variables as $key => $val ) {
					$single_answer = preg_replace( "/\{$key\}/", "$val", $single_answer );
			}

			$replace_vars = array( "firstname", "lastname", "email", "mood", "location", "birthday" );

			foreach ( $replace_vars as $key ) {
				if ( preg_match( "/firstname|lastname|location/", $key ) ) $sample = ucfirst( $person->getPersonProperty( $key ) );
				if ( preg_match( "/email|mood/", $key ) ) $sample = strtolower( $person->getPersonProperty( $key ) );
				if ( preg_match( "/birthday/", $key ) ) $sample = date( "Y-m-d", $person->getPersonProperty( $key ) );

				// removed this to replace unknown props of person with empty string
				//if ( strlen( $person->getPersonProperty( $key ) ) > 0 ) 
					$single_answer = preg_replace( "/\{user.".$key."\}/", $sample, $single_answer );	
			}
			$return_answers[] = $single_answer;
		}
		return $return_answers;
	}

	/*
	* split sentences
	*/
	public function splitSentences( $message ) {
		$sentences = $message;

		// split sentences by endpoints, smileys are also endpoints
		//$sentences = preg_split("/(?<=[.?!])\s+(?=[a-z])/i", $sentences, -1, PREG_SPLIT_NO_EMPTY );
		$sentences = preg_split("/(?<=[\.?!])\s+(?=[a-z])/i", $sentences, -1, PREG_SPLIT_NO_EMPTY );
		$sentences_new = $sentences_split = array();

		foreach ( $sentences as $sentence ) {
			$sentence_split = preg_split("/(:D|:\/|:\)|:\(|:-\(|:-\))(?=\s|[^[:alnum:]+-]|)/i", $sentence, -1, PREG_SPLIT_NO_EMPTY );
			$sentences_new = array_merge( $sentences_new, $sentence_split );
		}
		// return array with single sentences
		return $sentences_new;
	}

	/*
	* bring all characters to upper case
	*/
	public function upperCaseText( $message ) {
		if ( isset( $message ) && $message !== "" ) return strtoupper( $message );
		else return false;
	}

	/*
	* simplify all requests to few requests
	*/
	public function replaceSlang( $term = array(), $replace = array(), $message ) {
		return preg_replace( $term, $replace, $message );
	}

	/*
	* guess language from API
	*/
   	public function guessLanguage( $languageDetector_url, $message, $default_language ) {
		$language = "";
		$language_json = json_decode( @file_get_contents( $languageDetector_url . urlencode( $message ) ) );
	    $language_response = $language_json->data->detections[0]->language;

	    if ( isset( $language_response ) ) { 
	    	$language = strtoupper( $language_response );
	    } 

	    if ( !preg_match( "/EN|DE/", $language ) ) {
	    	$language = $default_language;
	    }
	    return $language;
   	}

   	/*
   	* replace quotes for JSON message 
   	*/
   	public function replaceQuotes( $message ) {
   		$message = preg_replace( "/\"/", "'", $message );
   		return $message;
   	}

   	/*
   	* remove breaks before processing message
   	*/
   	public function removeBreaks( $message ) {
		$message = str_replace(array("\r\n", "\r", "\n", '<BR>', '<BR />'), " ", $message);
		return $message;
   	} 

	public function multiKeyExists($key, array $arr) {

	    // is in base array?
	    if (array_key_exists($key, $arr)) {
	        return true;
	    }

	    // check arrays contained in this array
	    foreach ($arr as $element) {
	        if (is_array($element)) {
	            if ($this->multiKeyExists($key, $element)) {
	                return true;
	            }
	        }
	    }
	    return false;
	}
}


