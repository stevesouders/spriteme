// ==UserScript==
// @name           Autorun SpriteMe
// @description	   Run SpriteMe automatically at the onload event.
// @include        *
// ==/UserScript==

bAutosprite = false;     // set to true to automatically create all suggested sprites
bShareResults = false;   // set to true to automatically send your results back to spriteme.org

if ( top == self ) {  // avoid running in iframes
	// setup callbacks for autospriting and sharing results, if specified
	if ( bAutosprite ) {
		spritemejs1=document.createElement('SCRIPT');
		spritemejs1.type='text/javascript';
		spritemejs1.text = "SpriteMe_autospriteCallback = function() { " +
			( bShareResults ? "SpriteMe.shareSavings();" : "" ) + " };";
		document.getElementsByTagName('head')[0].appendChild(spritemejs1);
	}

	// launch SpriteMe
	spritemejs=document.createElement('SCRIPT');
	spritemejs.type='text/javascript';
	spritemejs.src='http://spriteme.org/spriteme.js';
	document.getElementsByTagName('head')[0].appendChild(spritemejs);
}
