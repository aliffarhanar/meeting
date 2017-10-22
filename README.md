# Meeting Room App by Nobackend

## STEP 1 : Inisialisasi dan konfigurasi awal
1. Import PHP SDK Nobackend ke direktori project anda
2. Pada file 'config' anda tambahkan script berikut untuk membuat objek client dari nobackend
```php
include_once 'autoloader.inc.php';	
usergrid_autoload('Apache\\Usergrid\\Client');
$client = new Apache\Usergrid\Client('https://api.nobackend.id','nobackend.meeting','meeting');
```
3. Setiap kali melakukan call api, anda dapat menggunakan object "$client" sebagai user call. [Dokumentasi selengkapnya] (https://nobackend.id/docs/)

## STEP 2 : Register User
1. Untuk register, POST data json ke endpoint `users` dengan body 
```json
{
  "name": "[nama user]",
  "username": "[username]",
  "password": "[password]",
  "email": "[email]",
  "activated": false,
  "activation_code": [generated activation code],
  "approved": "pending",
  "role": "[roles yang dipilih]",
  "tel": "[nomor telepon]"
}
```
2. Data body diatas adalah default properties untuk users di nobackend, anda dapat menambahkan data lainnya

## STEP 3 : Login User
1. Untuk login, POST data json ke endpoint 'https://api.nobackend.id/orgName/appName/token' dengan body dibawah untuk meendapatkan oauth token
```json
{
  "grant_type":"password",
  "username": "[username]",
  "password": "[password]"
}
```
2. Jika anda menggunakan SDK, maka cukup gunakan perintah dibawah untuk mendapatkan oauth token
```php
$client-]login([username], [password])
```

## GET STARTED / BEST PRACTICE
1. Untuk dokumentasi lengkap mengenai fitur yang tersedia anda bisa kunjungi link dibawah :
```
	https://nobackend.id/docs/#introduction/create-account
```

2. Untuk dokumentasi lengkap mengenai SDK dalam berbagai bahasa anda bisa kunjungi link dibawah :
```
	https://github.com/apache/usergrid/tree/master/sdks
```
