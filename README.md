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

- [Installation](#%EF%B8%8F-installation)
    - [Requirement](#requirement)
    - [Installation Instruction](#installation-instruction)
- [Usage](#-usage)
    - [Useful Commands](#useful-commands)
    - [Global Helper Functions](#global-helper-functions)
- [Configuration](#-configuration)
    - [User Management](#user-management)
    - [Role & Permission](#role--permission)
    - [Application Configuration](#application-configuration)
- [Create Module](#-create-module)
    - [New CRUD Module](#new-crud-module)
    - [New Static Module](#new-static-module)
- [CRUD Controller Configuration](#-crud-controller-configuration)
- [Form Component](#-form-component)
    - [input (time,date,email,number)](#input-timedateemailnumber)
    - [checkbox](#checkbox)
    - [image](#image)
    - [radio](#radio)
    - [select](#select)
    - [wysiwyg](#wysiwyg)
    - [password](#password)
    - [textarea](#textarea)
- [Question](#-question)
</div>

<br>

## ⬇️ Installation


### Requirement
- Web Server
    - Nginx
    - Apache
- Database that laravel supports, actually can be :
    - MySQL
    - Postgres
    - SQLite
    - SQL Server
- Composer
- Laravel ^8.0
- PHP ^8.0
### Installation Instruction
1. Please make sure you have install laravel project, please follow https://laravel.com/docs
2. Open the terminal, navigate to your laravel project directory and 
    ```php
    composer require laililmahfud/adminportal
3. Setting the database configuration, open .env file at project root directory
4. Run the following command at the terminal
    ```php
    php artisan adminportal:install
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
|#|Function|Usage|
|---|---|---|
|1|`portalconfig`|Function to get adminportal config|
|2|`admin`|Return current users session data|
|3|`itcan`|The function of checking user role permissions|

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
- `admin_path` : This will be used to register the route prefix to access the backend page
- `app_icon` : Path of icon asset, this will be used for the login page logo as well as the backend sidebar
- `app_favicon` : This is application favicon path
- `default_avatar` : This will be used to be the default avatar profile of the application
- `login` : Configuration for login view
    - `view_path` : Base resource path login view
    - `banner` : Image banner for login view
    - `banner_title` : Banner title for login view
    - `banner_description` : Banner description for login view
    - `limiter` : Limiter middleware to limit excess login function access
    - `url` : Default url for login page, change if you want custom view and implement your own route
    - `forgot_password_url` : Default url for forgot password page, you must implement your own function to use it, set null to remove Forgot Password link in login page
    - `register_url` : Default url register page, you must implement your own function to use it, set null to remove Register link in login page
- `theme_color` : Application primary color for sidebar and some button
- `auth` : For auth session management
    -  `session_name_prefix` : To set session auth backend prefix
    - `logout_url` : Default logout url for backend, change if you want custom and implement your own function
- `profile_url` : Default url for admin profile page, change if you want custom and implement your own function
- `notification` : For display dropdown notification on header
    - `display` : Set false to hide dropdown notification on header
    - `interval` : Interval request get notification list, set null to disable interval request
    - `path` : Default url see all notification
    - `ajax_path` : Ajax url interval request get notification list
- `alert_message_type` : For display alert after action, available popup or alert
- `api` : For API Configuration
    - `secret_key` : API Secret key
    - `jwt_secret_key` : JWT secret key for generate JWT token,
    - `expired_duration_get_token` : 
    - `validate_blacklist` : Set tru if you want blacklist token after logout api

<br>

## 📺 Create Module

### New CRUD Module
1. First create your migrate table or use existing table. Your table must have an id column and a uuid column
2. Go to **Module Management** menu then go navigate to **GENERATE NEW MODULE** button
    ### Step 1 - Configuration
    - **Table**  ➡️ The table that you will use for the module to be created. 
    - **Module Name**  ➡️ The name of the Module / Menu to be generated
    - **Module Path** ➡️  Url of the module, by default admin prefix will be added (based on settings)
    - **Controller Name** ➡️ The name of the controller to be created, the controller will be stored in the `app > Http > Controllers > Admin` folder
    - **Module Icon** ➡️ Icon of the menu to be used in the sidebar. We use iconsax in the whole application. You can see more detailed list of icons [here](https://github.com/muhammadlailil/iconsax)
    - **Configuration**
        - **Bulk Action?** ➡️  You can tick to display activate the bulk-action function in the list table
        - **Create?** ➡️ You can tick to display Add button in table view
        - **Edit?** ➡️  You can tick to display Edit button in list of data table
        - **Filter?** ➡️  You can tick to display Filter button in table view
        - **Import?** ➡️  You can tick to display Import button in table view
        - **Export?** ➡️ You can tick to display Export button in table view
    
    <br>

    ### Step 2 - Table View
    - **Label** ➡️ Label of row table
    - **Name** ➡️ The field name according to the current table
    - **Join (Optional)** ➡️ Join relation table

    <br>

    ### Step 3 - Form View
    - **Label** ➡️ Label of form field
    - **Name** ➡️ Name of form field
    - **Type** ➡️ Type of form field
    - **Rule** ➡️ Rules validation for store and update function
    - **Create Rule** ➡️ Rules validation for store function only
    - **Update Rule** ➡️ Rules validation for update function only

### New Static Module
Just go to **Module Management** menu, and on the right side of the card you will find the **Create Static Menu** form to create a new static module

## ⚓️ CRUD Controller Configuration
Available configuration for controller
- `protected $routePath` ➡️ Route base name for the controller module | String
- `protected $pageTitle` ➡️ Module title on the screen page | String
- `protected $resourcePath` ➡️ Base resource path for the module | String
- `protected $moduleService` ➡️ Service class for handling crud function | Class
- `protected $importExcel` ➡️ Import class for handling import excel function (using laravel excel) | Class
- `protected $tableColumns` ➡️ List of main table view column | array 
- `protected $rules` ➡️ Rules validation for store and update function | array
- `protected $createRules` ➡️ Rules validation for store function only | array
- `protected $updateRules` ➡️ Rules validation for update function only | array
- `protected $add` ➡️ Indicates if the user can add record, this will display add button | boolean
- `protected $filter` ➡️ Indicates if the user can filter record, this will display filter button | boolean
- `protected $import` ➡️ Indicates if the user can import record, this will display import button | boolean
- `protected $export` ➡️ Indicates if the user can export record, this will display export button | boolean
- `protected $bulkAction` ➡️ Indicates if the user can do bulk action of the record, this will display checkbox in the table | boolean
- `protected $tableAction` ➡️ Indicates if the table has action function, this will show action column table | boolean
- `protected $perPage` ➡️ The paginate per page item list | integer
- `protected $data ` ➡️ The variable for assign data to view | array
- `protected $message ` ➡️ Custom message actions | array
    - store ➡️ Custom alert message for store success function
    - failed_store ➡️ Custom alert message for failed store function
    - update ➡️ Custom alert message for update success function
    - failed_update ➡️ Custom alert message for failed update function
    - delete ➡️ Custom alert message for delete success function
    - failed_delete ➡️ Custom alert message for failed delete function
    - bulk_delete ➡️ Custom alert message for bulk delete success function

<br>

## ✨ Form Component
- ### input (text,time,date,email,number)
    ```html
    <x-portal::input type="text" name="name_of_input_request" label="Label" placeholder="Placeholder" horizontal></x-portal::input>
    ```
- ### checkbox
    ```html
    <x-portal::input.checkbox name="name_of_input_request" label="Label" horizontal>
        <x-portal::input.checkbox.option class="me-5" checked name="name_of_input_request" label="Sample option" value="1"></x-portal::input.checkbox.option>
    </x-portal::input.checkbox>
    ```
- ### image
    ```html
        <x-portal::input.image name="name_of_input_request" label="Label" placeholder="Placeholder" horizontal></x-portal::input.image>
    ```
- ### radio
    ```html
    <x-portal::input.radio.group name="name_of_input_request" label="Label" horizontal>
        <x-portal::input.radio.group.option checked class="me-4" name="name_of_input_request" label="Option" value="Option"></x-portal::input.radio.group.option>
    </x-portal::input.radio.group>
    ```
- ### select
    ```html
    <x-portal::input.select name="name_of_input_request" label="Label" placeholder="Placeholder" horizontal>
        <option value="">Label</option>
    </x-portal::input.select>
    <x-portal::input.select.asset />
    ```
- ### wysiwyg
    ```html
    <x-portal::input.wysiwyg name="name_of_input_request" label="Label" placeholder="Placeholder" horizontal></x-portal::input.wysiwyg>
    ```
- ### password
    ```html
    <x-portal::input.password name="name_of_input_request" label="Label" placeholder="Placeholder" horizontal></x-portal::input.password>
    ```
- ### textarea
    ```html
    <x-portal::input.textarea name="name_of_input_request" label="Label" placeholder="Placeholder" horizontal></x-portal::input.textarea>
    ```
<br>

## 🙋‍♂️ Question
If you have any question just submit in github issue [here](https://github.com/muhammadlailil/adminportal/issues)