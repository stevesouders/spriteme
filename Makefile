push :
	mkdir -p ~/spriteme.org
	cp -p .htaccess autospriteme.user.js demo.php faq.php index.php results.php spriteme.js utils.php ~/spriteme.org/.
	mkdir -p ~/spriteme.org/images
	cp -p images/*.gif images/*.png images/*.ico ~/spriteme.org/images/.
	cp -p images/favicon.ico ~/spriteme.org/.
	mkdir -p ~/spriteme.org/private
	cp -p private/db.php ~/spriteme.org/private/.
