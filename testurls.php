<?php
require_once("utils.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>SpriteMe testurls</title>

<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<style>
<?php
echo spritemeStyle();
?>

</style>

</head>
<body>

<?php 
echo spritemeHeader("testurls");
?>


<div id=contents class=contents>

<?php 
echo spritemeNav("testurls");
?>

<br>

<div style="margin-bottom: 20px;">
<input type=button value="Start Test" onclick="startTest()">
<input type=button value="Stop Test" onclick="stopTest()" style="margin-left: 12px;">
<input type=button value="Continue" onclick="continueTest()" style="margin-left: 12px;">
<p>
test name: <input type=text size=32 id=testname name=testname value=""> (if you use this, run from spriteme.org)
<p>
delay interval: <input type=text size=5 id=delay value=15000> milliseconds
</div>

<div style="float: right; width: 400px; margin: 20px; border: 1px solid #AAA; padding: 8px; background: #EEE;">
This page is to be used to test changes to the SpriteMe.js logic.
If you specify a test name, you can use the savings diff page to compare results.
</div>

<div id=urls>
<form name=form1>
<?php
for ( $i = 0; $i < count($gaUrls); $i++ ) {
	$url = $gaUrls[$i];
	echo "<input type=radio name=starturl value=$i" . 
	($i == 0 ? " checked" : "" ) . "> " . ($i+1) . ". <a href='$url' id=url$i target='testwin'>$url</a><br>\n";
}
?>
</form>
</div>

<?php
echo spritemeFooter();
?>


</div> <!-- contents -->

<script>
var aUrls;
var gStop = false;
var giUrl = 0;
var gTestname = "";

function startTest() {
	gStop = false;
	giUrl = 0;

	var testname = document.getElementById('testname').value;
	if ( testname != gTestname ) {
		// set a cookie
		gTestname = testname;
		document.cookie = "testname=" + gTestname;
	}

	var urlsDiv = document.getElementById('urls');
	if ( urlsDiv ) {
		aUrls = urlsDiv.getElementsByTagName('a');
		setStartUrl();
		loadUrl();
	}
}


function setStartUrl() {
	var aRadios = document.form1.starturl;
	var iUrl = 0;
	for ( var i = 0; i < aRadios.length; i++ ) {
		var radio = aRadios[i];
		if ( radio.checked ) {
			iUrl = i;
			break;
		}
		else {
			markUrl("url" + i);
		}
	}

	giUrl = i;
}

function stopTest() {
	gStop = true;
}


function continueTest() {
	gStop = false;
	loadUrl();
}


function loadUrl() {
	if ( gStop ) {
		return;
	}

	var a = aUrls[giUrl];
	markUrl(a);
	var url = a.href;
	giUrl++;
	window.open(url, "testwin");

	var delay = document.getElementById('delay').value;
	setTimeout(loadUrl, delay);
}


function markUrl(IdOrElem) {
	var anchor = IdOrElem;
	if ( "object" !== typeof(IdOrElem) ){
		anchor = document.getElementById(IdOrElem);
	}

	if ( anchor ) {
		anchor.style.color = "#A55";
	}
}

</script>

</body>

</html>
