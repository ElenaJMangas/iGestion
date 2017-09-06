<!-- Framework -->
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/ionicons/css/ionicons.min.css') }}">

<!-- Theme Style -->
<link rel="stylesheet" href="{{ asset('assets/adminlte/dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/adminlte/dist/css/skins/skin-blue.min.css') }}">

<!-- Plugins -->
<link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/iCheck/flat/blue.css') }}">
<link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/morris/morris.css') }}">
<link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">

<link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<link rel="stylesheet" href="{{ asset('assets/dist/css/main.css') }}">

@yield('pagecss')
<style type="text/css">
    @yield('css')
</style>

<script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
</script>
