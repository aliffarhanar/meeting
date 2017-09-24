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
