# 📚 PGFK-Edu-System

Welcome to **PGFK-Edu-System** — an automated system for managing the educational process at the Natural-Humanitarian Professional College of Uzhhorod National University! 🚀 This project is designed to simplify the work of students, teachers, and administrators by providing convenient access to data and automating key processes. 🎓

## ✨ What is this project?

This is a web application that enables:
- **Students** 👩‍🎓 to view their grades, schedules, groups, and personal information.
- **Teachers** 👨‍🏫 to manage disciplines, groups, students, and keep records.
- **Administrators** 🧑‍💼 to oversee all data: specialties, groups, users, and more.
- Offers a **user-friendly interface**, responsive design, and secure authentication. 🔒

The project was developed as part of an industrial-technological internship using modern technologies. 🌟

## 🛠️ Technologies

- **Backend**: PHP 8.3, Laravel 12.x 🐘
- **Frontend**: Blade, HTML, CSS 🎨
- **Database**: PostgreSQL (hosted on Microsoft Azure) ☁️
- **Admin Panel**: Filament for efficient data management ⚙️
- **Authentication**: Laravel Breeze 🔐
- **IDE**: PhpStorm

## 🔑 Authentication Flow

1. User registers with email and password
2. System automatically determines role based on email domain
3. Verification email is sent
4. User verifies email address
5. Access granted to role-specific dashboard
## 📂 Project Structure
```
pgfk-edu-system/
├── app/                              # Core application logic
│   ├── Enums/                       # Enum definitions for constants
│   ├── Filament/                    # Filament admin panel components
│   │   ├── Home/                    # Custom Filament pages
│   │   │   ├── Pages/               # Dashboard and custom pages
│   │   │   ├── Resources/           # Resources for managing entities
│   │   │   │   ├── StudentResource/ # Student management (CRUD)
│   │   │   │   │   ├── Pages/       # Pages for create/edit/view
│   │   │   │   │   ├── Widgets/     # Widgets for stats and data
│   │   │   │   └── ...              # Other resources (Teachers, Groups, etc.)
│   ├── Http/                        # HTTP layer
│   │   ├── Controllers/             # Controllers for handling requests
│   ├── Models/                      # Eloquent models for database interaction
│   ├── Policies/                    # Authorization policies for access control
│   ├── Providers/                   # Service providers (e.g., Filament, Auth)
├── config/                          # Configuration files
│   ├── auth.php                    # Authentication settings
│   ├── database.php                # Database configuration
│   ├── filament.php                # Filament panel settings
│   └── ...                         # Other configs
├── database/                        # Database-related files
│   ├── factories/                  # Factories for generating test data
│   ├── migrations/                 # Database schema migrations
│   ├── seeders/                    # Seeders for populating test data
├── public/                          # Publicly accessible files
│   ├── css/                        # Compiled CSS
│   ├── js/                         # Compiled JavaScript
│   ├── index.php                   # Entry point for the application
├── resources/                       # Frontend resources
│   ├── css/                        # Source CSS files
│   ├── js/                         # Source JavaScript files
│   ├── views/                      # Blade templates
│   │   ├── livewire/               # Livewire components
│   │   │   ├── pages/              # Auth and profile pages
│   │   │   └── ...                 # Other view components
├── routes/                          # Route definitions
│   ├── web.php                     # Web routes
│   ├── auth.php                    # Authentication routes
├── lang/                            # Localization files
│   ├── uk/                         # Ukrainian translations
├── .env.example                     # Environment configuration template
├── composer.json                    # PHP dependencies
├── package.json                     # Node.js dependencies
├── artisan                          # Laravel CLI tool
└── README.md                        # Project documentation
```
This structure follows Laravel conventions, ensuring a clean and scalable codebase. 🚀

## 🤝 Contributing

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request
