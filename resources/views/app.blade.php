<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test</title>
    <link rel="stylesheet" href="{{ mix('/css/apps.css') }}">
</head>
<body>

<div class="container m-5">
  
  @yield('content')

</div>


<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
