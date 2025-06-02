KloroFit - Nutrition & Workout Tracker 🚀
=======
KloroFit is my first mobile application project designed to help you track your nutrition and workout progress, including running and walking. This app ensures that all aspects of your diet and fitness are perfectly recorded. 

📌 Project Status

🚧 Currently in the development phase of the REST API.

<!-- checkbox test rest api -->
## 🔥 API Endpoint Summary

| Method | Endpoint | Deskripsi |
|:-------|:---------|:----------|
| POST | /api/auth/register | Register user baru |
| POST, GET | /api/auth/login | Login user |
| GET | /api/exercises-tracking/activty | Tambah makanan | exercises-tracking/activity.php
| POST | /api/food-trakcing/add_food-trakcing/<id> | List makanan user |
| DELETE | /api/food-trakcing/delete_food-trakcing/<id> | Menghapus makanan user |
| GET | /api/food-trakcing/get_food-trakcing/<id> | Mendapatkan makanan user |
| PUT | /api/food-trakcing/update_food-trakcing/<id> | Mengubah makanan user |
| GET | /api/libs/foods/ | Menampilkan data makanan |
| GET | /api/libs/search_library/ | Mencari data makanan |
| GET | /api/user/daily_stats_view/ | Menampilkan statistik harian user  |
|  GET | /api/user/exercises_view/ | Menampilkan aktivitas user |
| GET | /api/user/user_profile_view/ | Menampilkan profile user |

---

Basic Architecture
NUTRITION-PHP-API/
├── public/
│   └── index.php                        # Application entry point
│
├── src/
│   ├── Presentation/                    # Presentation Layer
│   │   ├── Controller/                  # Handle HTTP requests
│   │   │   ├── AuthController.php       # Authentication controller
│   │   │   ├── UserController.php       # User profile management
│   │   │   ├── FoodController.php       # Food tracking endpoints
│   │   │   └── ActivityController.php   # Exercise tracking endpoints
│   │   │
│   │   └── View/                        # View components
│   │       ├── ProfileView.php          # User profile views
│   │       └── DailyStatsView.php       # Daily nutrition statistics
│   │
│   ├── Application/                     # Application Layer
│   │   ├── Service/                     # Application services
│   │   │   ├── AuthService.php          # Authentication service
│   │   │   ├── UserService.php          # User management service
│   │   │   ├── FoodTrackingService.php  # Food tracking service
│   │   │   └── ExerciseService.php      # Exercise tracking service
│   │   │
│   │   └── DTO/                         # Data Transfer Objects
│   │       ├── UserDTO.php              # User data transfer object
│   │       ├── FoodDTO.php              # Food data transfer object
│   │       └── ActivityDTO.php          # Activity data transfer object
│   │
│   ├── Domain/                          # Domain Layer
│   │   ├── Model/                       # Domain models
│   │   │   ├── User.php                 # User entity
│   │   │   ├── Food.php                 # Food entity
│   │   │   ├── Nutrition.php            # Nutrition entity
│   │   │   └── Activity.php             # Activity entity
│   │   │
│   │   └── Service/                     # Domain services
│   │       ├── NutritionCalculator.php  # Calculate nutrition values
│   │       └── CalorieCalculator.php    # Calculate calories
│   │
│   └── Infrastructure/                  # Infrastructure Layer
│       ├── Repository/                  # Data repositories
│       │   ├── UserRepository.php       # User data access
│       │   ├── FoodRepository.php       # Food data access
│       │   └── ActivityRepository.php   # Activity data access
│       │
│       ├── Database/                    # Database connections
│       │   └── DatabaseConnection.php   # Database connection manager
│       │
│       └── Import/                      # Data import
│           └── CsvImporter.php          # Import data from CSV files
│
├── config/                              # Configuration files
│   ├── app.php                          # Application configuration
│   └── database.php                     # Database configuration
│
├── data/                                # Data files
│   ├── data-nutrition-id.csv            # Nutrition data CSV
│   └── nutrition_library.sql            # SQL for nutrition database
│
├── vendor/                              # Composer dependencies
├── composer.json                        # Composer configuration
├── .gitignore                           # Git ignore file
└── README.md                            # Project documentation


Layered Architecture
NUTRITION-PHP-API/
├── public/                     # Public entry points
│   └── index.php               # Main entry point
├── src/                        # Source code
│   ├── Domain/                 # Business logic & entities
│   │   ├── Model/              # Domain models/entities
│   │   │   ├── User.php
│   │   │   ├── Food.php
│   │   │   ├── Nutrition.php
│   │   │   └── Activity.php
│   │   └── Service/            # Domain services
│   │       ├── NutritionService.php
│   │       └── ActivityService.php
│   ├── Application/            # Application services/use cases
│   │   ├── Service/            # Application services
│   │   │   ├── UserService.php
│   │   │   ├── FoodTrackingService.php
│   │   │   └── ExerciseTrackingService.php
│   │   └── DTO/                # Data Transfer Objects
│   │       ├── UserDTO.php
│   │       └── NutritionDTO.php
│   ├── Infrastructure/         # External systems & persistence
│   │   ├── Repository/         # Data access
│   │   │   ├── UserRepository.php
│   │   │   ├── FoodRepository.php
│   │   │   └── ActivityRepository.php
│   │   ├── Database/           # Database connection
│   │   │   └── DatabaseConnection.php
│   │   └── Import/             # Data import functionality
│   │       └── CsvImporter.php
│   └── Presentation/           # Controllers & UI components
│       ├── Controller/         # API controllers
│       │   ├── AuthController.php
│       │   ├── UserController.php
│       │   ├── FoodController.php
│       │   └── ActivityController.php
│       └── View/               # View components (if any)
│           ├── ProfileView.php
│           └── DailyStatsView.php
├── config/                     # Configuration files
│   └── database.php
├── tests/                      # Test files
├── vendor/                     # Composer dependencies
├── data/                       # Data files
│   ├── data-nutrition-id.csv
│   └── nutrition_library.sql
├── .gitignore
└── README.md


For Mobile App Architecture
NUTRITION-PHP-API/
├── public/
│   └── index.php                        # API entry point handler
│
├── src/
│   ├── Api/                             # API Layer
│   │   ├── Controller/                  # API Controllers
│   │   │   ├── AuthController.php       # Authentication endpoints (login, register, logout)
│   │   │   ├── UserController.php       # User profile management endpoints
│   │   │   ├── FoodController.php       # Food tracking endpoints
│   │   │   └── ActivityController.php   # Exercise tracking endpoints
│   │   │
│   │   ├── Middleware/                  # API Middleware
│   │   │   ├── AuthMiddleware.php       # Authentication verification
│   │   │   ├── CorsMiddleware.php       # Handle CORS for Android app
│   │   │   └── JsonResponseMiddleware.php # Ensure JSON responses
│   │   │
│   │   └── Response/                    # API Response formatters
│   │       ├── JsonResponse.php         # Standard JSON response structure
│   │       └── ErrorResponse.php        # Error response handling
│   │
│   ├── Application/                     # Application Layer
│   │   ├── Service/                     # Application services
│   │   │   ├── AuthService.php          # Authentication service
│   │   │   ├── UserService.php          # User management service
│   │   │   ├── FoodTrackingService.php  # Food tracking service
│   │   │   └── ExerciseService.php      # Exercise tracking service
│   │   │
│   │   ├── DTO/                         # Data Transfer Objects
│   │   │   ├── UserDTO.php              # User data transfer object
│   │   │   ├── FoodDTO.php              # Food data transfer object
│   │   │   └── ActivityDTO.php          # Activity data transfer object
│   │   │
│   │   └── Validation/                  # Input validation
│   │       ├── UserValidator.php        # Validate user input
│   │       ├── FoodValidator.php        # Validate food input
│   │       └── ActivityValidator.php    # Validate activity input
│   │
│   ├── Domain/                          # Domain Layer
│   │   ├── Model/                       # Domain models
│   │   │   ├── User.php                 # User entity
│   │   │   ├── Food.php                 # Food entity
│   │   │   ├── Nutrition.php            # Nutrition entity
│   │   │   └── Activity.php             # Activity entity
│   │   │
│   │   └── Service/                     # Domain services
│   │       ├── NutritionCalculator.php  # Calculate nutrition values
│   │       └── CalorieCalculator.php    # Calculate calories
│   │
│   └── Infrastructure/                  # Infrastructure Layer
│       ├── Repository/                  # Data repositories
│       │   ├── UserRepository.php       # User data access
│       │   ├── FoodRepository.php       # Food data access
│       │   └── ActivityRepository.php   # Activity data access
│       │
│       ├── Database/                    # Database connections
│       │   └── DatabaseConnection.php   # Database connection manager
│       │
│       ├── Authentication/              # Authentication infrastructure
│       │   ├── JwtHandler.php           # JWT token generation and validation
│       │   └── TokenStorage.php         # Token storage and management
│       │
│       └── Import/                      # Data import
│           └── CsvImporter.php          # Import data from CSV files
│
├── config/                              # Configuration files
│   ├── api.php                          # API configuration
│   ├── app.php                          # Application configuration
│   └── database.php                     # Database configuration
│
├── data/                                # Data files
│   ├── data-nutrition-id.csv            # Nutrition data CSV
│   └── nutrition_library.sql            # SQL for nutrition database
│
├── vendor/                              # Composer dependencies
├── composer.json                        # Composer configuration
├── .htaccess                            # Apache URL rewriting (for API routing)
├── api-docs/                            # API documentation
│   └── swagger.json                     # Swagger/OpenAPI specification
├── .gitignore                           # Git ignore file
└── README.md                            # Project documentation