<script src="{{ asset('assets/plugins/jQuery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>$.widget.bridge('uibutton', $.ui.button);</script>

<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('assets/adminlte/plugins/morris/morris.min.js') }}"></script>

<script src="{{ asset('assets/adminlte/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

<script src="{{ asset('assets/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

<script src="{{ asset('assets/adminlte/plugins/knob/jquery.knob.js') }}"></script>

<script src="{{ asset('assets/plugins/moment/moment-with-locales.min.js') }}"></script>

<script src="{{ asset('assets/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
@if(App::getLocale() == 'es')
<script src="{{ asset('assets/adminlte/plugins/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
@endif
<script src="{{ asset('assets/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

<script src="{{ asset('assets/adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/adminlte/plugins/fastclick/fastclick.js') }}"></script>

<script src="{{ asset('assets/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/adminlte/plugins/chartjs/Chart.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('assets/adminlte/dist/js/app.min.js') }}"></script>

<!-- Notifications -->
<script src="{{ asset('assets/dist/js/notifications.js') }}"></script>

<!-- main -->
<script src="{{ asset('assets/dist/js/main.js') }}"></script>