$(document).ready(function () {

    setInterval(refreshNotifications, 10000); //Se llamará cada 5 segundos y se refrescarán los datos de dicha tabla que se cargan mediante la función LOAD de JQuery.


    function refreshNotifications() {
        $('#totalNotifications').load('/notifications/count', function (data) {
            $('#totalNotifications').html(data)
        });
    }

    $('#getNotifications').on('click', function () {
        if ($('#getNotifications').attr('aria-expanded') == 'false') {
            $('#menuNotifications').load('/notifications/list', function (data) {
                $('#menuNotifications').html(data);

                    $("#menuNotifications .menu").slimscroll({
                        height: "200px",
                        alwaysVisible: false,
                        size: "3px"
                    }).css("width", "100%");

            });
        }
    });

});

