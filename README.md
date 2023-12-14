# Data Feed Project

## Installation

Clone project in your local machine by using command
```bash
git clone https://github.com/techcodex/datafeed
```

After Cloning the project into your local machine go to the project directory and open
terminal into your project directory and run these Commands

```bash 
composer install
```
Run this following command in your terminal for getting new .env configuration file
```bash
cp .env.example .env
```
Run following artisan command to generate unique application key
```bash
php artisan key:generate
```
Run this command 
```bash
composer dump-autoload
```
Open `localhost/phpmyadmin` and create new Database with any name you want.

## Setting Project Configurations

Open your project in any **IDE** such as Visual Code, Php Storm, Netbeans. Open `.env`
file and update your project configuration

1. Change **APP_URL** value with the url you access your project with. If you are using **XAMPP**
   then URL might be **http://localhost/project_name** , if you are using laragon then **APP_URL** will be **http://project_name.test**
2. Replace **DB_DATABASE** constant value with the name of the database you created in phpmyadmin
3. Replace **DB_USERNAME** constant with the name of your phpMyAdmin User Name e.g (root).
4. If your Database is using any password then change **DB_PASSWORD** constant value with
   your database password if your database is not using any password then leave it empty.
7. Then Run this command in your terminal to push all migrations to database you created. 
```bash
php artisan migrate
```

## Starting up project
1. Run this command in your terminal
```bash
php artisan process:data
```
2. This command will ask two arguments from you, the first argument will be the **Data Source** from which you want to read the data from e.g (Data file, Api, Database, etc) and the second argument will be the datafile **path** which you want to import. If the data source is data file then provide the path to the file and if the datasource is api then provide Api link.
3. This `processData.php` command will be responsible to process datafile which is located under `app\Console\Commands\ProcessData.php`
4. The command will process the datafile and store the data into database
5. The command will print **Data processed successfully** in the terminal upon successful insertion into database otherwise it will print error message in terminal and log file

## Change Database Driver
1. if you want to use database other than mysql then you can specify which database to use in .env file change 
```ini
DB_CONNECTION=mysql
``` 
to 
```ini
DB_CONNECTION=sqlite
``` 
and comment these three lines

```ini
#DB_DATABASE=datafeed_db
#DB_USERNAME=root
#DB_PASSWORD=
```
Create database.sqlite in `database\database.sqlite` and then run these two commands in your terminal

```bash
php artisan config:clear
php artisan migrate
```

these drivers are written in `config/database.php` file. By default Laravel support 5 databases, you can see the list [Here](https://laravel.com/docs/10.x/database#introduction)

2. If you want to use a database driver which is not available under `config/database.php` connections array then you need to install related package for it.

## How to add new Datasource
Let's suppose database is our new data source then you need to do following steps 
1. Create a service called `DatabaseReaderService.php` under `app/Services/` directory
2. Create new interface in `app/Contracts` called `DatabaseReader.php` this interface will have one method called `readDatabase`
3. `DatabaseReaderService.php` class will implement two interfaces `Reader.php` and `DatabaseReader.php` the implementation of how data will be read from database will be written in `DatabaseReader.php` method and the `read()` method will call this method and return the result to `DataParserService` class.
4. In `ProcessData.php` file you just need to write this in switch case 
```php
$this->dataParserService->handle(new DataReaderService, $tablename);
```
5. The **ApiReaderService** has been already created for proof of concept.

## Testing
You can find all the tests in `tests` directory. To test the application, run the following command,
```bash
php artisan test
``` 
By running this command you will see all the tests running in your CLI.

## Logs
You can find all the logs in `storage\logs\laravel.log`