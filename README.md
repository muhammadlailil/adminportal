<div align="center">
    <h2 style="border:none">⚡️ AdminPortal for Laravel - A Simple CRUD Generator ⚡️</h2>
    <p>Automatically generate simple CRUD module</p>

[![Latest Stable Version](https://poser.pugx.org/laililmahfud/adminportal/v/stable)](https://packagist.org/packages/laililmahfud/adminportal)
[![Total Downloads](https://poser.pugx.org/laililmahfud/adminportal/downloads)](https://packagist.org/packages/laililmahfud/adminportal)
[![License](https://poser.pugx.org/laililmahfud/adminportal/license)](https://packagist.org/packages/laililmahfud/adminportal)
[![Required Laravel Version](https://img.shields.io/badge/Laravel-%E2%89%A5%208.0-ff2d20?style=flat-square&logo=laravel)](https://packagist.org/packages/laililmahfud/adminportal)
[![Required PHP Version](https://poser.pugx.org/barryvdh/laravel-debugbar/require/php)](https://packagist.org/packages/laililmahfud/adminportal)

</div>
<br>

## 🔍 About AdminPortal

Adminportal is a simple crud module generator for Laravel by making it easy for developers to customize the appearance of the generated modules.
By providing several built-in features that will make it easier and faster for developers to build applications.

## 📖 Table Of Contents

<div>

-    [Installation](#⬇️-installation)
     -    [Requirement](#requirement)
     -    [Installation Instruction](#installation-instruction)
-    [Usage](#👋-usage)
     -    [Useful Commands](#useful-commands)
     -    [Global Helper Functions](#global-helper-functions)
-    [Configuration](#🎮-configuration)
     -    [User Management](#user-management)
     -    [Role & Permission](#role--permission)
     -    [Application Configuration](#application-configuration)
-    [Create Module](#📺-create-module)
     -    [New CRUD Module](#new-crud-module)
     -    [New Static Module](#new-static-module)
-    [CRUD Controller Configuration](#⚓️-crud-controller-configuration)
-    [Form Component](#✨-form-component)
     -    [input (time,date,email,number)](#input-timedateemailnumber)
     -    [checkbox](#checkbox)
     -    [image](#image)
     -    [radio](#radio)
     -    [select](#select)
     -    [wysiwyg](#wysiwyg)
     -    [password](#password)
     -    [textarea](#textarea)
-    [Question](#🙋‍♂️-question) - [How to add new column in table ?](#how-to-add-new-column-in-table) - [How to add CRUD validation ?](#how-to-add-crud-validation) - [How to custom CRUD message ?](#how-to-custom-crud-message) - [How to pass parameters into view ?](#how-to-pass-parameters-into-view) - [How to add custom html section in table view ?](#how-to-add-custom-html-section-in-table-view) - [How to add button in table view ?](#how-to-add-button-in-table-view) - [Submit Question !](https://github.com/muhammadlailil/adminportal/issues)
</div>

<br>

## ⬇️ Installation

### Requirement

-    Web Server
     -    Nginx
     -    Apache
-    Database that laravel supports, actually can be :
     -    MySQL
     -    Postgres
     -    SQLite
     -    SQL Server
-    Composer
-    Laravel ^8.0
-    PHP ^8.0

### Installation Instruction

1. Please make sure you have install laravel project, please follow https://laravel.com/docs
2. Open the terminal, navigate to your laravel project directory and
     ```php
     composer require laililmahfud/adminportal
     ```
3. Setting the database configuration, open .env file at project root directory
4. Run the following command at the terminal
     ```php
     php artisan adminportal:install
     ```
5. After the installation process is complete, you will be given an account to enter the backend page
     - default email : portal@admin.com
     - default password : P@ssw0rd
     - backend url : /admin
6. Enjoy Your Code 🧑‍💻

<br>

## 👋 Usage

### Useful Commands

You can run 👇
|#|Artisan Command|Usage|
|---|---|---|
|1|`php artisan adminportal:api-key`|Generate api and jwt key|
|2|`php artisan adminportal:migration`|Migrate admin portal table requirement|

### Global Helper Functions

| #   | Function       | Usage                                          |
| --- | -------------- | ---------------------------------------------- |
| 1   | `portalconfig` | Function to get adminportal config             |
| 2   | `admin`        | Return current users session data              |
| 3   | `itcan`        | The function of checking user role permissions |

<br>

## 🎮 Configuration

### User Management

By default the user login table uses the admin cmd table and when you enter the backend with the default user given, there will be a menu <br>
➡️ User Management ➡️ User Admin <br>
In that menu you can add new user data according to your needs.

### Role & Permission

➡️ User Management ➡️ Roles & Permission <br>
By default you will be given the default Super Admin role with the super admin yes flag which can access the entire module.

### Application Configuration

You can see application settings in the config/adminportal.php file
List of application configuration

-    `admin_path` : This will be used to register the route prefix to access the backend page
-    `app_icon` : Path of icon asset, this will be used for the login page logo as well as the backend sidebar
-    `app_favicon` : This is application favicon path
-    `default_avatar` : This will be used to be the default avatar profile of the application
-    `login` : Configuration for login view
     -    `view_path` : Base resource path login view
     -    `banner` : Image banner for login view
     -    `banner_title` : Banner title for login view
     -    `banner_description` : Banner description for login view
     -    `limiter` : Limiter middleware to limit excess login function access
     -    `url` : Default url for login page, change if you want custom view and implement your own route
     -    `forgot_password_url` : Default url for forgot password page, you must implement your own function to use it, set null to remove Forgot Password link in login page
     -    `register_url` : Default url register page, you must implement your own function to use it, set null to remove Register link in login page
-    `theme_color` : Application primary color for sidebar and some button
-    `auth` : For auth session management
     -    `session_name_prefix` : To set session auth backend prefix
     -    `logout_url` : Default logout url for backend, change if you want custom and implement your own function
-    `profile_url` : Default url for admin profile page, change if you want custom and implement your own function
-    `notification` : For display dropdown notification on header
     -    `display` : Set false to hide dropdown notification on header
     -    `interval` : Interval request get notification list, set null to disable interval request
     -    `path` : Default url see all notification
     -    `ajax_path` : Ajax url interval request get notification list
-    `alert_message_type` : For display alert after action, available popup or alert
-    `api` : For API Configuration
     -    `secret_key` : API Secret key
     -    `jwt_secret_key` : JWT secret key for generate JWT token,
     -    `expired_duration_get_token` :
     -    `validate_blacklist` : Set tru if you want blacklist token after logout api

<br>

## 📺 Create Module

### New CRUD Module

🚴 in progres

### New Static Module

🚴 in progres

## ⚓️ CRUD Controller Configuration

🚴 in progres

<br>

## ✨ Form Component

### input (time,date,email,number)

### checkbox

### image

### radio

### select

### wysiwyg

### password

### textarea

<br>

## 🙋‍♂️ Question

### How to add new column in table ?

🚴 in progres

### How to add CRUD validation ?

🚴 in progres

### How to custom CRUD message ?

🚴 in progres

### How to pass parameters into view ?

🚴 in progres

### How to add custom html section in table view ?

🚴 in progres

### How to add button in table view ?

🚴 in progres
