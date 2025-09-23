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

``
import { ZiggyVue } from './ziggy'
import { Ziggy } from './ziggy'

di dalam createIntertiaApp tambahkan ini: .use(ZiggyVue, Ziggy)
``

geneate ziggi.js dg perintah ini:

```
php artisan ziggy:generate resources/js/ziggy.js
```

install juga versi npm nya: 
```
npm install ziggy-js

```