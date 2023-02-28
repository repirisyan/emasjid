## Aplikasi E-Masjid
Aplikasi yang digunakan untuk mengelola masjid, terdiri dari modul : 
- Informasi
    - Berita
    - Kajian Online
    - Galeri Kegiatan
- Manajemen Keuangan 
    - Pemasukkan
    - Pengeluaran
    - Saldo 
- Manajemen User 
    - Pengurus
    - Jamaah 
    - Ustadz
- Manajemen Qurban
    - Pendaftaran
    - Produksi
        - Antrian Hewan Qurban
        - Penyembelihan
        - Timbangan Daging Qurban
    - Distribusi
        - Warga
        - Shohibul Qurban

### System Requirement
- PHP 8.2
- composer
- Mysql 8

### Tools
- API 
- - [quran api](https://equran.id/api)

### Important Thing To Do
1. Folder yang harus dibuat di storage
- berita
- event
- favicons
    - add favicon.png
- galeri
- kajian_online
- logo
    - add mosque.png
- profile
- struktur_organisasi
    - add struktur_organisasi.png
2. .env variable
- APP_WHATSAPP (contact)
- APP_YOUTUBE_VID (video url)
- APP_YT_CHANNEL (channel url)
- APP_GMAPS_COOR (gmaps coordinate)
