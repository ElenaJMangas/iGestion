$(function () {
    //Add text editor
    $('#compose-textarea').wysihtml5({
        events: {
            focus: function () {
                $('div.bootstrap-tagsinput, .wysihtml5-sandbox').removeClass('has-error');
            }
        }
    });

    var users = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('display_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {url: '/users/'}
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

    if($('#message_id').val() !== ""){
        $('#to').tagsinput('add', {'id': parseInt($('#user_id').val()), 'display_name': $('#display_name').val()});
    }

    $('#draft, #send').on('click',function () {
        var action = $(this).attr('id');
        $('form').attr('action',$(this).data('action'));

        console.log($('form').attr('action'))
        var success = true;

        if(action == 'send' && $('#to').val() == '' ){
            success = false;
            $('div.bootstrap-tagsinput').addClass('has-error');
        }

        if($('#compose-textarea').val() == '' ){
            success = false;
            $('.wysihtml5-sandbox').addClass('has-error');
        }

        if(success === true){
            $('form').submit();
            return true;
        }
    });

    $('form div.box-body').on('click',function () {
        $('div.bootstrap-tagsinput, .wysihtml5-sandbox').removeClass('has-error');
    });

});
