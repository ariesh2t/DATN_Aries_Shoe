$(document).ready(function() {
    (function( $ ) {
        $.fn.attachmentUploader = function() {
            const uploadControl = $(this).find('.js-form-upload-control');
            const btnClear = $(this).find('.btn-clear');
            $(uploadControl).on('change', function(e) {
                const preview = $(this).closest('.form-upload').children('.form-upload__preview');
                const files   = e.target.files;
      
                function previewUpload(file) {
                    if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
                        var reader = new FileReader();
                        reader.addEventListener('load', function () {
                            const html =
                                '<div class=\"form-upload__item\">' +
                                    '<div class="form-upload__item-thumbnail" style="background-image: url(' + this.result + ')"></div>' +
                                '</div>';
                            preview.html( html );
                        }, false);
                        reader.readAsDataURL(file);
                    } else {
                        alert('Please upload image only');
                        uploadControl.val('');
                    }
                }
      
            [].forEach.call(files, previewUpload);
          })
        }
    })( jQuery )
    
    $('.form-upload').attachmentUploader();

    // show pass
    $('#eye-pass').click(function() {
        $('#eye-pass .fa-regular').toggleClass('d-none')
        if ($('#eye-pass .fa-eye').hasClass('d-none')) {
            $('#password').attr('type', 'text')
        } else {
            $('#password').attr('type', 'password')
        }
    })

    $('#eye-pass-new').click(function() {
        $('#eye-pass-new .fa-regular').toggleClass('d-none')
        if ($('#eye-pass-new .fa-eye').hasClass('d-none')) {
            $('#new_password').attr('type', 'text')
        } else {
            $('#new_password').attr('type', 'password')
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

    $(window).scroll(function(event) {
        var pos_body = $('html,body').scrollTop();
        if (pos_body > 270) {
            $('.nav-scroll-top').addClass('act-scroll');
        } else {
            $('.nav-scroll-top').removeClass('act-scroll');
        }
    });
})
