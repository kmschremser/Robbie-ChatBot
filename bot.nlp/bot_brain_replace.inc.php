<?php

// replace SLANG etc
$replace_pattern['term'][] = "/WHAT'S|WHATS/";
$replace_pattern['replace'][] = 'WHAT IS';

$replace_pattern['term'][] = "/'VE/";
$replace_pattern['replace'][] = ' HAVE';

$replace_pattern['term'][] = "/ UR /";
$replace_pattern['replace'][] = ' YOUR ';

$replace_pattern['term'][] = "/HOW'S |HOWS /";
$replace_pattern['replace'][] = 'HOW IS ';

$replace_pattern['term'][] = "/IT'S/";
$replace_pattern['replace'][] = 'IT IS';

$replace_pattern['term'][] = "/ WANNA /";
$replace_pattern['replace'][] = ' WANT TO ';

$replace_pattern['term'][] = "/I'M /";
$replace_pattern['replace'][] = 'I AM ';

$replace_pattern['term'][] = "/WE'RE /";
$replace_pattern['replace'][] = 'WE ARE ';

$replace_pattern['term'][] = "/YOU'RE /";
$replace_pattern['replace'][] = 'YOU ARE ';

$replace_pattern['term'][] = "/DON'T /";
$replace_pattern['replace'][] = 'DO NOT ';

$replace_pattern['term'][] = "/AREN'T /";
$replace_pattern['replace'][] = 'ARE NOT ';

$replace_pattern['term'][] = "/E-MAIL/";
$replace_pattern['replace'][] = 'EMAIL';

$replace_pattern['term'][] = "/ WEATER /";
$replace_pattern['replace'][] = ' WEATHER ';

$replace_pattern['term'][] = "/ R U/";
$replace_pattern['replace'][] = ' ARE YOU';

$replace_pattern['term'][] = "/<3/";
$replace_pattern['replace'][] = 'LOVE';

$replace_pattern['term'][] = "/LUV U|LUV YOU|LOVE U($|\.)/";
$replace_pattern['replace'][] = 'LOVE YOU';

$replace_pattern['term'][] = "/^ALOHA|^WHAT UP|^WHAT IS UP|HOWDY|HELLO|HIDIO|CHEERS|HALLO|GREETINGS|HEY|HEY MAN|WELCOME|GOOD MORNING|GOOD AFTERNOON|GOOD EVENING|GOOD NIGHT|YO(\s|\.|$)|G'DAY MATE|G'DAY|HIYA|^HI($|\.|!|\s)/";
$replace_pattern['replace'][] = 'HELLO';

$replace_pattern['term'][] = "/^GREAT|I AM HAPPY|I AM GOOD|^FINE|^GOOD|^NOT BAD|I AM ALRIGHT|IT IS GOING WELL|^AWESOME|I AM AWESOME|I AM GREAT/";
$replace_pattern['replace'][] = 'I AM FINE';

$replace_pattern['term'][] = "/^POOR|I AM NOT HAPPY|I AM SICK|I AM NOT GOOD|^NOT FINE|^NOT GOOD|^BAD$|^NOT ALRIGHT|IT IS NOT GOING WELL|^SHITTY|^UNWELL|I FELL NOT WELL/";
$replace_pattern['replace'][] = 'I AM UNHAPPY';

$replace_pattern['term'][] = "/WHAT IS NEW|WHAT IS GOING ON|HOW IS EVERYTHING|HOW ARE THINGS|HOW IS LIFE|HOW IS YOUR DAY|HOW IS YOUR DAY GOING|HOW HAVE YOU BEEN|HOW DO YOU DO|ARE YOU OK|YOU ALRIGHT|ALRIGHT MATE|^SUP|WHAZZUP|HOW IS IT GOING/";
$replace_pattern['replace'][] = 'HOW ARE YOU';

$replace_pattern['term'][] = "/GOOD TO SEE YOU|GOOD TO SEE YOU|NICE TO SEE YOU|NICE TO SEE|LONG TIME NO SEE|IT IS BEEN A WHILE|IT IS NICE TO MEET YOU|PLEASED TO MEET YOU/";
$replace_pattern['replace'][] = 'GREAT TO SEE YOU';

$replace_pattern['term'][] = "/^YOUR NAME|HOW DO YOU CALL YOU|HOW CAN I CALL YOU|WHAZ YOUR NAME|TELL ME YOUR NAME|HOW SHOULD I NAME YOU/";
$replace_pattern['replace'][] = 'WHAT IS YOUR NAME';

$replace_pattern['term'][] = "/I AM CALLED |CALL ME /";
$replace_pattern['replace'][] = 'MY NAME IS ';

$replace_pattern['term'][] = "/WHAT TIME IS IT|WHAZ THE TIME|QUEL HEURE ET IL|HOW LATE|TELL ME THE TIME|CAN YOU CHECK YOUR WATCH|WHAT TIME|^TIME|SHOW ME YOUR WATCH|CAN YOU TELL ME THE TIME|WHICH TIME|TIME\(\)|WHAT IS THE TIME/";
$replace_pattern['replace'][] = 'WHAT TIME IS IT';

$replace_pattern['term'][] = "/WHICH DATE IS IT|^TODAY\?|WHAT IS THE DATE|TELL ME THE DATE|TELL ME DATE|SHOW ME DATE|WHAT IS THE DATE/";
$replace_pattern['replace'][] = 'WHAT DATE IS TODAY';

$replace_pattern['term'][] = "/WHAT IS YOUR AGE|^HOW OLD\?|WHEN WERE YOU BORN|WHEN IS YOUR BIRTHDAY/";
$replace_pattern['replace'][] = 'HOW OLD ARE YOU';

$replace_pattern['term'][] = "/I AM BORN ON|I AM BORN ON THE|BORN ON|BORN ON THE|MY BIRTHDAY IS ^(ON THE)/";
$replace_pattern['replace'][] = 'MY BIRTHDAY IS ON THE';

$replace_pattern['term'][] = "/WILL IT BE SUNNY|WILL IT BE (RAINING|RAINY)|WHAT WILL THE WEATHER BE LIKE|TELL ME THE WEATHER|DO YOU HAVE A WEATHER FORECAST|WEATHER FORECAST|WHAT IS THE WEATHER|WILL IT RAIN|IS IT RAINING|IS IT SUNNY|WILL THE SUN SHINE|SUN SHINING (TODAY|TOMORROW)/";
$replace_pattern['replace'][] = 'WHAT IS THE WEATHER LIKE';

$replace_pattern['term'][] = "/FOLLOW ME|I WILL FOLLOW YOU/";
$replace_pattern['replace'][] = 'I WANT TO FOLLOW YOU';

$replace_pattern['term'][] = "/, ÖSTERREICH|,ÖSTERREICH|, AUT|,AUT|, AUSTRIA|,AUSTRIA/";
$replace_pattern['replace'][] = ',AUSTRIA';
$replace_pattern['term'][] = "/, DEUTSCHLAND|,DEUTSCHLAND|, GER|,GER|, GERMANY|,GERMANY/";
$replace_pattern['replace'][] = ',GERMANY';
$replace_pattern['term'][] = "/, JAPAN|,JAPAN|, JPN|,JPN/";
$replace_pattern['replace'][] = ',JAPAN';
$replace_pattern['term'][] = "/, UNITED STATES|,UNITED STATES|, AMERICA|,AMERICA|, USA|,USA/";
$replace_pattern['replace'][] = ',UNITED STATES';
$replace_pattern['term'][] = "/, GREAT BRITAIN|,GREAT BRITAIN|, BRITAIN|,BRITAIN|, ENGLAND|,ENGLAND|, UNITED KINGDOM|,UNITED KINGDOM/";
$replace_pattern['replace'][] = ',UNITED KINGDOM';

//$replace_pattern['term'][] = "/TELL ME |REPEAT /";
//$replace_pattern['replace'][] = 'SAY ';

// bitch, asshole, cunt, screwheads, motherfucker, jerk, idiot, sucker, faggot, pussy, dickhead, fool, maniac, loser, retard, bitchass, mongo, bum, bastard, dumbf'uck, throttle, ecco, hoe, whore, cripple, turd, whacko, snitch, nigga, nerd, freak, pisser, queer, buttmunch, fatass
$replace_pattern['term'][] = "/IDIOT\s?|SCREWHEAD\s?|FAGGOT\s?|PUSSY\s?|DICKHEAD\s?|BITCHASS\s?|BUM\s?|DUMBFUCK\s?|CRIPPLE\s?|SNITCH\s?|TURD\s?|WHACKO\s?|PISSER\s?|BUTTMUCH\s?|FATASS\s?|CUNT\s?|ASHOLE\s?|ASSHOLE\s?|FUCK U\s?|FUCK YOU\s?|FUCKER\s?|MOTHERFUCKER\s?|BASTARD\s?|WHORE\s?|BITCH\s?|JERK\s?|SUCKER\s?|YOU ARE STUPID/";
$replace_pattern['replace'][] = "IDIOT ";

$replace_pattern['term'][] = "/GOOD BYE|^BYE|C U($|\.|!)|SEE YA|SEE U|SEE YOU|ASTA LA VISTA|BYE BYE|CIAO|CHEERIO|HAVE A GOOD DAY/";
$replace_pattern['replace'][] = "GOOD BYE";

