$(function() {
/////// Cropper Options set
    var cropper;
    var options = {
        aspectRatio: 1 ,
        minContainerWidth: 512,
        minContainerHeight: 512,
        minCropBoxWidth: 145,
        minCropBoxHeight: 145,
        maxCropBoxWidth: 256,
        maxCropBoxHeight: 256,
        rotatable: true,
        cropBoxResizable: true,
        crop: function(e) {
            $("#complaint_image_cropped").val(parseInt(e.detail.width) + "," + parseInt(e.detail.height) + "," + parseInt(e.detail.x) + "," + parseInt(e.detail.y) + "," + parseInt(e.detail.rotate));
        }
    };
///// Show cropper on existing Image
    $("body").on("click", "#image_source", function() {
        var src = $("#image_source").attr("src");
        src = src.replace("/thumb", "");
        $('#image_cropper').attr('src', src);
        $('#image_edit').val("yes");
        $("#cropper").modal("show");
    });
///// Destroy Cropper on Model Hide
    $(".modal").on("hide.bs.modal", function() {
        cropper.destroy();
        $(".cropper-container").remove();
    });
/// Show Cropper on Model Show
    $(".modal").on("show.bs.modal", function() {
        var image = document.getElementById('image_cropper');
        cropper = new Cropper(image, options);
    });
///// Rotate Image
    $("body").on("click", ".rotate", function() {
        var degree = $(this).attr("data-option");
        cropper.rotate(degree);
    });
///// Saving Image with Ajax Call
    $("body").on("click", "#Save", function() {
        var form_data = $('#newcomplaint')[0];
        $.ajax({
            url: "/admin/klachten/nieuw/klachtafbeelding", // Url to which the request is send
            type: "POST",
            mimeType: "multipart/form-data",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, // Type of request to be send, called as method
            data: new FormData(form_data), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function(filename) // A function to be called if request succeeds
            {
                $('#complaint_image_filename').val(filename);
                alert("Afbeelding opgeslagen als:" + filename);
                $("#cropper").modal("hide")
            }
        });
    });
    var canvas  = $("#image_cropper");
    var context = canvas.get(0).getContext("2d");
////// When user upload image
    $(document).on("change", "#complaint_image", function() {
        var file = this.files[0],
            imagefile = file.type,
            _URL = window.URL;
        var img = new Image();
        img.src = _URL.createObjectURL(file);
        img.onload = function() {
            var match = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
            if (!((imagefile === match[0]) || (imagefile === match[1]) || (imagefile === match[2]) || (imagefile === match[3]))) {
                alert('Kies alstublieft een ondersteunt formaat');
                return false;
            } else {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function() { // set image data as background of div
                    context.canvas.height = img.height;
                    context.canvas.width  = img.width;
                    context.drawImage(img, 0, 0);
                    $('#image_edit').val("");
                    $("#cropper").modal("show");
                }
            }
        }
    });
    $('#name').keyup( function () {
        var name = $(this).val();
        var slug = name.replace(/\s/g,'-');
        var slug2 = slug.toLowerCase();
        $('#url_name').val(slug2);
    });
});