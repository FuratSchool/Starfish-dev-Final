$(document).ready(function () {
    var cookie_tos_accepted = Cookies.get('cookie_tos_accepted');
    if (cookie_tos_accepted !== "true") {
        $("div#cookie_popup").slideDown(275, 'swing');
    }
    $('#cookie_accept').click(function () {
        Cookies.set('cookie_tos_accepted', 'true', {expires: 365});
        $('div#cookie_popup').slideUp(275, 'swing');
    });
});

//had some issues with returning from search and this made it work, DONT CHANGE THIS thnx ;3
var list = $('#lis').find('option:selected').val();
$('#q').attr('list', list);

//change datalist when user selects their search direction
$('#list').change(function () {
    if ($('#q').attr('list') === 'complaints') {
        $('#q').attr('list', 'disciplines');
    } else {
        $('#q').attr('list', 'complaints');
    }
    $(document).ready(function () {
        var cookie_tos_accepted = Cookies.get('cookie_tos_accepted')
        if (cookie_tos_accepted != true) {
            $("#cookie_popup").slideDown(1000, 'swing');
            $('#cookie_accept').click(function () {
                if ($('#cookie_tos_accept') == 1) {
                    Cookies.create('cookie_tos_accepted', 'true');
                    $('div#cookie_popup').slideUp(275, 'swing');
                } else {
                    alert('U heeft geen toestemming gegeven voor het gebruik van cookies');
                }
            });
        };

    });

});