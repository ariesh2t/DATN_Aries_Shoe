$(document).ready(function() {
    //upload image
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
                                    '<div class=\"form-upload__close\">x</div>' +
                                    '<div class="form-upload__item-thumbnail" style="background-image: url(' + this.result + ')"></div>' +
                                '</div>';
                            preview.append( html );
                            btnClear.addClass('d-block').removeClass('d-none');
                        }, false);
                        reader.readAsDataURL(file);
                    } else {
                        alert('Please upload image only');
                        uploadControl.val('');
                    }
                }
      
            [].forEach.call(files, previewUpload);
            
            btnClear.on('click', function() {
                $('.form-upload__item').remove();
                uploadControl.val('');
                $(this).addClass('d-none').removeClass('d-block');
            })
          })
        }
    })( jQuery )
    
    $('.form-upload').attachmentUploader();

    $('.form-upload__preview').on('click', '.form-upload__close', function() {
        $(this).closest('.form-upload__item').remove();
        if ($('.form-upload__preview').find('.form-upload__item').length == 0) {
            $('.btn-clear').addClass('d-none').removeClass('d-block');
        }
    })

    // scroll to Top
    $(window).scroll(function(event) {
        var pos_body = $('html,body').scrollTop();
        if(pos_body>500){
            $("#backtop").fadeIn( "slow");
        }
        else{
            $('#backtop').fadeOut('slow');
        }
    });

    $('#backtop').on('click', function() {
        $('html, body').animate({
            scrollTop: 0
        }, 500)
    })
})