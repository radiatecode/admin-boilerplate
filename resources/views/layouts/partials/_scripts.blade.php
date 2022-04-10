<!-- jQuery -->
<script src="{{ asset('js/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap 4 -->
<script src="{{ asset('js/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- moment date -->
<script src="{{ asset('js/plugins/moment/moment.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>

<!-- sweet alert -->
<script src="{{ asset('js/plugins/sweetalert/sweetalert2.js') }}"></script>

<!-- toast -->
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

<!-- select2 -->
<script src="{{ asset('js/plugins/select2/js/select2.full.js') }}"></script>

<!-- datepicker -->
<script src="{{ asset('js/plugins/bootstrap-datepicker/datepicker.js') }}"></script>

<!-- timepicker -->
<script src="{{ asset('js/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>

<!-- lodash -->
<script src="{{ asset('js/plugins/lodash/lodash.min.js') }}"></script>

<!-- time picker -->
{{--<script type="text/javascript" src="{{ asset('js/plugins/wickedpicker/dist/wickedpicker.min.js')  }}"></script>--}}
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>--}}

<!-- network request js -->
<script src="{{ asset('js/network.request.js') }}"></script>

<!-- laravel validation message js -->
<script src="{{ asset('js/laravel.validation.message.js') }}"></script>

<script>
    window.CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    window.BASE_PATH = $('meta[name="app-url"]').attr('content');

    $(function () {
        $(".datepicker").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });

        $(".month").datepicker({
            autoclose: true,
            format: "MM-yyyy",
            startView: "months",
            minViewMode: "months"
        });

        // $('.wp_timepicker').wickedpicker();

        $('.jq_timepicker').timepicker({
            scrollbar: true
        });

        $('.bt_timepicker').timepicker();

        $('.select2_dropdown').select2({
            placeholder : '-- select item --',
            width: '100%',
        });

        // confirm before submit
        $('#confirm-form').submit(function (event) {
            event.preventDefault();
            var form = this, $form = $('#confirm-form');
            Swal.fire({
                title: "Confirm",
                text: "Are you sure you want to submit ?",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonColor: "#d9534f",
                confirmButtonText: "Yes"
            }).then(function (result) {
                if (result.value) {
                    $form.attr('action', form.action).off('submit').submit(); // reuse submit
                }
            });
        });
    });

    function logout(){
        // logout code here
    }
</script>
