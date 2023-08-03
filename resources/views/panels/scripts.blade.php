<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>


<script src="{{ asset(mix('vendors/js/ui/jquery.sticky.js')) }}"></script>
@yield('vendor-script')

<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

@if ($configData['blankPage'] === false)
    <script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif

@yield('page-script')

<script>
    function fireMessage(confirmButtonText, title = 'تم الحذف بنجاح!', text =
        'تمت العملية بشكل صحيح', icon =
        'success') {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonText: confirmButtonText,
            timer: 1500,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    }

    function goBack() {
        window.history.back();
    }
</script>
