<?php 
require_once("utils.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>SpriteMe Demo</title>

<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<style>
<?php
echo spritemeStyle();
?>

.fn { color: #530209; font-family: arial; }
</style>

</head>
<body>

<?php 
echo spritemeHeader("demo");
?>


<div id=contents class=contents>

<?php 
echo spritemeNav("demo");
?>

<br>
<br>
<br>
<br>

<div class="btn_box_demo"><div class="btn_top"><div></div></div><div class="btn_content_demo">
<table cellpadding=0 cellspacing=0 border=0 width=100% height=100%>
<tr>
<td id=demotalk style="font-size: 1.5em; vertical-align: middle; text-align: center;"></td>
</tr>
</table>
</div><div class="btn_bottom"><div></div></div></div>

<div style="width: 560px; font-size: 1.1em; text-align: center;">
  <div style="float: left; background: url(images/prev-10x11-transp.gif) no-repeat 0 70%; padding-left: 14px;"><a class=ahover href="javascript:prev()">prev</a></div>
  <div style="float: right; background: url(images/next-10x11-transp.gif) no-repeat 100% 70%; padding-right: 14px;"><a class=ahover href="javascript:next()">next</a></div>
  <span id=curstep></span>
</div>

<?php
echo spritemeFooter();
?>


</div> <!-- contents -->

<script>
function testIfLoaded() {
	return ( document.getElementById('spritemepanel') ?
			 'great! the SpriteMe panel should be on the right<p>SpriteMe found the background images used in this page<p>you can hover over an image link to see what that image looks like - try it' :
			 'hmmm...<p style="color: #C00">the SpriteMe panel doesn\'t seem to have been created<p>you can continue if you want, or go back one step and try again' );
}

var gStep = -1;
var gaSteps = [
			   'hi!<p>welcome to the SpriteMe demo<p>(click "next" to continue)',
			   'this tutorial shows how SpriteMe works<p>let\'s install SpriteMe and run it on this page',
			   'install SpriteMe by dragging this link to<br>your bookmarks toolbar:<p><a href="javascript:(function(){var%20spritemejs=document.createElement(\'SCRIPT\');spritemejs.type=\'text/javascript\';spritemejs.src=\'<?php echo curPath() ?>spriteme.js\';document.getElementsByTagName(\'head\')[0].appendChild(spritemejs);})();">SpriteMe</a><p>you can also right-click the link to add it to your favorites<p>if you get a warning, hit continue',
			   'click the SpriteMe bookmark you just created<p>the SpriteMe panel will be displayed',
			   testIfLoaded,
			   'find <span class=fn>logo-64x64-04.png</span> - it\'s last in the list<p>click the expand icon (<img src="images/plus-9x9.png" width=18 height=18>) to see the DOM elements that use this image<p>each element\'s background-position and size is shown',
			   '<span class=fn>logo-64x64-04.png</span> is used for the background in the header at top<p>hover over <span class=fn>DIV #siteheader</span> - see how the header at the top is highlighted in red?',
			   'click on <span class=fn>DIV #siteheader</span> in the list<p>this lets you inspect it using <a href="http://getfirebug.com/lite.html">Firebug Lite</a><p>click OK when prompted to use Firebug Lite<p>inspecting <span class=fn>DIV #siteheader</span> shows that its backgroundImage is indeed <span class=fn>logo-64x64-04.png</span><p>close Firebug Lite (click on its "X")',

			   'that\'s feature 1: SpriteMe makes it easy to investigate background images in the page<p>now let\'s look at SpriteMe\'s logic...',

			   'the really complicated part about sprites is figuring out which images can be combined together - SpriteMe does that for you<p>here, SpriteMe grouped the background images<br>into two sprites<p>first, we\'ll look at the <span class=fn>vertical, varied width</span> sprite',
			   'SpriteMe started with the simple case by grouping non-repeating background images of similar sizes into the <span class=fn>vertical, varied width</span> sprite<p><span class=fn>logo-64x64-04.png</span> wasn\'t included because it\'s quite a bit wider (64px) than the other images (10px), but go ahead and drag-and-drop it onto the top box<p>drag-and-drop lets you create custom sprites',
			   'now click "make sprite" for <span class=fn>vertical, varied width</span><p>you just eliminated six HTTP requests!<p>(the before and after count is shown at the top)',
			   'you can see the result of spriting by hovering over the newly created image <span class=fn>spriteme1.png</span><p>all the images are combined into one sprited image',
			   'that\'s two more features:<p>feature 2: SpriteMe has the logic to group<br>images into sprites<p>feature 3: SpriteMe automatically generates the combined sprite image<p>that all happened pretty fast, let\'s dig a little deeper...',

			   'expand the list of elements for <span class=fn>spriteme1.png</span><p>those elements are now using the sprited image<p>next to each element is the modified<br>CSS background position',
			   'feature 4: SpriteMe recomputes the<br>background-position CSS<p>this is complex - the fact that SpriteMe does this automatically while preserving the page\'s appearance is a big win',

			   'click on <span class=fn>DIV #siteheader</span> and inspect it in Firebug Lite<p>now its backgroundImage is <span class=fn>spriteme1.png</span><p>SpriteMe updated the live page - cool!',
			   'when you created that sprite, the page didn\'t change at all - how do we know the sprite worked?<p>SpriteMe modified this page to use the new sprite<p>the fact that you didn\'t notice any visual difference<br>is a good thing!',
			   'feature 5: SpriteMe injects the sprite into the current page so you can visually confirm that the sprite works',

			   'one more cool feature<p>let\'s look at the logic behind the <span class=fn>repeat-x width=10</span> sprite',
			   'SpriteMe has suggested combining two images, <span class=fn>btn_grad.gif</span> and <span class=fn>btn_grad_sel.gif</span><p>repeat-x images can be combined if they are<br>the same width<p>but <span class=fn>btn_grad.gif</span> and <span class=fn>btn_grad_sel.gif</span> are different<br>widths (10px and 5px)',
			   'SpriteMe is smart enough to know it can combine these images if it doubles the width of <span class=fn>btn_grad_sel.gif</span><p>and SpriteMe does that automatically<p>click "make sprite" for <span class=fn>repeat-x width=10</span>',
			   'hover over the new sprite image <span class=fn>spriteme2.png</span><p>SpriteMe doubled the width of the purple background to 10px so it could be combined with the other image<p>we\'ve reduced this page from 9 background images to 2<p>that\'s 7 HTTP requests that have been eliminated',
			   'SpriteMe\'s work is done<p>at this point, the developer would save the sprited image(s) and integrate the CSS changes back into their code<p>a faster page with just a few minutes of work',
			   '<div style="text-align: left; margin-left: 20px;">SpriteMe features:<ol style="margin-top: 0;"><li>finds background images<li>groups images into sprites<li>generates the sprite<li>injects the sprite into the current page<li>recomputes the CSS background-position</ol>',
			   'thanks for walking through the demo<p>happy spriting!'
              ];

function next() {
	gStep++;
	var sText;
	if ( gStep >=  gaSteps.length ) {
		gStep = gaSteps.length;
		sText = 'the end';
	}
	else {
		sText = ( "function" === typeof(gaSteps[gStep]) ? gaSteps[gStep]() : gaSteps[gStep] );
		updateStep();
	}

	document.getElementById('demotalk').innerHTML = sText;
}

function prev() {
	gStep--;
	var sText;
	if ( gStep < 0 ) {
		gStep = 0;
	}

	sText = ( "function" === typeof(gaSteps[gStep]) ? gaSteps[gStep]() : gaSteps[gStep] );
	updateStep();

	document.getElementById('demotalk').innerHTML = sText;
}

function updateStep() {
	document.getElementById('curstep').innerHTML = (gStep+1) + " of " + (gaSteps.length);
}

window.onload = next;
</script>

</body>

</html>
