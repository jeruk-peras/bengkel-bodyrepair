<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Crop Image Before Upload</title>
  <link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
  <style>
    #preview {
      width: 300px;
      height: 300px;
      overflow: hidden;
    }
  </style>
</head>
<body>

<input type="file" id="imageInput">
<br><br>
<div>
  <img id="image" style="max-width: 100%;" />
</div>
<br>
<button id="cropButton">Crop & Upload</button>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

<script>
  let cropper;

  $('#imageInput').on('change', function (e) {
    const file = e.target.files[0];
    if (file) {
      const url = URL.createObjectURL(file);
      $('#image').attr('src', url);

      if (cropper) {
        cropper.destroy();
      }

      cropper = new Cropper(document.getElementById('image'), {
        aspectRatio: 1,
        viewMode: 1,
      });
    }
  });

  $('#cropButton').on('click', function () {
    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
      width: 300,
      height: 300,
    });

    canvas.toBlob(function (blob) {
      const formData = new FormData();
      formData.append('croppedImage', blob);

      $.ajax({
        url: 'upload.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          alert('Upload berhasil: ' + response);
        },
        error: function (err) {
          console.error('Upload gagal', err);
        }
      });
    });
  });
</script>


</body>
</html>
