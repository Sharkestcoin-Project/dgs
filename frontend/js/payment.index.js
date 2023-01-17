"use strict"

var spinner = '<div class="spinner-grow text-white" role="status"><span class="visually-hidden">Loading...</span></div>';
var tabTrigger;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.promoform').validate();

$('.promoform').on('submit', function (e) {
    e.preventDefault();

    if($(this).valid()){
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
                Sweet('success', res.message);
                $('.gateways').html(res.html);
                $('.basicbtn')
                    .html('Remove')
                    .addClass('bg-danger btn-remove')
                    .removeAttr('disabled')
                    .attr('type', 'button');

                $('#code').attr('disabled', true);
                showTab(tabTrigger)
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
    }
});

$(document).on('click','.btn-remove', function (e) {

    var basicBtnHtml = $('.basicbtn').html();

    var url = $('#removePromoUrl').val();

    $.ajax({
        type: 'POST',
        url: url,
        beforeSend: function () {
            $('.basicbtn').html(spinner);
            $('.basicbtn').attr('disabled', '');
        },
        success: function (res) {
            Sweet('success', res.message);
            $('.gateways').html(res.html);
            $('.basicbtn')
                .html('Apply')
                .removeClass('bg-danger btn-remove')
                .removeAttr('disabled')
                .attr('type', 'submit');

            $('#code').attr('disabled', false).val(null);
            showTab(tabTrigger)
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

$(document).on('shown.bs.tab', 'button[data-bs-toggle="tab"]', function (e) {
    tabTrigger = $(e.target).attr("data-bs-target");
    console.log(tabTrigger)
})

function showTab(trigger) {
    $(trigger).trigger('click');
}

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
