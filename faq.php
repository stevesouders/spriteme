<?php 
require_once("utils.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>SpriteMe FAQ</title>

<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<style>
<?php
echo spritemeStyle();
?>

</style>

</head>
<body>

<?php 
echo spritemeHeader("faq");
?>


<div id=contents class=contents>

<?php 
echo spritemeNav("faq");
?>

<br>

<style>
#results { display: none; }
#questions LI { font-weight: bold; font-size: 1.1em; }
#questions A { color: #222; }
.question { font-weight: bold; margin-top: 20px; font-size: 1.1em; }
.answer {}
.comment { font-style: italic; font-size: 0.9em; }
</style>

<?php
$gFaqs = array(
			   array("What are CSS sprites?",
					 "A sprite combines multiple background images into a single image. This is a technique for <a href='http://developer.yahoo.net/blog/archives/2007/04/rule_1_make_few.html'>making web pages faster</a> because it reduces the number of downloads in the page. See Chapter 1 in <a href='http://www.amazon.com/High-Performance-Web-Sites-Essential/dp/0596529309'>High Performance Web Sites</a> by Steve Souders for more information about the performance benefits of using sprites. See <a href='http://www.alistapart.com/articles/sprites'>CSS Sprites: Image Slicing's Kiss of Death</a> by Dave Shea for more information about how sprites work.",
					 "def"),

			   array("Why should I bother to create CSS sprites?",
					 "Using sprites reduces the number of HTTP requests in the page. This is one of technique for <a href='http://developer.yahoo.net/blog/archives/2007/04/rule_1_make_few.html'>making web pages faster</a>. This is especially important for users with slow Internet connections or who are far away from your servers. Also, some browsers, including Internet Explorer 6 and 7, can only make two HTTP requests in parallel (to the same server). If the page has multiple background images, they are downloaded sequentially, resulting in a slow page.",
					 "why"),

			   array("Do many web sites use CSS sprites? Does it make much difference?",
					 "The use of CSS sprites is growing. In 2007, only two of the Alexa top ten U.S. web sites used sprites. Today (2009) nine of the top ten sites use sprites. It's a recognized technique for speeding up web pages. And yet, many popular sites that could benefit from sprites don't use them. As of September 2009, here is a list of web sites with the number of HTTP requests that could be eliminated if they used sprites: <a href='http://www.cnn.com/'>CNN</a> (30), <a href='http://www.ebay.com/'>eBay</a> (21), <a href='http://online.wsj.com/home-page'>WSJ</a> (39), and <a href='http://www.usps.com/'>USPS</a> (37).",
					 "popular"),

			   array("What's a bookmarklet? Why did you create SpriteMe as a bookmarklet?",
					 "A bookmarklet is a JavaScript file, plain and simple. The key of a bookmarklet is that the user can choose to drop this JavaScript file into any web page they choose. So it's a way to add functionality (like discovering sprites) to web pages that wouldn't otherwise have that functionality. I use bookmarklets frequently to enhance web sites. I build tools as bookmarklets as a first choice - that way they can run on all browsers. If I can't do what I want using a bookmarklet, I'll next try <a href='https://addons.mozilla.org/en-US/firefox/addon/748'>Greasemonkey</a>, and finally as a browser plug-in, typically a <a href='https://addons.mozilla.org/'>Firefox add-on</a>. See the <a href='http://en.wikipedia.org/wiki/Bookmarklet'>Wikipedia definition of bookmarklet</a> for more information.",
					 "bookmarklet"),

			   array("What browsers has SpriteMe been tested on?",
					 "SpriteMe has been tested successfully on Firefox 3.x, Ineternet Explorer 6-8, Chrome 2, and Safari 4. It generally works on Opera 10, but the sprite injection step needs more work.",
					 "testing"),

			   array("What's the \"share your results\" link do?",
					 "Sharing your results records SpriteMe's savings. These results are visible in the <a href='results.php'>savings</a> page. The results that are saved are the URL (minus any querystring), the number of background images and their total size <i>before</i> SpriteMe was run, and the number of background images and total size <i>after</i> SpriteMe was run. No personal information is saved. The IP address is not saved.",
					 "share"),

			   array("Is SpriteMe open source?",
					 "Yes. It's licensed under the <a href='http://www.apache.org/licenses/LICENSE-2.0'>Apache License, Version 2.0.",
					 "opensource"),

			   array("Where can I find the code?",
					 "On Google Code in the <a href='http://code.google.com/p/spriteme/'>spriteme</a> project.",
					 "code"),

			   array("How do I contribute a patch to the project?",
					 "TBD",
					 "patch"),

			   array("Where's the current bug list?",
					 "<a href='http://code.google.com/p/spriteme/issues/list'>bugs/issues</a>",
					 "bugs"),

			   array("How do I submit a bug?",
					 "Go to the <a href='http://code.google.com/p/spriteme/issues/list'>issues list</a> to submit a new issue. You have to be logged in with a Google account.",
					 "bug"),

			   array("Who created SpriteMe?",
					 "SpriteMe was created by <a href='http://stevesouders.com/'>Steve Souders</a>, the web performance guru behind <a href='http://developer.yahoo.com/yslow/'>YSlow</a>, <a href='http://www.amazon.com/High-Performance-Web-Sites-Essential/dp/0596529309'>High Performance Web Sites</a>, and <a href='http://www.amazon.com/Even-Faster-Web-Sites-Performance/dp/0596522304'>Even Faster Web Sites</a>.",
					 "bug"),

			   array("How are the images combined?",
					 "SpriteMe uses <a href='http://jaredhirsch.com/coolrunnings/about/'>coolRunnings</a>, a sprite generation service built by Jared Hirsch.",
					 "bug"),

			   array("Who do I contact for more information?",
					 "Go to the <a href='http://groups.google.com/group/spriteme/topics'>SpriteMe discussion list on Google Groups</a> and submit a post.",
					 "contact")

			   );


// print the list of questions
echo "<ul id=questions style='list-style-type: none; margin-left: 0; padding-left: 0;'>\n";
for ( $i = 0; $i < count($gFaqs); $i++ ) {
	$q = $gFaqs[$i][0];
	$anchor = $gFaqs[$i][2];
	echo " <li> Q: <a class=ahover href='#$anchor'>$q</a>\n";
}
echo "</ul>\n\n";


// print the list of questions
echo "<hr style='margin-top: 20px; margin-bottom: 20px;'>\n\n";
for ( $i = 0; $i < count($gFaqs); $i++ ) {
	$q = $gFaqs[$i][0];
	$a = $gFaqs[$i][1];
	$anchor = $gFaqs[$i][2];
	echo "<a name='$anchor'></a>\n<div class=question> Q: $q</div>\n";
	echo "<div class=answer> <b>A:</b> $a</div>\n\n";
}
echo "</ul>\n\n";
?>

<?php
echo spritemeFooter();
?>


</div> <!-- contents -->

</body>

</html>
