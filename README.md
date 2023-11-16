# Laravel Installation Guide

## Introduction

This guide will walk you through the steps to install Laravel, a powerful PHP web framework. Laravel provides an elegant syntax and a variety of tools for tasks such as routing, migrations, and authentication, making it an excellent choice for building modern web applications.

## Prerequisites

Before you begin, ensure that you have the following installed on your system:

-   [PHP](https://www.php.net/) (7.4 or higher)
-   [Composer](https://getcomposer.org/)

## Installation Steps

### Step 1: Clone the Repository

Clone the Laravel repository using Git:

```bash
git clone https://github.com/laravel/laravel.git your_project_name
```

### Step 2: Navigate to the Project Directory

Once you have cloned the Laravel repository, navigate to the project directory using the following command:

```bash
cd your_project_name
```

### Step 3: Install Dependencies

Use Composer to install the project dependencies:

```bash
composer install
```

### Step 4: Create a Copy of the .env File

```bash
cp .env.example .env
```

### Step 5: Generate Application Key

Generate the application key:

```bash
php artisan key:generate
```

### Step 6: Configure Database

Update the .env file with your database connection details. Set the DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD variables.

### Step 7: Run Migration

Run the database migrations:

```bash
php artisan migrate
```

### Step 7: Start the Development Server

```bash
php artisan serve
```

Visit http://localhost:8000 in your web browser, and you should see the Laravel welcome page.

## Conclusion

Congratulations! You have successfully installed Laravel. For more information and in-depth documentation, please refer to the [Laravel Documentation](https://laravel.com/docs).

Happy coding!
