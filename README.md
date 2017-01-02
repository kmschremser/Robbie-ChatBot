
https://chatbotsmagazine.com/how-to-create-facebook-messenger-bot-in-php-2620784d5583#.dpgspyxz9

https://developers.facebook.com/docs/messenger-platform/send-api-reference/quick-replies



session->topic --> condition
person->skill -> save (learn)

object = blue
--> topic

like / love -> skill / topic?

Do you know something about <object> --> research / request / depending on topic

Where are you?

Topic 
-> image / article with options

Say (something)

I'm 20 years old (20)
date + time
next Monday

What's the 
How's the

if text longer > limit

call --> support

Hi -> random

What do you think of? condition

What's my name? condition - knows or does not know



// http://php.net/manual/en/function.preg-match.php
/* /\bweb\b/i */

/*
// get host name from URL
preg_match('@^(?:http://)?([^/]+)@i',
    "http://www.php.net/index.html", $matches);
$host = $matches[1];

// get last two segments of host name
preg_match('/[^.]+\.[^.]+$/', $host, $matches);
echo "domain name is: {$matches[0]}\n";
*/

/*
  <condition name="gender">
    <li value="male">I find you very handsome.</li>
    <li value="female">I find you very pretty.</li>
    <li>I find you very attractive.</li>
  </condition>

  <li value="unknown">You haven't told me your name.</li>
  <li>Your name is <get name="firstname" /></li>

  Today is <date format="%B %d, %Y" />

  <pattern>SAY *</pattern>
<template><star /></template>

<pattern>THE * IS BLUE</pattern>
<template>
  I will remember that the <star /> is blue.
  <learn>
    <category>
    <pattern>WHAT COLOR IS THE <eval><star /></eval></pattern>
    <template>The <eval><star /></eval> is blue</template>
    </category>
  </learn>
</template>

<template>No, it belongs to <gender><star/></gender></template>  

<category>
<pattern>WHAT IS MY NAME</pattern>
<template><get name="name" /></template>
</category>

<category>
<pattern>MY NAME IS *</pattern>
<template>Nice to meet you, <set name="name"><star /></template>
</category>

<pattern>Stop repeating me</pattern>
<template><input /></template>

<pattern>I LIKE COFFEE</pattern>
<template>
  I will remember that you like coffee.
  <learn>
    <category>
    <pattern>WHAT DO I LIKE</pattern>
    <template>You like coffee.</template>
    </category>
  </learn>
</template>



  <pattern>WHAT IS THE CAPITAL OF *</pattern>
<template>I don't know the capital of <star/>.</template>

<pattern>WHAT IS THE CAPITAL OF <set>state</set></pattern>
<template>
  <map name="state2capital"><star /></map> is the capital of <star />
</template>


<pattern>WHAT DID I JUST SAY</pattern>
<template><request index="1" /></template>

<pattern>IS * A COLOR</pattern>
<template>No, <star /> is not a color.</template>

<category>
<pattern>LET US TALK ABOUT *</pattern>
<template>
  OK, I like <set name="topic"><star /></set>
</template>
</category>

<topic name="coffee">

<category>
<pattern>I DRINK IT PLAIN</pattern>
<template>I prefer mine with cream and sugar</template>
</category>

</topic>

<topic name="tea">

<category>
<pattern>I DRINK IT PLAIN</pattern>
<template>I prefer mine with honey and lemon</template>
</category>

</topic>

*/