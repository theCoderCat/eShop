<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon.png">
    <title>eShop - @yield('title')</title>
    <!-- animation CSS -->
    <link href="/css/animate.css" rel="stylesheet">
    @yield('customStylesheets')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div id="app">
    @include('store.header')
    @include('store.sidebar')

    <div class="container">
        @yield('content')
    </div>

    @include('store.footer')
</div>

<!-- Scripts -->
@yield('customScripts')
</body>

</html>