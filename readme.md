# Nuclear
Polymorphic content management system.

---

**IMPORTANT:** Nuclear is being rewritten for version 3.

## Installation
Installing Nuclear is (sort of) simple.

1. Download one of the releases or the commit ZIP file.
    1. If you download the ZIP file, don't forget to run composer install.
    
2. Rename `.env.example` to `.env`
3. Configure Nuclear
    1. Create a new database
    2. Set database parameters in .env
     Comment out `AuthServiceProvider` and `RouteServiceProvider` in `config/app.php`
    4. Use `php artisan migrate` to migrate the database
    5. Uncomment the services
    6. Use `php artisan clear-compiled` and `php artisan optimize --force` to generate a fresh class loader.
    7. Use `php artisan key:generate` to generate the application key
    
4. Now that everything is set, just seed the database by running `php artisan db:seed`.
5. Enjoy (login from `/reactor` with `john@doe.com` and `secret`)

*Note: A pretty installer and integration tests will be implemented with version 3.*

## Documentation
Nuclear documentation is still being worked on. It will be published as soon as possible.

## License
Nuclear is released under [MIT License](https://github.com/NuclearCMS/Nuclear/blob/master/LICENSE).