<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        @include('admin.include.css')
    </head>
    <body>
        <input type="checkbox" id="check">
        <!--header area start-->
        @include('admin.include.header')
        <!--header area end-->
        <!--sidebar start-->
        <div class="wrap-content">
        @include('admin.include.menu')
        <!--sidebar end-->
        <div class="content">
            @yield('content')
        </div>
    </div>
        @include('admin.include.js')
    </body>
</html>