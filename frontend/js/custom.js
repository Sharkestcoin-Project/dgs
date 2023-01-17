"use strict"

var spinner = '<div class="spinner-grow text-white" role="status"><span class="visually-hidden">Loading...</span></div>';
var tabTrigger;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.has-read-more', function(e){
    e.preventDefault();

    $(this).parent().parent().find('.full-text').show()
    $(this).parent().hide();
})

$(document).on('click', '.has-read-less', function(e){
    e.preventDefault();

    $(this).parent().parent().find('.less-text').show()
    $(this).parent().hide();
})

$('.resentEmail').on('submit', function (e) {
    e.preventDefault();

    var basicBtnHtml = $('.basicbtn').html();

    $.ajax({
        type: 'POST',
        url: this.action,
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $('.basicbtn').html(spinner);
            $('.basicbtn').attr('disabled', '');
        },
        success: function (res) {
            if (res.message){
                Sweet('success', res.message);
            }else{
                Sweet('success', res);
            }
            $('.basicbtn').html(basicBtnHtml);
            $('.basicbtn').removeAttr('disabled');
        },
        error: function (xhr, status, error) {
            if (xhr.responseJSON.message) {
                Sweet('error', xhr.responseJSON.message);
            }else if (xhr.responseJSON) {
                Sweet('error', xhr.responseJSON);
            }

            $('.basicbtn').html(basicBtnHtml);
            $('.basicbtn').removeAttr('disabled');
        }
    });
});

var ajaxform_with_redirect = $(".ajaxform_with_redirect");
ajaxform_with_redirect.initFormValidation();

$(document).on('submit', '.ajaxform_with_redirect', function (e) {
    e.preventDefault();

    if (ajaxform_with_redirect.valid()) {
        var basicBtnHtml = $('.basicbtn').html();

        $.ajax({
            type: 'POST',
            url: this.action,
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('.basicbtn').html('Please Wait....');
                $('.basicbtn').attr('disabled', '');
            },
            success: function (response) {
                if (response.message) {
                    Sweet('success', response.message);
                }
                if (response.redirect) {
                    if (response.message) {
                        window.setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 1500)
                    } else {
                        window.location.href = response.redirect;
                    }
                }
            },
            error: function (xhr) {
                $('.basicbtn').html(basicBtnHtml);
                $('.basicbtn').removeAttr('disabled');

                if (xhr.responseJSON.message) {
                    Sweet('error', xhr.responseJSON.message);
                } else if (xhr.responseJSON) {
                    Sweet('error', xhr.responseJSON);
                } else {
                    Sweet('error', xhr.responseText);
                }

                showInputErrors(xhr.responseJSON)
            }
        });
    }
});

// $(document).on('click', '.form__box', function() {
//     $(this).find('.form__label').remove()
// })

/*---------------------------
        Sweet Alert Active
    -----------------------------*/
function Sweet(icon, title, time = 3000) {

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: time,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });


    Toast.fire({
        icon: icon,
        title: title,
    });
}
