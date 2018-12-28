@if(Session::has('toastr'))
    <script>

        var msg = new SpeechSynthesisUtterance();
        msg.text = "{{ Session::get('toastr.1') }}";
        window.speechSynthesis.speak(msg);

        toastr.options = {
            "progressBar": true,
            "positionClass":"toast-bottom-right"
        };
        toastr.{{ Session::get('toastr.0') }}("{{ Session::get('toastr.1') }}");

        {{--const toaster = swal.mixin({--}}
            {{--toast: true,--}}
            {{--position: 'top-end',--}}
            {{--showConfirmButton: false,--}}
            {{--timer: 6000,--}}
        {{--});--}}

        {{--toaster({--}}
            {{--type: "{{ Session::get('toastr.0') }}",--}}
            {{--title: "{{ Session::get('toastr.1') }}"--}}
        {{--})--}}

        
    </script>
@endif
