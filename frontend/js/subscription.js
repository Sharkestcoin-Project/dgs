"use strict";
var subscriptionModal = new bootstrap.Modal(document.getElementById('subscriptionModal'))

$(document).on('click', '.subscription-select', function () {
   let $planId = $(this).data('plan');
   let $url = $(this).data('url');

   $.ajax({
       url: $url,
       success: function (res) {
           $('.subscription-modal-body').html(res)
           subscriptionModal.show();
       }
   })
});
