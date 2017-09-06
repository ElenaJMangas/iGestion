$(function () {
    var language;
    if ($('#locale').val() == 'es') {
        language = "/assets/plugins/datatables/i18n/Spanish.json";
    }

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
        var clicks = $(this).data('clicks');
        if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            $('.trash, .reply').attr("disabled", true);
        } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            $('.reply').attr("disabled", true);
            $('.trash').attr('disabled', false);
        }
        $(this).data("clicks", !clicks);
    });

    $('ul#folders li, .refresh').on('click', function () {
        $('.loading').addClass('show')
        var folder = $(this).data('folder');

        if (!$(this).hasClass('refresh')) {
            $('ul#folders li').removeClass('active');
            $(this).addClass('active');

            if(folder != 'inbox'){
                $('#reply').hide();
            }else{
                $('#reply').show();
            }
        } else {
            $(this).blur();
        }

        $.ajax({
            url: '/messages/getfolder/' + folder,
            type: "GET",
            success: function (data) {
                $('.refresh').data('folder', folder);

                table.rows().remove();
                $.each(data, function (key, value) {
                    table.row.add(value);
                    table.draw(true)
                });

                table.columns.adjust().draw();

                //Enable iCheck plugin for checkboxes
                $('.mailbox-messages input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_flat-blue'
                });

                $('.iCheck-helper').click(function () {
                    if ($('.mailbox-messages input[type="checkbox"]:checked').length == 1) {
                        $('.reply, .trash').attr("disabled", false);
                    } else {
                        if($('.mailbox-messages input[type="checkbox"]:checked').length > 1){
                            $('.trash').attr("disabled", false);
                        }else{
                            $('.reply, .trash').attr("disabled", true);
                        }
                    }
                });
                $('.loading').removeClass('show')
            }
        });
    });

    $('ul#folders li[data-folder="inbox"]').trigger('click');

    var table = $("#messages").DataTable({
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

function reply() {
    var id = $('.mailbox-messages input[type="checkbox"]:checked').attr('id');
    $('input[name=message_id]').val(id);
    return true;
}

function deleteMessage(){
    var id;
    $('input[type=checkbox]').each(function () {
           if(this.checked){
            id = $(this).attr('id');
            $('form#delete').append('<input type="hidden" name="delete[]" value="'+id+'">');
        }
    });
}