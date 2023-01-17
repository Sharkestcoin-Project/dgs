(function ($) {
    "use strict";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*-------------------------
        Ajaxform with Reload
    -----------------------------*/
    var ajaxform_with_reload = $(".ajaxform_with_reload");
    ajaxform_with_reload.initFormValidation();

    $(".ajaxform_with_reload").on('submit', function (e) {
        e.preventDefault();

        if (ajaxform_with_reload.valid()) {

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
                    $('.basicbtn').html("Please Wait....");
                    $('.basicbtn').attr('disabled', '');
                },

                success: function (response) {
                    $('.basicbtn').removeAttr('disabled');
                    Sweet('success', response);
                    $('.basicbtn').html(basicBtnHtml);
                    window.setTimeout(function () {
                        location.reload();
                    }, 1500);
                },
                error: function (xhr, status, error) {
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

    /*-------------------------
        Ajaxform with Reset
    -----------------------------*/
    var ajaxform_with_reset = $(".ajaxform_with_reset");
    ajaxform_with_reset.initFormValidation();

    $(".ajaxform_with_reset").on('submit', function (e) {
        e.preventDefault();

        if (ajaxform_with_reset.valid()) {
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
                    $('.basicbtn').html("Please Wait....");
                    $('.basicbtn').attr('disabled', '');
                },

                success: function (response) {
                    $('.basicbtn').removeAttr('disabled');
                    Sweet('success', response);
                    $('.basicbtn').html(basicBtnHtml);
                    $('.ajaxform_with_reset').trigger('reset');
                    $('.summernote').summernote('reset');
                    var placeholder_image = $('.placeholder_image').val();
                    $('.input_preview').attr('src', placeholder_image);
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


    $(".ajaxform_with_custom").on('submit', function (e) {
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
                $('.basicbtn').html("Please Wait....");
                $('.basicbtn').attr('disabled', '')
            },
            success: function (response) {
                $('.basicbtn').removeAttr('disabled')
                Sweet('success', response);
                $('.basicbtn').html(basicBtnHtml);
                $('.ajaxform_with_custom').trigger('reset');
            },
            error: function (xhr) {
                $('.basicbtn').html(basicBtnHtml);
                $('.basicbtn').removeAttr('disabled')

                if (xhr.responseJSON.message) {
                    Sweet('error', xhr.responseJSON.message);
                } else if (xhr.responseJSON) {
                    Sweet('error', xhr.responseJSON);
                } else {
                    Sweet('error', xhr.responseText);
                }

                showInputErrors(xhr.responseJSON)
            }
        })
    });

    /*-------------------------
        Ajaxform with Next
    -----------------------------*/
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

    /*-------------------------
        Ajaxform with Next
    -----------------------------*/

    $(document).on('submit', '.ajaxform_with_mass_action', function (e) {
        e.preventDefault();
        var status = $(this).find('.action-select').val();

        if (status){
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to do this action?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6777ef',
                cancelButtonColor: '#fc544b',
            }).then((result) => {
                if (result.value) {
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
        }else{
            Sweet('error', 'Please select a option')
        }
    });


    $(document).on('submit', '.ajaxform_with_redirect_without_validation', function (e) {
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
            error: function (xhr, ) {
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
    });

    /*-------------------------
        Ajaxform with Mass Delete Warning
    -----------------------------*/

    $(".ajaxform_with_mass_delete").on('submit', function (e) {
        e.preventDefault();
        var _this = this;

        var allChecked = $('.ajaxform_with_mass_delete').find('.checked_input:checked');

        if (allChecked.length !== 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var basicBtnHtml = $('.basicbtn').html();

                    $.ajax({
                        type: 'POST',
                        url: _this.action,
                        data: new FormData(_this),
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
                            } else {
                                Sweet('error', xhr.responseText);
                            }

                            showInputErrors(xhr.responseJSON)
                        }
                    });
                }
            })
        } else {
            Sweet('warning', 'Please select at least one item')
        }
    });

    /*-------------------------
        Ajaxform with Submit
    -----------------------------*/
    var ajaxform = $("#ajaxform, .ajaxform");
    ajaxform.initFormValidation();

    $("#ajaxform, .ajaxform").on('submit', function (e) {
        e.preventDefault();

        if (ajaxform.valid()) {
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
                    $('.basicbtn').html("Please Wait....");
                    $('.basicbtn').attr('disabled', '');
                },
                success: function (response) {
                    $('.basicbtn').html(basicBtnHtml);
                    $('.basicbtn').removeAttr('disabled');
                    success(response)
                },
                error: function (xhr, status, error) {
                    error_response(xhr);
                    $('.basicbtn').html(basicBtnHtml);
                    $('.basicbtn').removeAttr('disabled');

                    showInputErrors(xhr.responseJSON)
                }
            });
        }
    });

    $(".makepayout").on('submit', function (e) {
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
                $('.basicbtn').html("Please Wait....");
                $('.basicbtn').attr('disabled', '');
            },
            success: function (res) {
                if (res.redirect) {
                    window.location.href = res.redirect;
                }
                console.log(res)
                Sweet('success', res.message);
                $('.basicbtn').html(basicBtnHtml);
                $('.basicbtn').removeAttr('disabled');
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON) {
                    Sweet('error', xhr.responseJSON);
                }
                console.log(xhr)
                $('.basicbtn').html(basicBtnHtml);
                $('.basicbtn').removeAttr('disabled');
            }
        });
    });


    /*-------------------------
        Ajaxform2 with Submit
    -----------------------------*/
    var ajaxform2 = $(".ajaxform2");
    ajaxform2.initFormValidation();

    $(document).on('submit', '.ajaxform2', function (e) {
        e.preventDefault();
        if (ajaxform2.valid()) {

            var basicBtnHtml = $('.basicbtn').html();

            $.ajax({
                type: this.method,
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('.basicbtn').html("Please Wait....");
                    $('.basicbtn').attr('disabled', '')
                },
                success: function (response) {
                    $('.basicbtn').removeAttr('disabled')
                    Sweet('success', response);
                    $('.basicbtn').html(basicBtnHtml);
                },
                error: function (xhr, status, error) {
                    $('.basicbtn').html(basicBtnHtml);
                    $('.basicbtn').removeAttr('disabled')

                    showInputErrors(response.responseJSON)
                }
            })
        }
    });

    $(document).on('submit', '#global-search', function (e) {
        e.preventDefault();

        $.ajax({
            type: this.method,
            url: this.action,
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $('#global-search-result').html(response.html);
            },
            error: function (xhr, status, error) {
                $('#global-search-result').empty();
                $('#global-search-result').html('<div class="search-item"><a href="#">Data Not Found</a> <a href="#" class="search-close"><i class="fas fa-times"></i></a> </div>');
                Sweet('error', xhr.responseJSON.message);
            }
        })
    });

    $(document).on('keyup', '#global-search-input', function () {
        delay(function () {
            $('#global-search').trigger('submit');
        }, 1000);
    });

})(jQuery);

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

var delay = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();


function showInputErrors(errors) {
    $.each(errors['errors'], function (index, value) {
        $('#' + index + '-error').remove();
        $('#' + index).addClass('is-invalid')
            .after('<label id="' + index + '-error" class="is-invalid" for="' + index + '">' + value + '</label>')
    });
}
