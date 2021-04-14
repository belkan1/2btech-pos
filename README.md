# laravel-vue-pos
POS in laravel + vue. Not my work, i just translated and debugged

## Installation

Use the package manager (composer and npm) for installing

1. Do the following commands for installing
```bash
git clone https://github.com/zuramai/laravel-vue-pos.git
cd laravel-vue-pos
composer install
npm install
copy .env.example .env
php artisan key:generate
```

2. Create a database and import **laravel_pos.sql** 
3. Setting database name, username, and password in your .env file
4. Do the following instructions if you're done setting database in .env
```bash
php artisan jwt:secret
php artisan config:cache
```
## Debugging

run composer install after downloading git repository.

If it gives index:name not found/empty message after composer install then replace packagemanifest.php in vendor folder
with packagemanifest.php of another working project.

Dont run composer update


## To run the application
```bash
php artisan serve
npm run serve
```


## Admin Credentials
1.  Username: **admin**
    Password: **admin**

    
    
## License
[MIT](https://choosealicense.com/licenses/mit/)
