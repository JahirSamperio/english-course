# English Learning System - Modular Architecture

## 🚀 Quick Start

### Prerequisites
- **XAMPP/WAMP/LAMP** - Apache + MySQL + PHP
- **PHP 7.4+** - Required for modern features
- **MySQL 5.7+** - Database server

### Installation

1. **Clone/Download** the project to your web server directory:
   ```
   c:\xampp\htdocs\englishdemo\
   ```

2. **Import Database**:
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create database: `english_learning_system`
   - Import: `database.sql`

3. **Configure Database** (if needed):
   ```php
   // config/Database.php
   $host = 'localhost';
   $dbname = 'english_learning_system';
   $username = 'root';
   $password = 'root';
   ```

4. **Access System**:
   - URL: http://localhost/englishdemo/
   - Login with demo accounts (see ACCESOS.txt)

### Demo Accounts
- **Student**: john.student@email.com / password123
- **Teacher**: jennifer.teacher@email.com / password123
- **Parent**: sarah.parent@email.com / password123

## 📁 Project Structure

```
englishdemo/
├── assets/                 # Static resources
│   ├── css/               # Stylesheets (kids + enhanced)
│   ├── js/                # JavaScript files
│   ├── img/               # Images
│   └── audio/             # Audio files (correct, incorrect, motivation)
├── config/                # Configuration files
│   └── Database.php       # Database singleton connection
├── controllers/           # Business logic controllers
│   ├── AuthController.php # Authentication & login
│   ├── StudentController.php # Student functionality
│   ├── TeacherController.php # Teacher functionality
│   └── guardar_resultados.php # Save exercise results
├── models/                # Data models (decoupled)
│   ├── Tema.php          # Topic management
│   ├── Ejercicio.php     # Exercise management
│   ├── Estudiante.php    # Student management
│   └── Audio.php         # Audio management
├── views/                 # Presentation layer
│   ├── auth/             # Authentication views
│   │   └── login.php     # Login form
│   ├── student/          # Student views
│   │   ├── dashboard.php # Student dashboard
│   │   ├── ejercicios_interactivos.php # Interactive exercises
│   │   └── contenido_asignado.php # Assigned content
│   ├── teacher/          # Teacher views
│   │   ├── dashboard_docente.php # Teacher dashboard
│   │   └── panel_profesor.php # Teacher control panel
│   └── shared/           # Shared components
├── index.php             # Main MVC router
├── database.sql          # Database schema + sample data
├── ACCESOS.txt           # Demo login credentials
└── README.md             # This documentation
```

## 🎯 Key Features

### Modular Design
- **Separation of Concerns**: Controllers, Models, Views are separated
- **Decoupled Components**: Each content type (Tema, Ejercicio, Audio) is independent
- **Easy Expansion**: Add new content types by creating new models/controllers

### Content Management
- **Dynamic Content**: Content shown based on student's assigned plan
- **Level-based Filtering**: Exercises and topics filtered by student level
- **Progress Tracking**: Individual student progress monitoring

### Scalability
- **MVC Architecture**: Clean separation for easy maintenance
- **Database Abstraction**: Singleton pattern for database connections
- **Reusable Components**: Shared views and utilities

## 🚀 Adding New Content Types

### 1. Create Model
```php
// models/NewContent.php
class NewContent {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        // Implementation
    }
}
```

### 2. Update Controller
```php
// controllers/ContentController.php
public function manageNewContent() {
    $model = new NewContent();
    $data = $model->getAll();
    $this->loadView('content/new_content', ['data' => $data]);
}
```

### 3. Create View
```php
// views/content/new_content.php
// HTML template for new content type
```

## 📊 Database Integration

All models use the Database singleton for consistent connections:
- **Singleton Pattern**: One connection instance
- **Automatic Management**: Connection handling
- **Error Handling**: PDO exceptions
- **Security**: Prepared statements

## 🎨 Frontend Features

### Visual Elements
- **Kid-Friendly Design**: Colorful, animated interface
- **SVG Mascot**: Interactive educational character
- **Animations**: CSS transitions and effects
- **Responsive**: Tablet and mobile optimized

### Interactive Elements
- **Sound Effects**: Audio feedback for actions
- **Confetti Effects**: Celebration animations
- **Progress Bars**: Visual progress tracking
- **Gamification**: Points, streaks, achievements

## 🔧 System Architecture

### MVC Pattern
- **Models**: Data access layer (Tema, Ejercicio, Estudiante, Audio)
- **Views**: Presentation layer (auth, student, teacher)
- **Controllers**: Business logic (Auth, Student, Teacher)
- **Router**: Central routing in index.php

### Key Features
- **Content Filtering**: Shows only assigned content to students
- **Level Management**: Exercises filtered by student level
- **Progress Tracking**: Real-time progress updates
- **Plan Assignment**: Teachers assign study plans to students

## 🚀 Usage

### For Students
1. Login with student credentials
2. View assigned content and progress
3. Practice with interactive exercises
4. Earn points and maintain streaks

### For Teachers
1. Login with teacher credentials
2. Create and assign study plans
3. Manage topics and exercises
4. Monitor student progress

### For Parents
1. Login with parent credentials
2. View child's progress
3. Monitor learning activities

## 📈 Extensibility

The system supports easy expansion:
- **New Content Types**: Add models + controllers + views
- **New User Roles**: Extend existing controllers
- **New Features**: Modular architecture prevents conflicts
- **Scaling**: Database singleton + MVC supports growth

## 🔍 Troubleshooting

### Common Issues
- **Database Connection**: Check config/Database.php settings
- **File Permissions**: Ensure web server can read files
- **Audio Issues**: Check browser audio permissions
- **CSS/JS Not Loading**: Verify asset paths are correct

### Support
- Check ACCESOS.txt for demo credentials
- Verify database.sql was imported correctly
- Ensure PHP 7.4+ and MySQL 5.7+ are installed