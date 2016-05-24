@if(Session::get('toastr'))
    <script>
        $(document).ready(function() {
        	toastr.options.timeOut = 2000;
        	toastr.options.extendedTimeOut = 2000;
            toastr.{{ Session::remove('toastr.level') }}
            ("{{ Session::remove('toastr.message') }}");
        });
    </script>
@endif