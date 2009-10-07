<?php

function spritemeStyle() {
	return <<<OUTPUT
BODY { margin: 0; font-family: "trebuchet ms", sans-serif; color: #222; font-size: 10.5pt; }
#siteheader { padding: 8px 8px 0 12px; background: url(images/logo-64x64-04.png) repeat-x; height: 64px; }
A.navlink, A.navlink:visited { text-decoration: none; color: #000; }
A.navlink:hover { text-decoration: underline; }
A { color: #404; }
A:visited { color: #695782; }
H2 { margin-bottom: 0; margin-top: 8px; font-weight: normal; font-size: 2em; }
.ahover, .ahover:visited { text-decoration: none; }
.ahover:hover { text-decoration: underline; }
.contents { width: 800px; margin: 8px 16px 16px 16px; }
.imgborder { border: 2px solid #CCC; padding: 4px; background: #EEE; }
.sprite { margin-bottom: 20px; float: left; width: 200px; }

.btn_box { background: #CCC url(images/btn_grad.gif) repeat-x 0 -25px; width: 65px; text-align: center; float: right; margin-right: 8px; }
.btn_box_sel { background: #FFD8FF url(images/btn_grad_sel.gif) repeat-x 0 -10px; width: 65px; text-align: center; float: right; margin-right: 8px; }
.btn_box_demo { background: #CEEEF4; width: 560px; margin-right: 8px;  }
.btn_top div { background: url(images/btn_white_tl.gif) no-repeat top left; }
.btn_top { background: transparent url(images/btn_white_tr.gif) no-repeat top right; }
.btn_bottom div { background: url(images/btn_white_bl.gif) no-repeat bottom left; }
.btn_bottom { background: transparent url(images/btn_white_br.gif) no-repeat bottom right; }
.btn_top div, .btn_top, .btn_bottom div, .btn_bottom { width: 100%; height: 10px; font-size: 1px; }
.btn_content { margin: 0 10px; line-height: 0.4; }
.btn_content_demo { margin: 0 10px; height: 240px; }
OUTPUT;
}


function spritemeHeader($sSubtitle = "") {
	return '<div id=siteheader> <div style="width: 800px; font-size: 3em; color: #222;">' .
		'<a href="."><img border=0 src="images/spriteme-200x49-transp.gif" width=200 height=49 style="vertical-align: bottom;"></a> ' . 
		( $sSubtitle ? '<span style="font-size: 0.9em;">' . $sSubtitle . '</span>' : '' ) .
		'</div></div>';
}


function spritemeFooter() {
	$sFooter =<<<OUTPUT
<hr style='margin-top: 80px; color: #A293B7;'>
<div style='text-align: center; width: 800px; margin-bottom: 20px;'>
<a style='margin-left: 16px;' href='.'>Home</a>
<a style='margin-left: 16px;' href='http://code.google.com/p/spriteme/'>Code</a>
<a style='margin-left: 16px;' href='http://groups.google.com/group/spriteme'>Group</a>
<a style='margin-left: 16px;' href='http://code.google.com/p/spriteme/issues/list'>Bugs</a>
<a style='margin-left: 16px;' href='http://groups.google.com/group/spriteme/post'>Contact</a>
</div>

<script type='text/javascript'>
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-10547666-1']);
_gaq.push(['_trackPageview']);

document.documentElement.firstChild.appendChild(document.createElement('script')).src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/u/ga_beta.js';
</script>
OUTPUT;

    return $sFooter;
}

function spritemeNav($sPage) {
	return 
		'<div id=sav_btn class="btn_box' .
		( 'sav' == $sPage ? '_sel' : '' ) .
		'"><div class="btn_top"><div></div></div><div class="btn_content"><a class=navlink href="results.php">Savings</a></div><div class="btn_bottom"><div></div></div></div>' .

		'<div id=faq_btn class="btn_box' .
		( 'faq' == $sPage ? '_sel' : '' ) .
		'"><div class="btn_top"><div></div></div><div class="btn_content"><a class=navlink href="faq.php">FAQ</a></div><div class="btn_bottom"><div></div></div></div>' .

		'<div id=demo_btn class="btn_box' .
		( 'demo' == $sPage ? '_sel' : '' ) .
		'"><div class="btn_top"><div></div></div><div class="btn_content"><a class=navlink href="demo.php">Demo</a></div><div class="btn_bottom"><div></div></div></div>' .

		'<div id=home_btn class="btn_box' .
		( 'home' == $sPage ? '_sel' : '' ) .
		'"><div class="btn_top"><div></div></div><div class="btn_content"><a class=navlink href=".">Home</a></div><div class="btn_bottom"><div></div></div></div>' .

		'';
}

// return the full URL to the current path, eg, "http://spriteme.org/images/"
function curPath() {
	$curUrl = curUrl();
	return substr($curUrl, 0, strrpos($curUrl, "/") + 1);
}

function curUrl() {
	$protocol = ( "on" == $_SERVER["HTTPS"] ? "https" : "http" );
	$port = ( "80" != $_SERVER["SERVER_PORT"] ? ":" . $_SERVER["SERVER_PORT"] : "" );
	$curUrl = $protocol . "://" . $_SERVER["SERVER_NAME"] . $port . $_SERVER["REQUEST_URI"];

	return $curUrl;
}

// Alexa U.S. top 100 9/4/09
$gaUrls = array("http://google.com/",
				"http://yahoo.com/",
				"http://facebook.com/",
				"http://youtube.com/",
				"http://myspace.com/",
				// now bing "http://live.com/",
				"http://wikipedia.org/",
				"http://craigslist.org/",
				"http://ebay.com/",
				"http://msn.com/",
				"http://blogger.com/",
				"http://amazon.com/",
				"http://aol.com/",
				"http://twitter.com/",
				"http://go.com/",
				"http://bing.com/",
				"http://cnn.com/",
				"http://flickr.com/",
				"http://espn.go.com/",
				"http://wordpress.com/",
				"http://microsoft.com/",
				"http://imdb.com/",
				"http://photobucket.com/",
				"http://linkedin.com/",
				"http://weather.com/",
				"http://comcast.net/",
				"http://about.com/",
				"http://nytimes.com/",
				"http://apple.com/",
				"http://netflix.com/",
				"http://cnet.com/",
				"http://doubleclick.com/",
				"http://zynga.com/",
				"http://verizon.net/",
				"http://mapquest.com/",
				"http://hulu.com/",
				"http://foxnews.com/",
				"http://adobe.com/",
				"http://rapidshare.com/",
				"http://walmart.com/",
				"http://digg.com/",
				"http://rr.com/",
				"http://answers.com/",
				"http://mlb.com/",
				"http://reference.com/",
				"http://ask.com/",
				"http://ehow.com/",
				"http://bbc.co.uk/",
				"http://target.com/",
				"http://mozilla.com/",
				"http://att.com/",
				"http://livejournal.com/",
				"http://bankofamerica.com/",
				"http://bestbuy.com/",
				"http://mywebsearch.com/",
				"http://yelp.com/",
				"http://ning.com/",
				"http://usps.com/",
				"http://huffingtonpost.com/",
				"http://deviantart.com/",
				"http://dell.com/",
				"http://twitpic.com/",
				"http://ezinearticles.com/",
				"http://vmn.net/",

				//"http://fastclick.com/",
				"http://valueclickmedia.com/",

				"http://imageshack.us/",

				//"http://att.net/",
				"http://att.my.yahoo.com/",

				"http://wsj.com/",
				"http://pandora.com/",
				"http://newegg.com/",
				"http://ups.com/",
				"http://tagged.com/",
				"http://disney.go.com/",
				"http://thepiratebay.org/",
				"http://files.wordpress.com/",
				"http://washingtonpost.com/",
				"http://foxsports.com/",
				"http://latimes.com/",
				"http://comcast.com/",
				"http://expedia.com/",
				"http://verizonwireless.com/",
				"http://gamefaqs.com/",
				"http://gamespot.com/"
				);

?>
