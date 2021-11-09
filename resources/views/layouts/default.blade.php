<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CRM Siregar</title>
    <meta name="description" content="CRM Siregar">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- style --}}
    @stack('before-style')
    @include('includes.style')
    @stack('after-style')

</head>

<body>
    {{-- sidebar --}}
    @include('includes.sidebar')

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        {{-- navbar --}}
        @include('includes.navbar')
        
        <!-- Content -->
        @yield('content')
        <!-- /.content -->
        <div class="clearfix"></div>
    </div>
    <!-- /#right-panel -->

    <!-- Scripts -->
    @stack('before-script')
    @include('includes.script')
    @stack('after-script')
</body>
</html>
