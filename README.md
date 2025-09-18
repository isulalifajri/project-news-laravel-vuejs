## About Project

Membuat project sistem informasi berita dengan menggunakan laravel 12(filament) untuk cms dan Vue JS 3 untuk Frontend, untuk cms terintegrasi langsung spatie permission

install laravel:
``
composer create-project laravel/laravel namethisfolder
``

install filament:

``
composer require filament/filament:"^3.3" -W
php artisan filament:install --panels
``

untuk akses nya nanti seperti ini: locahost:port/admin

install spatie:

``
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
``

Create Backend User:

``
php artisan make:model BackendUser -m
``

Isi Sesuai standar model dan migration nya.

Kemudian di config/auth.php tambahkan ini:

``
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'backend' => [                         // <--- guard untuk backend
        'driver' => 'session',
        'provider' => 'backend_users',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    'backend_users' => [                   // <--- provider backend
        'driver' => 'eloquent',
        'model' => App\Models\BackendUser::class,
    ],
],

``

Konfigurasi Spatie Permission -> config/permission.php

``
'guards' => ['web', 'backend'],
``

create seeder:
``
php artisan make:seeder BackendUserSeeder
``

``
php artisan db:seed --class=BackendUserSeeder

``

buat seeder permission: 
``
php artisan make:seeder PermissionSeeder
php artisan db:seed --class=PermissionSeeder

``

buat seeder role:
``
php artisan make:seeder RoleSeeder
php artisan db:seed --class=RoleSeeder
``

jika cms auth menggunakan tabel berbeda, misal backenduser
maka tambahkan ini di adminpanelprovider.php

``
 ->authGuard('backend')    
 ``

 ## Memastikan code sesuai standar php dengan install sniffer

 jalankan ini:
 ``
 composer require --dev squizlabs/php_codesniffer
``

kemudian jalankna ini juga di terminal untuk standar nya:

``
vendor/bin/phpcs --config-set default_standard PSR12

``

kemudian pada composer.json tambahkan code ini:

``
"scripts": {
    "lint": "vendor/bin/phpcs --ignore=vendor/*,storage/*,database/migrations/* --extensions=php app/ routes/ database/",
    "lint:fix": "vendor/bin/phpcbf --ignore=vendor/*,storage/* ,database/migrations/* --extensions=php app/ routes/ database/"
}
``

```
lint → cek kode tanpa mengubah apa-apa.

lint:fix → otomatis perbaiki kode sesuai standar PSR-12.

--ignore=vendor/*,storage/* → skip folder vendor dan storage supaya lebih cepat.

--extensions=php → cuma cek file .php.

app/ routes/ database/ → cuma cek folder penting, bukan seluruh project.

```

nah nanti jika ingin cek code style sesuai standar atau tidak tinggal jalankan perintah ini:

``
composer lint → ngecek coding style.
composer lint:fix → memperbaiki otomatis sesuai standar PSR-12.
``