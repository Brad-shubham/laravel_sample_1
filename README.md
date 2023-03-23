# Sample Learning App

### Prerequisites 
* php v7.3, [see](https://laravel.com/docs/installation) Laravel specific requirements
* Apache v2.4.39 with ```mod_rewrite```
* MySql v5.7.25
* [Composer](https://getcomposer.org) v1.10
* [node-js](https://github.com/creationix/nvm) >=10.15.0 and [yarn](https://yarnpkg.com/en/) >=1.13

### Quick setup 
* Clone this repo, checkout to ```dev``` branch
* Install dependencies
```
composer install
npm install
```
* Write permissions on ```storage``` and ```bootstrap/cache``` folders
* Create config (copy from ```.env.example```), and update environment variables in ```.env``` file
```
cp .env.example .env
php artisan key:generate
```
* Migrate and Seed database
```
php artisan migrate
php artisan db:seed
```
* Create the symbolic link for local file uploads
```
php artisan storage:link
```
* [Laravel Passport](https://laravel.com/docs/5.8/passport) requires to run this command for the first time
```
php artisan passport:keys
```
* Point your web server to **public** folder of this project
* Additionally you can run this command on production server
```
php artisan optimize
```

### Asset building
* You can use terminal commands:
* During development
```
# incremental build
npm run watch
# hmr
npm run hot
```
* On production
```
npm run prod
```

### Credentials
* Development credentials can be found in `database/seeds`
* In production you may want to create very first user using the command -
```
php artisan create:user
```

### 3rd party services used
* E-mail Service
* SMS Service
