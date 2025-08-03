Here’s an **updated and polished version** of your `README.md` for the **Sparktro Laravel Modular** package, ensuring better clarity, structure, and professionalism:

---

# 🚀 Sparktro Laravel Modular

A clean and scalable **modular system** for Laravel applications. This package provides a simple yet powerful way to structure your Laravel app using **module-based architecture**, making it easier to maintain and extend — ideal for large or enterprise-level applications.

---

## ✨ Features

* 🧱 Modular code organization
* ⚙️ Automatic loading of routes, views, migrations per module
* 📦 PSR-4 autoloading and Laravel auto-discovery supported
* 🧩 Artisan commands to scaffold modules and components
* 🔐 Supports loading custom middleware like `auth`, etc.
* 🏗️ Ideal for large, multi-team, enterprise Laravel apps

---

## 📦 Installation

```bash
composer require mhannan-dev/sparktro-laravel-modular
```

> ✅ Laravel’s package auto-discovery will take care of registration.

---

## ⚙️ Middleware Setup

If your modules need to use `auth` or other middlewares, make sure to load them in each module's `Providers` class within the `boot()` method.

```php
public function boot()
{
    $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
    $this->loadViewsFrom(__DIR__ . '/../Views', 'ModuleAlias');
    $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

   \Illuminate\Support\Facades\Route::middleware(['web', 'auth'])
            ->group(__DIR__ . '/../Routes/web.php');
}
```

---

## 🧪 Artisan Commands

The package includes several custom Artisan commands for quick scaffolding:

| Command                                                        | Description                               |
| -------------------------------------------------------------- | ----------------------------------------- |
| `php artisan module:make ModuleName`                           | Create a new module                       |
| `php artisan module:migrate ModuleName`                        | Run migrations for a specific module      |
| `php artisan module:make-controller ModuleName ControllerName` | Create a controller inside the module     |
| `php artisan module:make-model ModuleName ModelName -m`        | Create a model and optional migration     |
| `php artisan module:make-request ModuleName RequestName`       | Create a form request in the module       |
| `php artisan module:make-migration ModuleName MigrationName`   | Create a new migration file in the module |

> Example usage:
>
> ```bash
> php artisan module:make Blog
> php artisan module:make-controller Blog PostController
> php artisan module:migrate Blog
> ```

---

## 📂 PSR-4 Autoloading

Each module follows **PSR-4 autoloading** standards. No need for manual inclusion—just ensure your namespaces match directory structures.

---

## 🧪 Testing

Automated tests and example module usage will be added in upcoming releases.

---

## 📝 License

This package is open-sourced under the [MIT license](LICENSE).

---

## 👨‍💻 Author

**Muhammad Hannan**
[GitHub](https://github.com/mhannan-dev) | [LinkedIn](https://www.linkedin.com/in/mhannan44)
📧 [mdhannan.info@gmail.com](mailto:mdhannan.info@gmail.com)

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!
Please open a discussion or issue first for major changes.

---

Would you like a sample demo module created to include in the repo? I can help generate that too.
