import csv
import mysql.connector

# Koneksi ke database
conn = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',  # Ganti jika kamu pakai password
    database='db_nutrition_app'
)
cursor = conn.cursor()

# Buka file CSV
with open('data-nutrition/data-nutrition-id.csv', newline='', encoding='utf-8') as csvfile:
    reader = csv.DictReader(csvfile)
    for row in reader:
        id_val = int(row['id'])
        name = row['name']
        calories = float(row['calories']) if row['calories'] else 0
        protein = float(row['proteins']) if row['proteins'] else 0
        fat = float(row['fat']) if row['fat'] else 0
        carbs = float(row['carbohydrate']) if row['carbohydrate'] else 0
        image = row['image']

        cursor.execute("""
            INSERT INTO nutrition_library (id, name, calories, protein, fat, carbs, image)
            VALUES (%s, %s, %s, %s, %s, %s, %s)
            ON DUPLICATE KEY UPDATE
                name=VALUES(name),
                calories=VALUES(calories),
                protein=VALUES(protein),
                fat=VALUES(fat),
                carbs=VALUES(carbs),
                image=VALUES(image)
        """, (id_val, name, calories, protein, fat, carbs, image))

conn.commit()
cursor.close()
conn.close()

print("Import selesai.")
print("Data berhasil diimpor ke database MySQL.")
print("Pastikan untuk memeriksa tabel 'nutrition_library' di database 'db_nutrition_app' untuk memastikan data telah diimpor dengan benar.")