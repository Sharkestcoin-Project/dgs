"use strict";
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
        return $("#subscription-form").submit();
    }
    $(tabs[currentTab - n]).hide();
    showTab(currentTab);
}

$(document).ready(function() {
    $('.repeater').repeater({
        initEmpty: true,
        defaultValues: {
            'title': '',
        },
        show: function() {
            $(this).slideDown();
        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        },
        ready: function(setIndexes) {
            $dragAndDrop.on('drop', setIndexes);
            $(document).on('ready', function() {
                setIndexes()
            })
        },
        isFirstItemUndeletable: false
    })
});
