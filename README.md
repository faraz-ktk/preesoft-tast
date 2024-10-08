# Laravel Application with Sanctum Authentication

This is a Laravel 10 application featuring Sanctum authentication, enabling users to register, log in, and interact with posts and comments. The application offers robust user management, post creation, and the ability to view users who have received likes on their comments.

## Features

- **User Authentication**: Secure user registration, login, and logout functionality powered by Laravel Sanctum.
- **Post Management**: Users can create, update, and delete their posts.
- **Post Viewing**: Browse and view all posts created by users.
- **Commenting**: Engage with posts by commenting on them.
- **Likes**: Like and unlike comments on posts.
- **User Likes Overview**: View users who have received at least one like on their post comments, including those who liked their own comments.

- **Note**:  I created an endpoint /post in api.php that can be tested using Postman to authenticate third-party requests. For now, I have only implemented one API endpoint in api.php. After logging in or registering a user, you can obtain the token from the logs. Copy this token and include it in the headers when making requests via Postman. If the token is not valid or not provided, the request will not return any data, such as posts.
- **Api** test the api from postman:  
- **Featurer testing  as well** test the api from postman:  



## Requirements

- PHP 8.2
- Composer
- Laravel 10

## Installation

### 1. Clone the Repository

Begin by cloning the repository to your local machine:

```bash
git clone https://github.com/faraz-ktk/preesotf-task.git
cd preesotf-task


### 2. Install Dependencies
Ensure Composer is installed on your machine. Update the Composer dependencies by running:
```bash
composer update

### 3.  Set Up Environment
Copy the .env.example file to .env and configure your environment variables, such as database credentials:
```bash
Copy the .env.example file to .env and configure your environment variables, such as database credentials:

### 4.  Generate Application Key
Generate a unique application key:

```bash
php artisan key:generate


### 5.  Generate Application Key
Run Migrations
```bash
php artisan migrate

### 6.  Generate Application Key
Run Migrations
```bash
php artisan migrate


### 7.  Seed the Database
Seed the database with initial data. This command creates five dummy users with the password password123@. You can also register additional users through the registration form.
```bash
php artisan db:seed --class=UserSeeder



### 8.   Serve the Application
Start the Laravel development server:
```bash
php artisan serve


#Demonstration
For a quick demonstration of the application, you can watch the following video:
https://www.loom.com/share/64b45bb20e3544898fb3b42ecf560c98






