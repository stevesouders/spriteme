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

<div>
<?php 
echo spritemeNav("faq");
?>
</div>

<br>

<p style="margin-top: 2em;">
Find out more about SpriteMe by reading <a href="http://www.stevesouders.com/blog/2009/09/14/spriteme/">these</a> 
<a href="http://www.stevesouders.com/blog/2009/09/18/spriteme-part-2/">blog</a>
<a href="http://www.stevesouders.com/blog/2009/09/21/spriteme-part-3/">posts</a> and watching this <a href="http://www.youtube.com/watch?v=pNfRL-TwzZY#t=27m21s">video</a>.
</p>

<style>
#results { display: none; }
.category { font-size: 1.2em; font-weight: bold; }
.questions LI { font-size: 1.1em; }
.questions A { color: #222; }
.question { font-weight: bold; margin-top: 20px; font-size: 1.1em; }
.answer {}
.comment { font-style: italic; font-size: 0.9em; }
</style>

<?php
$gFaqs = array(
			   array("category", "About Sprites"),
			   array("What are CSS sprites?",
					 "A sprite combines multiple background images into a single image. This is a technique for <a href='http://developer.yahoo.net/blog/archives/2007/04/rule_1_make_few.html'>making web pages faster</a> because it reduces the number of downloads in the page. See Chapter 1 in <a href='http://www.amazon.com/High-Performance-Web-Sites-Essential/dp/0596529309'>High Performance Web Sites</a> by Steve Souders for more information about the performance benefits of using sprites. See <a href='http://www.alistapart.com/articles/sprites'>CSS Sprites: Image Slicing's Kiss of Death</a> by Dave Shea for more information about how sprites work.",
					 "def"),

			   array("Why should I bother to create CSS sprites?",
					 "Using sprites reduces the number of HTTP requests in the page. This is one of technique for <a href='http://developer.yahoo.net/blog/archives/2007/04/rule_1_make_few.html'>making web pages faster</a>. This is especially important for users with slow Internet connections or who are far away from your servers. Also, some browsers, including Internet Explorer 6 and 7, can only make two HTTP requests in parallel (to the same server). If the page has multiple background images, they are downloaded sequentially, resulting in a slow page.",
					 "why"),

			   array("Do many web sites use CSS sprites? Does it make much difference?",
					 "The use of CSS sprites is growing. In 2007, only two of the Alexa top ten U.S. web sites used sprites. Today (2009) nine of the top ten sites use sprites. It's a recognized technique for speeding up web pages. And yet, many popular sites that could benefit from sprites don't use them. As of September 2009, here is a list of web sites with the number of HTTP requests that could be eliminated if they used sprites: <a href='http://www.cnn.com/'>CNN</a> (30), <a href='http://www.ebay.com/'>eBay</a> (21), <a href='http://online.wsj.com/home-page'>WSJ</a> (39), and <a href='http://www.usps.com/'>USPS</a> (37).",
					 "popular"),

			   array("category", "SpriteMe Functionality"),
			   array("What's a bookmarklet? Why did you create SpriteMe as a bookmarklet?",
					 "A bookmarklet is a JavaScript file, plain and simple. The key of a bookmarklet is that the user can choose to drop this JavaScript file into any web page they choose. So it's a way to add functionality (like discovering sprites) to web pages that wouldn't otherwise have that functionality. I use bookmarklets frequently to enhance web sites. I build tools as bookmarklets as a first choice - that way they can run on all browsers. If I can't do what I want using a bookmarklet, I'll next try <a href='https://addons.mozilla.org/en-US/firefox/addon/748'>Greasemonkey</a>, and finally as a browser plug-in, typically a <a href='https://addons.mozilla.org/'>Firefox add-on</a>. See the <a href='http://en.wikipedia.org/wiki/Bookmarklet'>Wikipedia definition of bookmarklet</a> for more information.",
					 "bookmarklet"),

			   array("What browsers has SpriteMe been tested on?",
					 "SpriteMe has been tested successfully on Firefox 3.x, Ineternet Explorer 6-8, Chrome 2, and Safari 4. It generally works on Opera 10, but the sprite injection step needs more work.",
					 "testing"),

			   array("What's the \"share your results\" link do?",
					 "Sharing your results records SpriteMe's savings. These results are visible in the <a href='results.php'>savings</a> page. The results that are saved are the URL (minus any querystring), the number of background images and their total size <i>before</i> SpriteMe was run, and the number of background images and total size <i>after</i> SpriteMe was run. No personal information is saved. The IP address is not saved. <em style='color: #900'>Do not share your results if you do not want other people to see your page's URL!</em>",
					 "share"),

			   array("Why aren't JPEG images sprited by SpriteMe?",
					 "Currently, SpriteMe has no knowledge of the number of colors uesd by each image. It's important to stay within the 255 color limit to minimize image file size. Creating sprites that combine jpegs with other images typically results in a significant increase in file size. It's possible that jpegs could be combined together and with other truecolor images. See <a href='http://code.google.com/p/spriteme/issues/detail?id=69'>issue #69</a>.",
					 "jpeg"),

			   array("category", "SpriteMe Gotchas"),
			   array("I get an error when I try \"make sprite\".",
					 "Although it's possible that the spriting web service is broken, this most frequently happens when someone tries to sprite images that are not publicly accessible. The sprite images must be accessible by the <a href='#coolRunnings'>coolRunnings</a> spriting service. If you can't make them publicly accessible, you could create a local instance of coolRunnings. Instructions for doing that are TBD.",
					 "firewall"),
			   array("Some DHTML background images weren't detected by SpriteMe.",
					 "SpriteMe finds the background images in the page by crawling the DOM. If you elements that are created dynamically, but aren't currently in the DOM, their background images won't be found. One workaround is to create a temporary page that uses all the background images. But it might actually be better if the sprite contained just the background images used in the initial rendering of the page, so the sprite image is smaller and downloads faster.",
					 "dhtml"),

			   array("category", "The SpriteMe Project"),
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
					 "creator"),

			   array("How are the images combined?",
					 "SpriteMe uses <a href='http://jaredhirsch.com/coolrunnings/about/'>coolRunnings</a>, a sprite generation service built by Jared Hirsch.",
					 "coolRunnings"),

			   array("Who do I contact for more information?",
					 "Go to the <a href='http://groups.google.com/group/spriteme/topics'>SpriteMe discussion list on Google Groups</a> and submit a post.",
					 "contact")

			   );


// print the list of questions
echo "<ul class=questions style='list-style-type: none; margin-left: 0 0 8px 20px; padding-left: 0;'>\n";
for ( $i = 0; $i < count($gFaqs); $i++ ) {
	$q = $gFaqs[$i][0];
	if ( "category" == $q ) {
		$category = $gFaqs[$i][1];
		echo "</ul><div class=category>$category</div><ul class=questions style='list-style-type: none; margin: 0 0 8px 20px; padding-left: 0;'>\n";
	}
	else {
		$anchor = $gFaqs[$i][2];
		echo " <li> Q: <a class=ahover href='#$anchor'>$q</a>\n";
	}
}
echo "</ul>\n\n";


// print the list of questions
echo "<hr style='margin-top: 20px; margin-bottom: 20px;'>\n\n";
for ( $i = 0; $i < count($gFaqs); $i++ ) {
	$q = $gFaqs[$i][0];

	if ( "category" == $q ) {
		continue;
	}

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
