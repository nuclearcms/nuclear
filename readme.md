# Nuclear
Polymorphic content management system.

---

## Installation
Installing Nuclear is (sort of) simple.

1. Download one of the releases or the commit ZIP file.
    1.1. If you download the ZIP file, don't forget to run composer install.
2. Rename .env.example to .env
3. Configure Nuclear
    3.1. Create a new database
    3.2. Set database parameters in .env
    3.3. Comment out AuthServiceProvider and RouteServiceProvider in config/app.php
    3.4. Use php artisan migrate to migrate the database
    3.5. Uncomment the services
4. Now that everything is set, just seed the database by running php artisan db:seed.
5. Enjoy (login from /reactor with admin@admin.com, admin)

*Note: A pretty installer will be implemented in 2.1 version.*

## Documentation
Nuclear documentation is still being worked on. It will be published as soon as possible.

## License
Nuclear is released under [MIT License](https://github.com/NuclearCMS/Nuclear/blob/master/LICENSE).