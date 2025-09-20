<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- @vite('resources/js/app.js') --}}
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @inertiaHead
  </head>
  <body>
    @inertia
    <script src="{{ mix('/js/app.js') }}"></script>
  </body>
</html>