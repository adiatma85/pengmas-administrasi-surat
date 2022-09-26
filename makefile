run:
	php -S localhost:5000 -t public/

generate-swagger:
	php artisan l5-swagger:generate