$(document).ready(function () {

    var d = new Date();
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        droppable: false,
        eventDrop: function (event, delta, revertFunc) {
            $.ajax({
                url: '/event/drop/' + event.id + '/' + event.start.format(),
                type: "POST"
            });
        },
        eventClick: function (event) {
            $('#delete').show();
            $.ajax({
                url: '/event/' + event.id,
                type: "GET",
                success: function (data) {

                    $('#delete').attr('href', $('#delete').attr('href').replace($('#delete').attr('href').split('/')[5], data[0].id));
                    $('#eventdetails').attr('action', $('#eventdetails').attr('action').replace($('#eventdetails').attr('action').split('/')[3], $('#eventdetails').attr('action').split('/')[3] + '/' + data[0].id));

                    $('#title').val(data[0].title);

                    $('textarea[name="description"]').val(data[0].description);
                    $('option:selected', 'select[name="legend"]').removeAttr('selected');
                    var legend_id = data[0].legend_id;
                    $('select[name="legend"]').find('option[value="' + legend_id + '"]').attr("selected", true);
                    $('#legend').removeClass().addClass($('select[name="legend"]').find('option[value="' + legend_id + '"]').attr('class'));

                    var startDate = moment(data[0].start_date, 'YYYY-MM-DD HH:mm:ss').format($('#formatDateMoment').val());
                    $('#startDate').datepicker("setDate", startDate);

                    var endDate = moment(data[0].end_date, 'YYYY-MM-DD HH:mm:ss').format($('#formatDateMoment').val());
                    $('#endDate').datepicker("setDate", endDate);

                    if (data[0].all_day == 1) {
                        $('#allDay').iCheck('toggle');
                        $('#timepickerStart, #timepickerEnd').prop('disabled', true);
                    } else {
                        var startTime = moment(data[0].start_date, 'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss');
                        var endTime = moment(data[0].end_date, 'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss');

                        $('#timepickerStart').timepicker('setTime', startTime);
                        $('#timepickerEnd').timepicker('setTime', endTime);
                    }

                    $('#to').tagsinput('removeAll');
                    $.each(data[0].events_user, function (key, value) {
                        if (value.user != null) {
                            $('#to').tagsinput('add', {'id': parseInt(value.user.id), 'display_name': value.user.display_name});
                        }
                    });

                    $('#dates').datepair();

                    $('#modal .modal-title').html(data[0].title);
                    $("#modal").modal({backdrop: 'static', keyboard: false});
                }
            });
        },
        selectable: true,
        select: function (start, end, allDay) {
            var defaultstart = moment(start, $('#formatDateMoment').val()).format($('#formatDateMoment').val());
            $('#dates .date').datepicker("setDate", defaultstart);

            var defaultTime = new Date();
            $('#dates .time').timepicker('setTime', defaultTime);

            $('#title').val('');
            $('textarea[name="description"]').val('');
            $('option:selected', 'select[name="legend"]').removeAttr('selected');
            $('select[name="legend"]').find('option[value="1"]').attr("selected", true);
            $('#legend').removeClass().addClass($('select[name="legend"]').find('option[value="1"]').attr('class'));
            $('#timepickerStart, #timepickerEnd').prop('disabled', false);
            $('#to').tagsinput('removeAll');
            if($('div.checkbox.icheck div').attr('aria-checked') == 'true'){
                $('#allDay').iCheck('toggle');
            }

            $('#dates').datepair();

            $('#modal .modal-title').html("");
            $("#modal").modal({backdrop: 'static', keyboard: false});
        },
        events: '/events'
    });

    $('#dates .time').timepicker({
        timeFormat: 'H:i',
        forceRoundTime: true
    });

    $('#dates .date').datepicker({
        format: $('#formatDatepicker').val(),
        language: $('#locale').val(),
        autoclose: true
    });

    $('#allDay').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $('#legend').attr('class', $('#legend option:selected').attr('class'));

    $('#legend').change(function () {
        $(this).attr('class', $('#legend option:selected').attr('class'));
    });

    $('.iCheck-helper, .checkbox.icheck label').click(function () {
        if ($('div.checkbox.icheck div').attr('aria-checked') == 'true') {
            $('#timepickerStart, #timepickerEnd').prop('disabled', true);
        }
        else {
            $('#timepickerStart, #timepickerEnd').prop('disabled', false);
        }
    });

    $('#startDate, #endDate, #timepickerStart, #timepickerEnd, #title').click(function () {
        $(this).parent().parent().removeClass('has-error');
    })

    $('#delete').hide();

    $("#modal").on('hidden.bs.modal', function () {
        $('#delete').hide();
        $('#delete').attr('href', $('#delete').attr('href').replace($('#delete').attr('href').split('/')[5], 0));
        $('#eventdetails').attr('action', $('#eventdetails').attr('action').replace('/' + $('#eventdetails').attr('action').split('/')[4], ''));
    });

    $('#eventdetails').on('submit', function (e) {
        return doSubmit();
    });

    function doSubmit() {
        var success = true;

        if ($('div.checkbox.icheck div').attr('aria-checked') == 'false') {
            if ($('#timepickerStart').val().length < 1 || $('#timepickerEnd').val().length < 1) {
                $('#timepickerStart, #timepickerEnd').parent().parent().addClass('has-error');
                success = false;
            }
        }

        if ($('#startDate').val().length < 1 || $('#endDate').val().length < 1) {
            $('#startDate, #endDate').parent().parent().addClass('has-error');
            success = false;
        }

        if ($('#title').val().length < 1) {
            $('#title').parent().parent().addClass('has-error');
            success = false;
        }

        if (success) {
            $("#modal").modal('hide');
        }
        return success;
    }

    $('input').keypress(function (e) {
        var key = (document.all) ? e.keyCode : e.which;
        return (key !== 13);
    });
});

var users = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('display_name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {url: 'users'}
});

$('#to').tagsinput({
    itemValue: 'id',
    itemText: 'display_name',
    typeaheadjs: {
        name: 'users',
        displayKey: 'display_name',
        source: users.ttAdapter()
    }
});