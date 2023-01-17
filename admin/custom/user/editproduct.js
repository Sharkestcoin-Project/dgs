"use strict"

$(document).on('change', '#uploadFromLocal', function () {
    var file = $(this).prop("files")[0];
    var formData = new FormData();
    formData.append("file", file);
    formData.append("type", 'local');

    var _this = $(this);
    var basicBtnHtml = _this.html();

    $.ajax({
        url: "/user/products/upload",
        type: 'post',
        dataType: 'script',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        beforeSend: function () {
            _this.html("Please Wait....");
            _this.attr('disabled', '');
        },
        success: function(data) {
            previewFile(JSON.parse(data))
            _this.removeAttr('disabled');
            _this.html(basicBtnHtml);
        },
        error: function(xhr, status, error)
        {
            _this.removeAttr('disabled');
            _this.html(basicBtnHtml);

            let response = JSON.parse(xhr.responseText);
            if (response.errors){
                $.each(response.errors, function (i, error) {
                    Sweet('error', error)
                })
            }else{
                Sweet('error', xhr.responseText);
            }
        }
    });
});

$(document).on('click', '#uploadFromUrlButton', function () {
    var url = $('#directUrl').val();
    if (!url) {
        Sweet('error', "Direct link field is required.");
        return;
    }
    var html = `<input type="url" name="direct_url" id="uploadFileModalButton" class="form-control" value="${url}">`
    $('.product_file').html(html);
    $('.uploadFileLable').text("Direct link");
    $('#showName').html("");
    $('#fileModal').modal("hide");
});

$(document).on('click', '.delete-file-confirm', function(event) {
    var url = $(this).attr('data-action');
    var _this = $(this)
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to do this?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6777ef',
        cancelButtonColor: '#fc544b',
    }).then((result) => {
        if (result.value) {
            event.preventDefault();
            $.ajax({
                type: "DELETE",
                url: url,
                success: function(response){
                    _this.parent().hide();
                },
                error: function(xhr, status, error)
                {
                    error_response(xhr)
                }
            })
        }
    })
});

function previewFile(data) {
    $('#folder').attr('value', data.folder);
    $('#showName').show();
    $('#showName')
        .find('span')
        .html(data.filename)

    $('#showName')
        .find('a')
        .attr('data-action', '/user/products/destroy/temporary/'+data.folder)

    $('#fileModal').modal('hide');
}

var currentTab = 0;
showTab(currentTab);

function showTab(n) {
    var tabs = $(".tab");
    $(tabs[n]).show();
    if (n == 0) {
        $("#prevBtn").hide();
    } else {
        $("#prevBtn").css('display', 'inline');
    }
    if (n == (tabs.length - 1)) {
        $("#nextBtn").html(`<i class="fas fa-save"></i> Submit`);
    } else {
        $("#nextBtn").html(`Next <i class="fas fa-angle-double-right"></i>`);
    }
}

function nextPrev(n) {
    var tabs = $(".tab");
    currentTab = currentTab + n;
    if (currentTab >= tabs.length) {
        return $("#product_form").submit();
    }
    $(tabs[currentTab - n]).hide();
    showTab(currentTab);
}

