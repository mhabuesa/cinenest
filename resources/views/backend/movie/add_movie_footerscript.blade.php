@push('script')
    	<!-- JS -->
	<script src="{{asset('frontend')}}/admin/js/jquery-3.5.1.min.js"></script>
	<script src="{{asset('frontend')}}/admin/js/bootstrap.bundle.min.js"></script>
	<script src="{{asset('frontend')}}/admin/js/jquery.magnific-popup.min.js"></script>
	<script src="{{asset('frontend')}}/admin/js/jquery.mousewheel.min.js"></script>
	<script src="{{asset('frontend')}}/admin/js/jquery.mCustomScrollbar.min.js"></script>
	<script src="{{asset('frontend')}}/admin/js/select2.min.js"></script>
	<script src="{{asset('frontend')}}/admin/js/admin.js"></script>
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    ></script>
    <script>
        $('#select-gear').selectize({ sortField: 'text' })
    </script>

    <script>
        $("#input-tags").selectize({
    delimiter: ",",
    persist: false,
    create: function (input) {
            return {
                value: input,
                text: input,
            };
        },
        });
    </script>


  <!-- Image Upload JS -->
  <script>
    jQuery(document).ready(function () {
        ImgUpload();
    });

    function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $('.upload__inputfile').each(function () {
        $(this).on('change', function (e) {
        imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
        var maxLength = $(this).attr('data-max_length');

        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        var iterator = 0;
        filesArr.forEach(function (f, index) {

            if (!f.type.match('image.*')) {
            return;
            }

            if (imgArray.length > maxLength) {
            return false
            } else {
            var len = 0;
            for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i] !== undefined) {
                len++;
                }
            }
            if (len > maxLength) {
                return false;
            } else {
                imgArray.push(f);

                var reader = new FileReader();
                reader.onload = function (e) {
                var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                imgWrap.append(html);
                iterator++;
                }
                reader.readAsDataURL(f);
            }
            }
        });
        });
    });

    $('body').on('click', ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
        if (imgArray[i].name === file) {
            imgArray.splice(i, 1);
            break;
        }
        }
        $(this).parent().parent().remove();
    });
    }

  </script>

@if (session('created'))
<script>
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
    });
    Toast.fire({
    icon: "success",
    title: "{{session('created')}}"
    });
</script>
@endif

@if (session('updated'))
<script>
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
    });
    Toast.fire({
    icon: "success",
    title: "{{session('updated')}}"
    });
</script>
@endif


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('container');

        // Function to add new content
        function addContent() {
            const newDiv = document.createElement('div');
            newDiv.classList.add('d-flex', 'justify-content-between', 'mt-1');
            newDiv.innerHTML = `
                <input type="text" class="form-control mx-1" name="caption[]" id="caption" placeholder="Add Download Caption" required value="">
                <input type="text" class="form-control mx-1" name="down_link[]" placeholder="Add Download link" required value="">
                <a class="btn btn-danger btn-sm mx-1 text-white" id="close"><i class="fa-solid fa-x"></i></a>
            `;

            // Append new div to container
            container.appendChild(newDiv);

            // Add event listener to close button
            const closeButton = newDiv.querySelector('#close');
            closeButton.addEventListener('click', function() {
                container.removeChild(newDiv);
            });
        }

        // Event listener for Add button
        const addButton = document.getElementById('add');
        addButton.addEventListener('click', addContent);
    });
</script>



@endpush
