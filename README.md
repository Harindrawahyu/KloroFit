This is my first mobile app project called KloroFit, KloroFit is about tracking your nutrtition and your workout progress, including run or walking. It will make your diet perfectly all tracked. 
Project Progress --> Creating REST API  
=======

<!-- checkbox test rest api -->
## 🔥 API Endpoint Summary

| Method | Endpoint | Deskripsi |
|:-------|:---------|:----------|
| POST | /api/auth/register | Register user baru | --> http://localhost/KloroFit/nutrition-php-api/api/auth/register.php
| POST, GET | /api/auth/login | Login user | --> http://localhost/KloroFit/nutrition-php-api/api/auth/login.php
| GET | /api/exercises_tracking/activty | Tambah makanan | --> http://localhost/KloroFit/nutrition-php-api/api/exercises_tracking/activity.php
| POST | /api/food_tracking/add_food_tracking/<id> | List makanan user |
| DELETE | /api/food_tracking/delete_food_tracking/<id> | Menghapus makanan user |
| GET | /api/food_tracking/get_food_tracking/<id> | Mendapatkan makanan user |
| PUT | /api/food_tracking/update_food_tracking/<id> | Mengubah makanan user |
| GET | /api/libs/foods/ | Menampilkan data makanan |
| GET | /api/libs/search_library/ | Mencari data makanan |
| GET | /api/user/daily_stats_view/ | Menampilkan statistik harian user  |
|  GET | /api/user/exercises_view/ | Menampilkan aktivitas user |
| GET | /api/user/user_profile_view/ | Menampilkan profile user |

---
