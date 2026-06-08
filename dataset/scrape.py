from selenium import webdriver
from selenium.webdriver.common.by import By
import pandas as pd
import time
import os

driver = webdriver.Chrome()

url = "https://www.lapor.go.id/instansi/pemerintah-kota-bandung/done"

driver.get(url)

print("Silakan login dulu...")

input("Kalau sudah login, pencet ENTER di terminal...")

for i in range(20):
    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    time.sleep(2)

# ambil semua link
links = driver.find_elements(By.TAG_NAME, "a")

laporan_links = []

for link in links:
    href = link.get_attribute("href")

    if href and "/laporan/detil/" in href:
        laporan_links.append(href)

# hapus duplicate link di halaman
laporan_links = list(set(laporan_links))

print("Jumlah link ditemukan:", len(laporan_links))



existing_links = set()

if os.path.exists("dataset/laporan_bdg_done.csv"):

    old_df = pd.read_csv("dataset/laporan_bdg_done.csv")

    if "link" in old_df.columns:
        existing_links = set(old_df["link"].tolist())

print("Jumlah link lama:", len(existing_links))



data = []

count = 0

for laporan in laporan_links:

    # skip kalau sudah ada
    if laporan in existing_links:
        print("Skip duplicate:", laporan)
        continue

    # batasi ambil data baru
    if count >= 80:
        break

    print("Membuka:", laporan)

    driver.get(laporan)

    time.sleep(3)

    try:
        judul = driver.find_element(By.CLASS_NAME, "complaint-title").text
    except:
        judul = ""

    try:
        isi = driver.find_element(By.CLASS_NAME, "complaint-excerpt").text
    except:
        isi = ""

    try:
        info = driver.find_element(By.CLASS_NAME, "complaint-info").text
    except:
        info = ""

    data.append({
        "judul": judul,
        "isi_laporan": isi,
        "info": info,
        "link": laporan
    })

    count += 1

    print(f"{count} data berhasil diambil")


new_df = pd.DataFrame(data)

# kalau file lama ada gabungkan
if os.path.exists("dataset/laporan_bdg_done.csv"):

    final_df = pd.concat([old_df, new_df])

    # hapus duplicate berdasarkan link
    final_df = final_df.drop_duplicates(subset=["link"])

else:
    final_df = new_df

final_df.to_csv("dataset/laporan_bdg_done.csv", index=False)

print("CSV berhasil dibuat!")

driver.quit()