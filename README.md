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