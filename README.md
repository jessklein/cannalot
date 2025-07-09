# Cannalot Dashboard

A modern, responsive dashboard/database platform built with PHP using MVC architecture.

## Features

- **Modern UI**: Clean, responsive design using Tailwind CSS
- **MVC Architecture**: Well-organized Model-View-Controller pattern
- **Database Management**: Full CRUD operations with pagination
- **User Management**: Complete user lifecycle management
- **Dashboard Analytics**: Interactive charts and statistics
- **Responsive Design**: Mobile-friendly interface
- **Security**: Input validation, password hashing, and secure sessions

## Architecture Overview

```
cannalot/
├── app/
│   ├── config/          # Configuration files
│   │   ├── app.php      # Application settings
│   │   └── database.php # Database configuration
│   ├── controllers/     # Controllers (Handle requests)
│   │   ├── BaseController.php
│   │   ├── DashboardController.php
│   │   └── UsersController.php
│   ├── models/          # Models (Data layer)
│   │   ├── BaseModel.php
│   │   └── User.php
│   ├── views/           # Views (Presentation layer)
│   │   ├── layouts/
│   │   ├── dashboard/
│   │   └── users/
│   ├── middleware/      # Middleware (Authentication, etc.)
│   ├── helpers/         # Utility functions
│   ├── database/        # Database files
│   │   └── schema.sql   # Database schema
│   └── Core.php         # Core framework classes
└── public/              # Web root
    ├── assets/          # CSS, JS, images
    ├── uploads/         # File uploads
    └── index.php        # Entry point
```

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url> cannalot
   cd cannalot
   ```

2. **Configure Environment**
   ```bash
   cp app/.env.example app/.env
   ```
   Edit `app/.env` with your database credentials.

3. **Create Database**
   ```sql
   mysql -u root -p < app/database/schema.sql
   ```

4. **Configure Web Server**
   Point your web server document root to `app/public/`

5. **Set Permissions**
   ```bash
   chmod 755 app/public/uploads/
   ```

## Database Schema

The platform includes the following main tables:

- **users**: User accounts and profiles
- **products**: Product catalog
- **categories**: Product categorization
- **orders**: Customer orders
- **order_items**: Order line items
- **sessions**: User session management
- **settings**: Application configuration

## Usage

### Dashboard
- Access the main dashboard at `/dashboard`
- View key metrics and analytics
- Interactive charts for sales and user growth

### User Management
- List all users at `/users`
- Create new users at `/users/create`
- Edit user details at `/users/{id}/edit`
- View user profile at `/users/{id}`

### Extending the Platform

#### Adding New Controllers

1. Create a new controller in `app/controllers/`
```php
<?php
namespace App\Controllers;

class ProductsController extends BaseController 
{
    public function index()
    {
        $this->view('products/index');
    }
}
```

2. Add routes in `app/public/index.php`
```php
$router->get('products', 'Products@index');
```

#### Adding New Models

1. Create a new model in `app/models/`
```php
<?php
namespace App\Models;

class Product extends BaseModel 
{
    protected $table = 'products';
    protected $fillable = ['name', 'price', 'description'];
}
```

#### Adding New Views

1. Create view files in `app/views/`
2. Use the layout system:
```php
<?php $view = __FILE__; require __DIR__ . '/../layouts/app.php'; ?>

<h1>Your Content Here</h1>
```

## Configuration

### Application Settings (`app/config/app.php`)

- `app_name`: Application name
- `app_url`: Base URL
- `debug`: Debug mode (disable in production)
- `default_controller`: Default controller
- `items_per_page`: Pagination size

### Database Settings (`app/config/database.php`)

- Connection settings
- Charset and collation
- PDO options

## Security Features

- **Password Hashing**: Using PHP's `password_hash()`
- **Input Validation**: Server-side validation
- **Prepared Statements**: SQL injection protection
- **Session Management**: Secure session handling
- **CSRF Protection**: (Implement tokens as needed)

## Performance Optimization

- **Database Indexing**: Proper indexes on frequently queried columns
- **Pagination**: Limit data loading with pagination
- **Caching**: Implement caching for frequently accessed data
- **Asset Optimization**: Minify CSS/JS for production

## Development Guidelines

### Code Style
- Follow PSR-4 autoloading standards
- Use meaningful variable and function names
- Comment complex logic
- Separate concerns (MVC pattern)

### Database Design
- Use foreign keys for referential integrity
- Include created_at/updated_at timestamps
- Use appropriate data types
- Index frequently queried columns

### Security Best Practices
- Validate all user inputs
- Use prepared statements
- Implement proper authentication
- Sanitize output data
- Use HTTPS in production

## Deployment

### Production Checklist

1. **Environment Configuration**
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Use strong `APP_KEY`

2. **Database**
   - Backup existing data
   - Run migrations
   - Optimize tables

3. **Security**
   - Enable HTTPS
   - Set secure session settings
   - Configure file permissions

4. **Performance**
   - Enable opcache
   - Configure server caching
   - Optimize database queries

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support and questions, please create an issue in the repository.