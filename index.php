<?php 
require_once("utils.php");
require_once("results.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>SpriteMe</title>

<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<style>
<?php
echo spritemeStyle();
?>

</style>

</head>
<body>

<?php 
echo spritemeHeader();
?>



<div id=contents class=contents>

<?php 
echo spritemeNav("home");
?>

<h2 style="margin-top: 0;">Spriting made easy</h2>

<div style="margin-left: 20px; margin-top: 4px; width: 600px;">
Background images make pages look good, but also make them slower.
Each background image is an extra HTTP request.
There's a fix: combine background images into a <a href="faq.php#def">CSS sprite</a>.
But creating sprites is hard, requiring arcane knowledge and lots of trial and error.
SpriteMe removes the hassles with the click of a button.

<p>
Try it on this page:

<input type=button value="Run SpriteMe" onclick="(function(){spritemejs=document.createElement('SCRIPT');spritemejs.type='text/javascript';spritemejs.src='spriteme.js';document.getElementsByTagName('head')[0].appendChild(spritemejs);})();">
</div>



<h2>Installation</h2>

<div style="margin-left: 20px; margin-top: 4px; width: 600px;">
Install SpriteMe by dragging this link to your bookmark toolbar or right-click to add it to your favorites:
<div style="margin: 8px 8px 20px 80px;">
<a style="font-size: 1.2em;" href="javascript:(function(){var%20spritemejs=document.createElement('SCRIPT');spritemejs.type='text/javascript';spritemejs.src='<?php echo curPath() ?>spriteme.js';document.getElementsByTagName('head')[0].appendChild(spritemejs);})();">SpriteMe</a>
<img src="images/drag-this-link-107x32.png" width=107 height=32 style="vertical-align: bottom; margin-left: 8px;">
</div>

</div>




<h2>How to use it</h2>

<div style="margin-left: 20px; margin-top: 4px; width: 600px;">
Try the <a href="demo.php">SpriteMe demo</a> to see how SpriteMe:
<ul style="font-size: 1.2em;">
  <li> finds background images
  <li> groups images into sprites
  <li> generates the sprite
  <li> recomputes CSS background-positions
  <li> injects the sprite into the current page
</ul>

</div>

<p style="margin-top: 40px;">
<?php
echo getSummarySavings();
?>
</p>

<?php
echo spritemeFooter();
?>


</div> <!-- contents -->

</body>

</html>
