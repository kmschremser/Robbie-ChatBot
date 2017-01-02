<?php

// replace SLANG etc
$pattern['term'][] = "/WHAT'S|WHATS/";
$pattern['replace'][] = 'WHAT IS';

$pattern['term'][] = "/'VE/";
$pattern['replace'][] = ' HAVE';

$pattern['term'][] = "/ UR /";
$pattern['replace'][] = ' YOUR ';

$pattern['term'][] = "/HOW'S |HOWS /";
$pattern['replace'][] = 'HOW IS ';

$pattern['term'][] = "/IT'S/";
$pattern['replace'][] = 'IT IS';

$pattern['term'][] = "/ WANNA /";
$pattern['replace'][] = ' WANT TO ';

$pattern['term'][] = "/I'M /";
$pattern['replace'][] = 'I AM ';

$pattern['term'][] = "/WE'RE /";
$pattern['replace'][] = 'WE ARE ';

$pattern['term'][] = "/YOU'RE /";
$pattern['replace'][] = 'YOU ARE ';

$pattern['term'][] = "/DON'T /";
$pattern['replace'][] = 'DO NOT ';

$pattern['term'][] = "/AREN'T /";
$pattern['replace'][] = 'ARE NOT ';

$pattern['term'][] = "/E-MAIL/";
$pattern['replace'][] = 'EMAIL';

$pattern['term'][] = "/ WEATER /";
$pattern['replace'][] = ' WEATHER ';

$pattern['term'][] = "/ R U/";
$pattern['replace'][] = ' ARE YOU';

$pattern['term'][] = "/<3/";
$pattern['replace'][] = 'LOVE';

$pattern['term'][] = "/LUV U|LUV YOU|LOVE U($|\.)/";
$pattern['replace'][] = 'LOVE YOU';

$pattern['term'][] = "/^ALOHA|^WHAT UP|^WHAT IS UP|HOWDY|HELLO|HIDIO|CHEERS|HALLO|GREETINGS|HEY|HEY MAN|WELCOME|GOOD MORNING|GOOD AFTERNOON|GOOD EVENING|GOOD NIGHT|YO(\s|\.|$)|G'DAY MATE|G'DAY|HIYA|^HI($|\.|!|\s)/";
$pattern['replace'][] = 'HELLO';

$pattern['term'][] = "/^GREAT|I AM HAPPY|I AM GOOD|^FINE|^GOOD|^NOT BAD|I AM ALRIGHT|IT IS GOING WELL|^AWESOME|I AM AWESOME|I AM GREAT/";
$pattern['replace'][] = 'I AM FINE';

$pattern['term'][] = "/^POOR|I AM NOT HAPPY|I AM NOT GOOD|^NOT FINE|^NOT GOOD|^BAD$|^NOT ALRIGHT|IT IS NOT GOING WELL|^SHITTY|^UNWELL|I FELL NOT WELL/";
$pattern['replace'][] = 'I AM UNHAPPY';

$pattern['term'][] = "/WHAT IS NEW|WHAT IS GOING ON|HOW IS EVERYTHING|HOW ARE THINGS|HOW IS LIFE|HOW IS YOUR DAY|HOW IS YOUR DAY GOING|HOW HAVE YOU BEEN|HOW DO YOU DO|ARE YOU OK|YOU ALRIGHT|ALRIGHT MATE|^SUP|WHAZZUP|HOW IS IT GOING/";
$pattern['replace'][] = 'HOW ARE YOU';

$pattern['term'][] = "/GOOD TO SEE YOU|GOOD TO SEE YOU|NICE TO SEE YOU|NICE TO SEE|LONG TIME NO SEE|IT IS BEEN A WHILE|IT IS NICE TO MEET YOU|PLEASED TO MEET YOU/";
$pattern['replace'][] = 'GREAT TO SEE YOU';

$pattern['term'][] = "/^YOUR NAME|HOW DO YOU CALL YOU|HOW CAN I CALL YOU|WHAZ YOUR NAME|TELL ME YOUR NAME|HOW SHOULD I NAME YOU/";
$pattern['replace'][] = 'WHAT IS YOUR NAME';

$pattern['term'][] = "/I AM CALLED |CALL ME /";
$pattern['replace'][] = 'MY NAME IS ';

$pattern['term'][] = "/WHAT TIME IS IT|WHAZ THE TIME|QUEL HEURE ET IL|HOW LATE|TELL ME THE TIME|CAN YOU CHECK YOUR WATCH|WHAT TIME|^TIME|SHOW ME YOUR WATCH|CAN YOU TELL ME THE TIME|WHICH TIME|TIME\(\)|WHAT IS THE TIME/";
$pattern['replace'][] = 'WHAT TIME IS IT';

$pattern['term'][] = "/WHICH DATE IS IT|^TODAY\?|WHAT IS THE DATE|TELL ME THE DATE|TELL ME DATE|SHOW ME DATE|WHAT IS THE DATE/";
$pattern['replace'][] = 'WHAT DATE IS TODAY';

$pattern['term'][] = "/WHAT IS YOUR AGE|^HOW OLD\?|WHEN WERE YOU BORN|WHEN IS YOUR BIRTHDAY/";
$pattern['replace'][] = 'HOW OLD ARE YOU';

$pattern['term'][] = "/I AM BORN ON|I AM BORN ON THE|BORN ON|BORN ON THE|MY BIRTHDAY IS ^(ON THE)/";
$pattern['replace'][] = 'MY BIRTHDAY IS ON THE';

$pattern['term'][] = "/WILL IT BE SUNNY|WILL IT BE (RAINING|RAINY)|WHAT WILL THE WEATHER BE LIKE|TELL ME THE WEATHER|DO YOU HAVE A WEATHER FORECAST|WEATHER FORECAST|WHAT IS THE WEATHER|WILL IT RAIN|IS IT RAINING|IS IT SUNNY|WILL THE SUN SHINE|SUN SHINING (TODAY|TOMORROW)/";
$pattern['replace'][] = 'WHAT IS THE WEATHER LIKE';

$pattern['term'][] = "/, ÖSTERREICH|,ÖSTERREICH|, AUT|,AUT|, AUSTRIA|,AUSTRIA/";
$pattern['replace'][] = ',AUSTRIA';
$pattern['term'][] = "/, DEUTSCHLAND|,DEUTSCHLAND|, GER|,GER|, GERMANY|,GERMANY/";
$pattern['replace'][] = ',GERMANY';
$pattern['term'][] = "/, JAPAN|,JAPAN|, JPN|,JPN/";
$pattern['replace'][] = ',JAPAN';
$pattern['term'][] = "/, UNITED STATES|,UNITED STATES|, AMERICA|,AMERICA|, USA|,USA/";
$pattern['replace'][] = ',UNITED STATES';
$pattern['term'][] = "/, GREAT BRITAIN|,GREAT BRITAIN|, BRITAIN|,BRITAIN|, ENGLAND|,ENGLAND|, UNITED KINGDOM|,UNITED KINGDOM/";
$pattern['replace'][] = ',UNITED KINGDOM';

//$pattern['term'][] = "/TELL ME |REPEAT /";
//$pattern['replace'][] = 'SAY ';

// bitch, asshole, cunt, screwheads, motherfucker, jerk, idiot, sucker, faggot, pussy, dickhead, fool, maniac, loser, retard, bitchass, mongo, bum, bastard, dumbf'uck, throttle, ecco, hoe, whore, cripple, turd, whacko, snitch, nigga, nerd, freak, pisser, queer, buttmunch, fatass
$pattern['term'][] = "/IDIOT\s?|SCREWHEAD\s?|FAGGOT\s?|PUSSY\s?|DICKHEAD\s?|BITCHASS\s?|BUM\s?|DUMBFUCK\s?|CRIPPLE\s?|SNITCH\s?|TURD\s?|WHACKO\s?|PISSER\s?|BUTTMUCH\s?|FATASS\s?|CUNT\s?|ASHOLE\s?|ASSHOLE\s?|FUCK U\s?|FUCK YOU\s?|FUCKER\s?|MOTHERFUCKER\s?|BASTARD\s?|WHORE\s?|BITCH\s?|JERK\s?|SUCKER\s?/";
$pattern['replace'][] = "IDIOT ";

$pattern['term'][] = "/GOOD BYE|^BYE|C U($|\.|!)|SEE YA|SEE U|SEE YOU|ASTA LA VISTA|BYE BYE|CIAO|CHEERIO|HAVE A GOOD DAY/";
$pattern['replace'][] = "GOOD BYE";

