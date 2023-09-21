# laravel-test
In this project we have created simgle product checkout system using stripe.
Project setup:
1.	Run migration "php artisan migrate"
2.	Populate users using "php artisan db:seed --class=DatabaseSeeder"
3.	Roles users using "php artisan db:seed --class=addRolesSeeder"
4.	Demo Products users using "php artisan db:seed --class=addDemoProductsSeeder"
5.	Category users using "php artisan db:seed --class=addCategorySeeder"
6.	Run server "php artisan serve"
7.	Open login page
8.	Enter credentials then it will be redirected to products page
9.	From product page select purchase button then it will be redirected you to stripe checkout page.
10.	Enter details and checkout
