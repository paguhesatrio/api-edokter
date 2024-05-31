## Made By Laravel 8
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Database 
Membuat database baru di SIK dengan nama tabel users
dan mengubah nik dengan penyortiran latin1_swedish_ci dan merelasikan nik pada users dengan pegawai serta personal_acces_token dan dengan migarte sudah bisa

## Postman
- tambahObat
```json
{
    "no_rawat": "2024/05/14/000001",
    "kode_brng": ["B000000560","B000000003","B000000790"],
    "jml": ["3", "5", "1"],
    "aturan_pakai": ["3x1", "3x2", "3x3"],
    "jmlh_obat": 3
}
 ```

- tambahObatRacikan
```json
{
    "no_rawat": "2024/05/14/000001",
    "jmlh_obat_racikan": [1, 2],
    "nama_racik": ["paguh", "esa"],
    "kd_racik": ["R01", "R02"],
    "jml_dr": ["5", "10"],
    "aturan_pakai": ["3X1", "1X1"],
    "keterangan": ["Pusing pusimg", "Api nya belum masuk"],
    "kode_brng": [
        ["B000000305"], 
        ["B000000305", "B000000556"]
    ],
    "p1": [
        ["1"], 
        ["1", "1"]
    ],
    "p2": [
        ["1"], 
        ["1", "1"]
    ],
    "kandungan": [
        ["500"], 
        ["50", "10"]
    ],
    "jml": [
        ["1"], 
        ["3", "4"]
    ]
}
 ```
