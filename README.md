To run app locally:
+ Recruitments - mysql 8.0, PHP 8.1.2, composer 2.x, npm 6.14.4, git, symfony-cli
+ Install simfony-cli https://symfony.com/download
+ Open cli in location where app will be stored
+ Run "git clone git@github.com:artursBiezbardis/recipes_page.git" on cli
+ Open cli in app root folder
+ Open .env, in line 15- change username and password for DB - use your mysql credentials
+ In cli run composer install
+ In cli run npm install
+ In cli run symfony server:start