# https://github.com/FriendsOfPHP/PHP-CS-Fixer
cs-fixer:
	@./vendor/bin/php-cs-fixer fix --verbose --show-progress=estimating

# https://github.com/vimeo/psalm
psalm:
	@./vendor/bin/psalm src/
