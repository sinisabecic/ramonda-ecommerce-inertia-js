# Ramonda Ecommerce + Inertia JS

![](https://s1.gifyu.com/images/ezgif.com-gif-makeraf5064b503b7e4b6.gif)

## Installation

Clone the repo locally:

```sh
git clone https://github.com/sinisabecic/ramonda-ecommerce-inertia-js.git ramonda-ecommerce
cd ramonda-ecommerce
```

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm install
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.

```sh
touch database/database.sqlite
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Visit Ping CRM in your browser, and login with:

- **Username:** sinisa.becic@outlook.com
- **Password:** sinisa94

## Running tests

To run the Ping CRM tests, run:

```
phpunit
```
