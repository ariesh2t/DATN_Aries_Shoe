$(document).ready(function() {
    // show pass
    $('#eye-pass').click(function() {
        $('#eye-pass .fa-regular').toggleClass('d-none')
        if ($('#eye-pass .fa-eye').hasClass('d-none')) {
            $('#password').attr('type', 'text')
        } else {
            $('#password').attr('type', 'password')
        }
    })

    $('#eye-pass-cf').click(function() {
        $('#eye-pass-cf .fa-regular').toggleClass('d-none')
        if ($('#eye-pass-cf .fa-eye').hasClass('d-none')) {
            $('#password-confirm').attr('type', 'text')
        } else {
            $('#password-confirm').attr('type', 'password')
        }
    })
})
