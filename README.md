# Sparktro Laravel Modular

A clean and structured modular system for Laravel applications. This package helps you organize your Laravel app using a module-based architecture, making it more maintainable and scalable.

---

## 🔧 Features

- Easy to create and manage modules
- Automatic loading of routes, views, migrations per module
- PSR-4 autoloading support
- Laravel auto-discovery supported
- Ideal for large and enterprise Laravel apps

---

## 🚀 Installation

```bash
composer require mhannan-dev/sparktro-laravel-modular
```

If you're using a Laravel version with package auto-discovery, you're good to go.

---

## 🗂️ Folder Structure

Each module follows a structure like:

```
/modules
    /Blog
        /Http
            /Controllers
        /Views
        /Routes
            web.php
        /Database
            /Migrations
```

---

## 🧾 Artisan Commands

You can use the following commands to generate module components easily:

| Command | Description |
|--------|-------------|
| `php artisan module:make ModuleName` | Create a new module |
| `php artisan module:migrate ModuleName` | Run migrations for a specific module |
| `php artisan module:make-request ModuleName RequestName` | Create a form request in the module |
| `php artisan module:make-controller ModuleName ControllerName` | Create a controller inside the module |
| `php artisan module:make-model ModuleName ModelName -m` | Create a model (and migration) inside the module |
| `php artisan module:make-migration ModuleName MigrationName` | Create a new migration in the module |

> Example:
> ```bash
> php artisan module:make SparkTro
> php artisan module:make-controller SparkTro PageController
> php artisan module:migrate SparkTro
> ```

---

## 📂 Autoloading

The package uses PSR-4 autoloading. Make sure your module namespaces are correct.

---

## 🧪 Testing

> Coming soon: Automated tests and example module.

---

## 📝 License

This package is open-source software licensed under the [MIT license](LICENSE).

---

## 👨‍💻 Author

**Muhammad Hannan**  
[GitHub Profile](https://github.com/mhannan-dev)  
[Linkedin Profile](https://www.linkedin.com/in/mhannan44)  
Email: [mdhannan.info@gmail.com](mailto:mdhannan.info@gmail.com)

---

## 🤝 Contributing

Pull requests and contributions are welcome. For major changes, please open an issue first to discuss what you would like to change.

---
