<div align="center">
    <h2>AdminPortal for Laravel - A Simple CRUD Generator </h2>
    <p>Automatically generate simple CRUD modules.</p>
</div>
<br/>

## Installation

> Note: PHP 8 and Laravel 9.19 or higher are the minimum dependencies.

```sh
$ composer require laililmahfud/adminportal
```
> Run the artisan command to install adminportal and all of its packages
```bash
php artisan adminportal:install
```

## Configuration

Before you can generate your documentation, you'll need to configure a few things in your `config/apdoc.php`.

-   `admin_path`
    This will be used to register the necessary routes prefix for the package.

-   `app_icon`
    This will be use for the application icon for all admin screen.

-   `app_favicon`
    This will be use for the application favicon.

-   `default_avatar`
    Your aplication default avatar image


-   `login`
    Configuration for login view
    - `view_path` Base resource path of login view
    - `banner` Image banner for login if you use default view
    - `banner_title` Banner title for login if you use default view
    - `banner_description` Banner description for login if you use default view

```php
    'login' => [
        'view_path' => 'portalmodule::auth.login',
        'banner' => 'adminportal/img/login-banner.svg',
        'banner_title' => 'Welcome Back !',
        'banner_description' => "Use your access in the ".config('app.name')." application and login to your dashboard account."
    ],
```

-   `theme_color`
    For the sidebar admin color

-   `auth.session_name_prefix`
    For auth session management prefix

-   `nofitication`
    For display dropdown notification on header

-   `api`
    For API Configuration
    - `secret_key` Secret key for you application API
    - `jwt_secret_key` Your jwt secret key

```php
    'api' => [
        'secret_key' => env('API_SECRET_KEY'),
        'jwt_secret_key' => env('JWT_SECRET_KEY')
    ]
```  
## Controller Configuration

This package uses the HTTP controller doc blocks to create a table of contents and show descriptions for your API methods.

Using `@group` in a controller doc block creates a Group within the API documentation. All routes handled by that controller will be grouped under this group in the sidebar. The short description after the `@group` should be unique to allow anchor tags to navigate to this section. A longer description can be included below. Custom formatting and `<aside>` tags are also supported. (see the [Documentarian docs](http://marcelpociot.de/documentarian/installation/markdown_syntax))

> Note: using `@group` is optional. Ungrouped routes will be placed in a "general" group.

Above each method within the controller you wish to include in your API documentation you should have a doc block. This should include a unique short description as the first entry. An optional second entry can be added with further information. Both descriptions will appear in the API documentation in a different format as shown below.
You can also specify an `@group` on a single method to override the group defined at the controller level.

```php
class UserController extends Controller
{

	/**
     * The route base name for the controller module.
     *
     * @var string
     */
    protected $routePath;

    /**
     * The module name of the controller
     *
     * @var string
     */
    protected $pageTitle;

    /**
     * The base resource path for the module
     *
     * @var string
     */
    protected $resourcePath;

    /**
     * The service class for handling crud function
     *
     * @var YourServiceClass
     */
    protected $crudService;

    /**
     * The import class for handling import excel function
     * More detail about import excel function read this documentation [link]
     *
     * @var YourImportExcelClass|null
     */
    protected $importExcel;

    /**
     * The list of main table view column
     * Example :
     * [["label" => "Name","name"=>"user.name"]]
     *
     * @var array
     */
    protected $tableColumns;

    /**
     * The rule of validation for store and update rules
     *
     * @var array
     */
    protected $rules = [];

    /**
     * The rule of validation for store rule
     *
     * @var array|null
     */
    protected $createRules = [];

    /**
     * The rule of validation for update rule, if the value is null, validation process will use the storeRule
     *
     * @var array|null
     */
    protected $updateRules = [];

    /**
     * Indicates if the user can add record, this will display add button
     *
     * @var bool
     */
    protected $canAdd = true;

    /**
     * Indicates if the user can filter record, this will display filter button
     *
     * @var bool
     */
    protected $canFilter = false;

    /**
     * Indicates if the user can import record, this will display import button
     *
     * @var bool
     */
    protected $canImport = false;

    /**
     * Indicates if the user can export record, this will display export button
     *
     * @var bool
     */
    protected $canExport = false;

    /**
     * Indicates if the user can do bulk action of the record, this will display checkbox in the table
     *
     * @var bool
     */
    protected $bulkAction = true;

    /**
     * Indicates if the table has action function, this will show action in header table
     *
     * @var bool
     */
    protected $tableAction = true;

    /**
     * The paginate per page list
     */
    protected $perPage = 10;

    /**
     * The variable for assign data to view
     * @return array
     */
    protected $data = [];
    /**
     * The function to new class of crud service
     */
}
```

## License

MIT
