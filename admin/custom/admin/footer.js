"use strict";
$(document).ready(function () {
    $('.repeater').repeater({
        initEmpty: true,
        defaultValues: {
            'icon_class': '',
            'website_url': ''
        },
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },
        ready: function (setIndexes) {
            $dragAndDrop.on('drop', setIndexes);
            $(document).on('ready', function () {
                setIndexes()
            })
        },
        isFirstItemUndeletable: false
    })
});

$(document).on('keyup', '.icon_class', function () {
    let _class = $(this).val();
    $(this).closest('.input-group').find($('.input-group-text i')).attr('class', _class);
});
