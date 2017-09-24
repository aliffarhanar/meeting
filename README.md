# Meeting room by Nobackend

## STEP 1 : Inisialisasi dan konfigurasi awal
1. Import PHP SDK Nobackend ke direktori project anda
2. Pada file 'config' anda tambahkan script berikut untuk membuat objek client dari nobackend
```php
include_once 'autoloader.inc.php';	
	usergrid_autoload('Apache\\Usergrid\\Client');
	$client = new Apache\Usergrid\Client('https://api.nobackend.id','nobackend.meeting','meeting');
```
