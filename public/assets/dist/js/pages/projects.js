$(document).ready(function () {

    $('.recipients').each(function () {
        var to = $(this).val().split(',');
        $('#to').tagsinput('add', {'id': parseInt(to[0]), 'display_name': to[1]});
    });
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