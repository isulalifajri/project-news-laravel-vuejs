## About Project

Membuat project sistem informasi berita dengan menggunakan laravel 12(filament) untuk cms dan Vue JS 3 untuk Frontend, untuk cms terintegrasi langsung spatie permission

install laravel:
```
composer create-project laravel/laravel namethisfolder
```

install filament:

```
composer require filament/filament:"^3.3" -W
php artisan filament:install --panels
```

untuk akses nya nanti seperti ini: locahost:port/admin

install spatie:

```
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

Create Backend User:

```
php artisan make:model BackendUser -m
```

Isi Sesuai standar model dan migration nya.

Kemudian di config/auth.php tambahkan ini:

```
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

```

Konfigurasi Spatie Permission -> config/permission.php

``
'guards' => ['web', 'backend'],
``

create seeder:
```
php artisan make:seeder BackendUserSeeder
```

```
php artisan db:seed --class=BackendUserSeeder

```

buat seeder permission: 
```
php artisan make:seeder PermissionSeeder
php artisan db:seed --class=PermissionSeeder

```

buat seeder role:
```
php artisan make:seeder RoleSeeder
php artisan db:seed --class=RoleSeeder
```

jika cms auth menggunakan tabel berbeda, misal backenduser
maka tambahkan ini di adminpanelprovider.php

``
 ->authGuard('backend')    
 ``

 perintah untuk membut filament dengan crud nya

 ```
 php artisan make:filament-resource Category --generate

 ```

 tambahin view detail

 ```
 php artisan make:filament-page ViewPost --resource=PostResource --type=ViewRecord

 ```

 di resource nambahin ini juga:
 ``
 'view' => Pages\ViewPost::route('/{record}'),
 ``

 ## Memastikan code sesuai standar php dengan install sniffer

jalankan ini:

```
 composer require --dev squizlabs/php_codesniffer
```

kemudian jalankan ini juga di terminal untuk standar nya:

```
vendor/bin/phpcs --config-set default_standard PSR12

```

kemudian pada composer.json tambahkan code ini:

```
"scripts": {
    "lint": "vendor/bin/phpcs --ignore=vendor/*,storage/*,database/migrations/* --extensions=php app/ routes/ database/",
    "lint:fix": "vendor/bin/phpcbf --ignore=vendor/*,storage/* ,database/migrations/* --extensions=php app/ routes/ database/"
}
```

```
lint → cek kode tanpa mengubah apa-apa.

lint:fix → otomatis perbaiki kode sesuai standar PSR-12.

--ignore=vendor/*,storage/* → skip folder vendor dan storage supaya lebih cepat.

--extensions=php → cuma cek file .php.

app/ routes/ database/ → cuma cek folder penting, bukan seluruh project.

```

nah nanti jika ingin cek code style sesuai standar atau tidak tinggal jalankan perintah ini:

```
composer lint → ngecek coding style.
composer lint:fix → memperbaiki otomatis sesuai standar PSR-12.
```

## Install vue js dengan inertia

dokumentasi lengkap konjungi link ini: `https://inertiajs.com/server-side-setup`

```
composer require inertiajs/inertia-laravel
```
``
php artisan inertia:middleware
``

Client Side

docs: `https://inertiajs.com/client-side-setup`

```
npm install @inertiajs/vue3
```

setelah selesai, buat folder dan file di directory ini: resources/js/pages/Home.vue

kemudian di route web nya tambahkan ini:

```
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

```

install plugin vite: `https://vite.dev/plugins/`

```
npm i @vitejs/plugin-vue
```

pad file `vite.config.js` tambahkan ini:

```
import vue from '@vitejs/plugin-vue'
vue(), -> didalam plugins

```

Jika ingin menggunakan laravel mix jalankan perintah ini:

```
npm install laravel-mix --save-dev

```

buat file ini di root project: `webpack.mix.js`

kemudian isi seperti ini:

```
const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue()
   .postCss('resources/css/app.css', 'public/css', [
       //
   ]);
```

Ubah `resources/views/app.blade.php` jadi pakai Mix helper:

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Berita App</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @inertiaHead
</head>
<body>
    @inertia
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>

```

Build:

```
npm install
npm run dev

```

## Install Tailwindcss
docs: `https://tailwindcss.com/docs/installation/using-vite`
```
npm install tailwindcss @tailwindcss/vite
```

kemudian di vite.config.js tambahkan ini:
```
import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
})
```

diblade layout: `@vite(['resources/css/app.css', 'resources/js/app.js'])` 

install fontawesome: `npm install @fortawesome/fontawesome-free`

kemudian di app.js tambahkan ini: `import '@fortawesome/fontawesome-free/css/all.min.css'`


Install swiper in page Home

```
npm install swiper

```

kemudian di page home tambahkan ini di dalam script setup:

```
import AppLayout from '@/Layouts/AppLayout.vue'
import { Swiper, SwiperSlide } from 'swiper/vue'

import { Navigation, Pagination, Autoplay } from 'swiper/modules'

// Import CSS
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import 'swiper/css/autoplay'
```

Menggunakan router di vue js

install: 
```
composer require tightenco/ziggy
```

di `app.js`:

```
import { ZiggyVue } from 'ziggy-js'
import { Ziggy } from './ziggy.js'

di dalam createIntertiaApp tambahkan ini: .use(ZiggyVue, Ziggy)
```

geneate ziggi.js dg perintah ini:

```
php artisan ziggy:generate resources/js/ziggy.js //setiap kali edit and create route jalankan ini
```

install juga versi npm nya: 
```
npm install ziggy-js

```

## Login menggunakan OAuth di laravel

```
Cara Dapatkan Client ID & Secret Google OAuth

Masuk ke Google Cloud Console
👉 https://console.cloud.google.com/

Bikin Project Baru

Klik Select a Project → New Project

Kasih nama project, misalnya: News Website OAuth

Klik Create

Aktifkan Google OAuth

Masuk ke menu APIs & Services → OAuth consent screen

Pilih External → klik Create

Isi detail aplikasi (nama app, email support, dll.)

Simpan

Buat Credentials (Client ID & Secret)

Pergi ke APIs & Services → Credentials

Klik + Create Credentials → pilih OAuth Client ID

Pilih Web Application

Isi nama, misalnya: News App OAuth

Tambahkan Authorized redirect URI → contoh:

http://127.0.0.1:8000/auth/google/callback


Klik Create

Dapatkan Client ID & Secret

Setelah create, Google bakal kasih:

Client ID

Client Secret

Copy → taruh ke .env Laravel:

GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT=http://127.0.0.1:8282/auth/google/callback
```

jalankan ini di terminal project: 

```
composer require laravel/socialite
```

Edit file `config/services.php`:

```
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT'),
],
```

tambahkan routes ke web.php:

```
use App\Http\Controllers\Auth\GoogleController;

Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'callback']);

```

Buat controller `app/Http/Controllers/Auth/GoogleController.php`:

```
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Cek apakah user sudah ada
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Kalau belum ada, buat user baru
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt(str()->random(16)), // password random biar ga kepake
            ]);
        }

        // Login user
        Auth::login($user);

        return redirect('/'); // arahkan ke home atau dashboard
    }
}

```

di tabel user tambahkan ini:

```
$table->string('google_id')->nullable()->unique();
$table->string('avatar')->nullable();
```

di blade/vue kita tinggal kasih ini:

```
<a href="{{ route('google.login') }}" 
   class="px-4 py-2 bg-red-500 text-white rounded-lg shadow">
   Login with Google
</a>

```