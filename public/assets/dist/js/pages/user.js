$(function () {
    var language;
    if($('#locale').val() == 'es'){
        language = "/assets/plugins/datatables/i18n/Spanish.json";
    }
    // Grid
    $("#users").DataTable({
        responsive: true,
        destroy: true,
        retrieve: true,
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        order: [[0, "asc"]],
        language: {
            url: language
        }
    });

});
