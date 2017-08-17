<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon.png">
    <title>eShop | @yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <!--<link href="/css/bootstrap.min.css" rel="stylesheet">-->
    <!--<link href="/css/bootstrap-extension.css" rel="stylesheet">-->
    <!-- Menu CSS -->
    <!--<link href="/css/sidebar-nav.min.css" rel="stylesheet">-->
    <!-- animation CSS -->
    <link href="/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <!--<link href="/css/style.css" rel="stylesheet">-->
    <!-- color CSS -->
    <!--<link href="/css/colors/megna.css" id="theme" rel="stylesheet">-->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}"> @yield('customStylesheets')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="app">
        @include('admin.header') 
        @include('admin.sidebar')

        <div class="container">
            @yield('content')
        </div>

        @include('admin.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>
    @yield('customScripts')
</body>

</html>