<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="/css/app.css">
    <title>@yield('title', 'Sample App') - Laravel 入门教程</title>
  </head>
  <body>
    @include('layouts._header')

    <div class="container">
      <div class="col-md-offset-1 col-md-10">
        @yield('content')
        @include('layouts._footer')
      </div>
    </div>
  </body>
</html>