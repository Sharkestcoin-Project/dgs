(function ($) {
    "use strict";

    /*----------------------------
          Comment reply box scrollbar Active
        ------------------------------*/
    $(".comment-reply-box").niceScroll({cursorcolor:"#5b7798"});


    const copyLinkBtn = document.getElementById("copyLinkBtn")
    $(document).on('click', '.copyLinkBtn', function() {
        const url = $(this).data('id');
        copyLinkBtn.textContent = 'Copied';
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(url);
        } else {
            let textArea = document.createElement("textarea");
            textArea.value = url;
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            textArea.style.top = "-999999px";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            return new Promise((res, rej) => {
                document.execCommand('copy') ? res() : rej();
                textArea.remove();
            });
        }
    })

    const productLink = document.getElementById("productLink")
    $(document).on('click', '.productLink', function() {
        const url = $(this).data('id');
        productLink.textContent = 'Copied';
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(url);
        } else {
            let textArea = document.createElement("textarea");
            textArea.value = url;
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            textArea.style.top = "-999999px";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            return new Promise((res, rej) => {
                document.execCommand('copy') ? res() : rej();
                textArea.remove();
            });
        }
    })

    const buttonLinkCopy = document.getElementById("buttonLinkCopy")
    $(document).on('click', '.buttonLinkCopy', function() {
        const url = $(this).data('id');
        buttonLinkCopy.textContent = 'Copied';
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(url);
        } else {
            let textArea = document.createElement("textarea");
            textArea.value = url;
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            textArea.style.top = "-999999px";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            return new Promise((res, rej) => {
                document.execCommand('copy') ? res() : rej();
                textArea.remove();
            });
        }
    })

    const windowLinkCopy = document.getElementById("windowLinkCopy")
    $(document).on('click', '.windowLinkCopy', function() {
        const url = $(this).data('id');
        windowLinkCopy.textContent = 'Copied';
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(url);
        } else {
            let textArea = document.createElement("textarea");
            textArea.value = url;
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            textArea.style.top = "-999999px";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            return new Promise((res, rej) => {
                document.execCommand('copy') ? res() : rej();
                textArea.remove();
            });
        }
    })


    /*----------------------------
          Hamburger Active
        ------------------------------*/
    $('.hamburger').on('click',function(){
        $('.sidebar').toggleClass('active');
        $('.main-content-area').toggleClass('active');
    });

    /*----------------------------
          Data Append
        ------------------------------*/
    $('#theme_file').on('change',function(){
        var files = [];
        for (var i = 0; i < $(this)[0].files.length; i++) {
            files.push($(this)[0].files[i].name);
        }
        $(this).next('.custom-file-label').html(files.join(', '));
    })


    /*----------------------------
          Jquery Live Search
        ------------------------------*/
    $('#data_search').keyup(function(){
        search_table($(this).val());
    });
    function search_table(value){
        $('.table tbody tr').each(function(){
            var found = 'false';
            $(this).each(function(){
                if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)
                {
                    found = true;
                }
            });
            if(found == true)
            {
                $(this).show();
            }
            else
            {
                $(this).hide();
            }
        });
    }

    $("[data-checkboxes]").each(function() {
        var me = $(this),
            group = me.data('checkboxes'),
            role = me.data('checkbox-role');

        me.change(function() {
            var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
                checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
                dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
                total = all.length,
                checked_length = checked.length;

            if(role == 'dad') {
                if(me.is(':checked')) {
                    all.prop('checked', true);
                }else{
                    all.prop('checked', false);
                }
            }else{
                if(checked_length >= total) {
                    dad.prop('checked', true);
                }else{
                    dad.prop('checked', false);
                }
            }
        });
    });


})(jQuery);

/*----------------------------
        Sweet Aleart
      ------------------------------*/
function Sweet(icon,title,time=3000){

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: time,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })


    Toast.fire({
        icon: icon,
        title: title,
    })
}


function SweetAudio(icon,title,time=3000,audio=""){

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: time,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
            var aud = new Audio(audio)
            aud.play();
        }
    })


    Toast.fire({
        icon: icon,
        title: title,
    })
}



