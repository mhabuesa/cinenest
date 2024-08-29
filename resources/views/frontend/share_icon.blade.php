@push('head')
    <style>
        .swal2-popup.swal2-toast{
            background-color: rgb(255, 255, 255) !important;

        }
    .share{
        z-index: 999;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .sticky_share_btn {
        z-index: 999;
        position: fixed;
        left: 30px;
        bottom: 30px;
    }
    .share-toggle,
    .fixed_share ul.listing > li {
        z-index: 999;
        font-size: 25px;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid;
        border-radius: 50%;
        transition: all 0.5s ease-in-out;
        background-color: aliceblue;
    }
    ul.listing {
        list-style: none;
        display: none;
    }
    .fixed_share ul.listing > li {
    margin-bottom: 10px;
    }
    .fixed_share ul.listing > li > a {
        display: block;
        width: 100%;
        height: auto;
        text-align: center;
    }
    .share-toggle:hover,
    .fixed_share ul.listing > li:hover {
    transform: scale(1.1) rotate(360deg);
    }

    .fixed_share .facebook,
    .fixed_share .facebook > a{
    color: #4267B2;
    }
    .fixed_share .twitter,
    .fixed_share .twitter > a{
    color: #00acee;
    }
    .fixed_share .pinterest,
    .fixed_share .pinterest > a{
    color: #E60023;
    }
    .fixed_share .linkedin,
    .fixed_share .linkedin > a{
    color: #0e76a8;
    }
    .fixed_share .whatsapp,
    .fixed_share .whatsapp > a{
    color: #25D366;
    }
    </style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@endpush
    <div class="share">
        <div class="sticky_share_btn">
            <div class="fixed_share">
              <ul class="listing">
                <li class="facebook" data-href="https://developers.facebook.com/docs/plugins/" data-layout="" data-size="">
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https:{{url()->full()}}" class="fb-xfbml-parse-ignore"><i class="fa fa-facebook-square"></i></a>
                </li>
                <li class="twitter">
                  <a href="https://x.com/intent/tweet?url={{url()->full()}}" target="_blank">
                    <i class="fa fa-twitter"></i>
                  </a>
                </li>
                <li class="pinterest">
                  <a href="https://pinterest.com/pin/create/button/?url={{url()->full()}}" target="_blank">
                    <i class="fa fa-pinterest"></i>
                  </a>
                </li>
                <li class="linkedin">
                  <a href="https://www.linkedin.com/shareArticle?mini=true&url={{url()->full()}}" target="_blank">
                    <i class="fa fa-linkedin-square"></i>
                  </a>
                </li>
                <li class="whatsapp">
                    <a href="https://api.whatsapp.com/send?text={{url()->full()}}" target="_blank">
                      <i class="fa fa-whatsapp"></i>
                    </a>
                  </li>
                <li class="linkedin">
                  <a class="copy-btn">
                    <i class="fa fa-copy"></i>
                    <div class="copy-source d-none">
                        {{url()->full()}}
                    </div>
                  </a>
                </li>
              </ul>
              <span class="share-toggle" style="background: white;">
                <i class="fa fa-share-alt"></i>
              </span>
            </div>
          </div>
    </div>


@push('element')
    <script>
        // Toggle the visibility of the .listing element when the .sticky_share_btn is clicked
        jQuery(".sticky_share_btn").click(function () {
        jQuery(".listing").fadeToggle(200);
        });

        // Hide the .listing element when clicking outside of it
        jQuery(document).click(function(event) {
        // Check if the clicked element is not the .listing or its descendants and not the .sticky_share_btn
        if (!jQuery(event.target).closest(".listing, .sticky_share_btn").length) {
            // If the .listing is currently visible, fade it out
            if (jQuery(".listing").is(":visible")) {
            jQuery(".listing").fadeOut(200);
            }
        }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        jQuery(document).ready(function() {
        // When the copy button is clicked
        jQuery(".copy-btn").click(function() {
            // Find the text in the .copy-source element (can be hidden or not)
            var textToCopy = jQuery(".copy-source").text();

            // Create a temporary textarea element to hold the text
            var tempElement = jQuery('<textarea>').val(textToCopy).appendTo('body').select();

            // Copy the text to the clipboard
            document.execCommand('copy');

            // Remove the temporary textarea element
            tempElement.remove();

            // Function to check if the device is mobile
            function isMobileDevice() {
                return /Mobi|Android/i.test(navigator.userAgent) || window.innerWidth <= 768;
            }

            // Show the SweetAlert2 toast notification only if not on a mobile device
            if (!isMobileDevice()) {
                // SweetAlert2 toast configuration
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                // Show the toast notification
                Toast.fire({
                    icon: 'success',
                    title: 'Link copied to clipboard'
                });
            }
        });
    });
    </script>
@endpush
