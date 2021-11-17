# Prepare for production
production: ensure-composer ensure-permissions enable-cache build-assets

ensure-composer:
	composer update --ignore-platform-req=php --optimize-autoloader

ensure-permissions:
	#chmod -R o+w storage

enable-cache:
	php artisan cache:clear
	php artisan config:clear
	composer dump-autoload
	php artisan view:clear

build-assets:
	npm update
	npm run prod
