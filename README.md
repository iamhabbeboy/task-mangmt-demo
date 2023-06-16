## Task Management Demo

- Clone or unzip the project 
- You can start the project either with Docker or the conventional laravel server

### Installing packages
Run `composer install` and `npm install` to install both laravel package and javascript related packages. 

### Docker Setup 
Make sure docker is installed on your machine, then execute this command from the project directory.
```bash
    cd deploy && docker-compose up -d
```
NB: Check if the `.env` file exist or else duplicate the `.env.example`. Change to `DB_HOST=mysql`.

To run migration, enter the docker PHP shell environment
```bash
    docker exec -it php sh
    php artisan migrate
    php artisan db:seed
```
Then goto your browser, and type http://localhost:82. 🎉

### Laravel server
Make sure you have Mysql and PHP 8.1 installed.

Create a database in your mysql server, then update the Database details in the `.env` or duplicate the `.env.example` file.

Open your shell or command line, then run 
```bash
    php artisan migrate
    php artisan db:seed
```
Start your server with 
```bash
    php artisan serve
```

Go to the browser, and type http://localhost:8000 

### Preview
![Sample preview](https://res.cloudinary.com/denj7z5ec/image/upload/v1686916879/sample_ntqgtf.gif)
