$('#outer-checkbox').click(function() {
    var value = ($('#form_isAnonymous').val() === '1') ? '0' : '1';

    $('#inner-checkbox').stop().fadeTo('fast', value);
    $("#form_mission, #form_url, #form_urlName, #form_phoneNumber, #form_profileImage, #form_story, #form_email").parent().stop().css('display', value === '1' ?  'none' : 'block');
    $('#form_isAnonymous').val(value);
});

$('#outer-checkbox').click();
$('#outer-checkbox').click();

