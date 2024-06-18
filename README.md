# Website Link Scraper Koombea Challenge

This project is a web scraper built using PHP 8.2, Laravel 11, Blade templates, and Roach PHP. The web scraper is designed to extract links from specified websites and display it in a user-friendly format.

## Features

- Scrapes links from specified websites.
- Displays scraped data using Blade templates.
- Uses Roach PHP for efficient web scraping.
- Built with Laravel 11 for a robust and scalable framework.

## Requirements

- PHP 8.2
- Composer
- Laravel 11
- Node.js and npm (for frontend assets)
- Roach PHP
- PHPUnit

## Installation

Follow these steps to set up and run the project on your local machine.

### 1. Clone the Repository

```bash
git clone https://github.com/thonnysee/scraper_test.git
cd scraper_test
```
### 2. Install Dependencies

```bash
composer install
npm install
npm run build
```

### 3. Configure Environment Variables
Copy the example environment file and set your configuration.

```bash
cp .env.example .env
```

Edit the .env file to set your database connection and other configurations.

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Migrations
```bash
php artisan migrate
```

### 6. Serve the Application
```bash
php artisan serve
```

The application will be available at http://localhost:8000.

## Docker Compose

There is an instance of docker compose to use a MySQL Database in case it is needed. You will need to have docker running. 

Run the next commands:

```bash
docker-compose build
docker-compose up
```
This is the configuration for the default Database:

``` yaml
MYSQL_ROOT_PASSWORD: 'koombea'
MYSQL_DATABASE: 'koombea'
MYSQL_USER: 'koombea'
MYSQL_PASSWORD: 'koombea'
PORT: '3310'
```
<em><strong> Used port 3310 to avoid conflict with other MySQL instances on the same port</strong> </em>

## Testing
To test the whole application, execute the following command:

```bash
php artisan test
```

## Viewing Scraped Data
Register an user with name, email and password. 

After that just log in your account and you can start scraping sites using the input box.

<em>NOTE: The scraper uses the tag "a" for getting all the links so in some cases it will bring only the route not the whole link so be careful when clicking the links. Also be aware it gets all the tags so it could bring some weird stuff </em>

## Author

Developed by [Antonio Carbajal](https://github.com/thonnysee).


## License
This project is open-sourced software licensed under the MIT license.