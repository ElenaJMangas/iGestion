$(document).ready(function () {

    $('.reply').keypress(function (e) {
        if (e.which == 13) {
            $(this).parent().submit();
            return false;
        }
    });
});
