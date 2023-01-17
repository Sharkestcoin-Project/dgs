(function ($) {
    "use strict";

    // Upload main Photo
    var $profilePreviewImage = $("#profilePreviewImage");
    var $profileCropperModal = $('#profile_cropper_modal');

    var $input = $("[name='avatar']");
    var $avatarPhotoCropper;
    var $avatarParentPreviewImage = $("#avatar_photo_parent_preview");

    $("#avatar_local").change(function () {
        $profileCropperModal.modal('show')

        var oFReader = new FileReader();

        oFReader.readAsDataURL(this.files[0]);

        oFReader.onload = function (oFREvent) {
            var $result = this.result;

            // Replace url
            $profilePreviewImage.attr('src', $result);

            // This event for overflow issue
            $profileCropperModal.on('shown.bs.modal', function (e) {
                // Start cropper
                $avatarPhotoCropper = $profilePreviewImage.cropper({
                    aspectRatio: 1,
                    movable: true,
                    zoomable: true,
                    rotatable: false,
                    scalable: false,
                });
            })

            // Crop the image
            $('#profileBtnCrop').on('click', function () {
                // Get a string base 64 data url
                var $croppedImageDataURL = $avatarPhotoCropper.cropper('getCroppedCanvas', { width: 500, height: 300}).toDataURL("image/png");
                $avatarParentPreviewImage.attr('src', $croppedImageDataURL);
                $input.val($croppedImageDataURL)
                $profileCropperModal.modal('hide')
            });
        };
    });

    $profileCropperModal.on('hidden.bs.modal', function (e) {
        $profilePreviewImage.cropper('destroy');
    })
})(jQuery);
