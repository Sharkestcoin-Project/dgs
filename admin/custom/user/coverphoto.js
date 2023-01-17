(function ($) {
    "use strict";

    // Upload main Photo
    var $previewImage = $("#previewImage");
    var $cropperModal = $('#photo_cropper_modal');

    var $input = $("[name='cover']");
    var $logo_input = $("[name='store_logo']");
    var $coverPhotoCropper;
    var $coverParentPreviewImage = $("#cover_photo_parent_preview");

    $("#cover_local").change(function () {
        $cropperModal.modal('show')

        var oFReader = new FileReader();

        oFReader.readAsDataURL(this.files[0]);

        oFReader.onload = function (oFREvent) {
            var $result = this.result;

            // Replace url
            $previewImage.attr('src', $result);

            // This event for overflow issue
            $cropperModal.on('shown.bs.modal', function (e) {
                // Start cropper
                $coverPhotoCropper = $previewImage.cropper({
                    aspectRatio: 5/3,
                    movable: true,
                    zoomable: true,
                    rotatable: false,
                    scalable: false,
                });
            })

            // Crop the image
            $('#btnCrop').on('click', function () {
                // Get a string base 64 data url
                var $coverImageDataURL = $coverPhotoCropper.cropper('getCroppedCanvas', { width: 500, height: 300}).toDataURL("image/png");
                $coverParentPreviewImage.attr('src', $coverImageDataURL);
                $input.val($coverImageDataURL)
                $logo_input.val($coverImageDataURL)
                $cropperModal.modal('hide')
            });
        };
    });

    $cropperModal.on('hidden.bs.modal', function (e) {
        $previewImage.cropper('destroy');
    })
})(jQuery);
