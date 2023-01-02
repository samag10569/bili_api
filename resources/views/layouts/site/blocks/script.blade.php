<!-- SCRIPTS -->

<script src="{!! asset('assets/site/js/TweenLite.min.js') !!}"></script>
<script src="{!! asset('assets/site/js/EasePack.min.js') !!}"></script>
<script src="{!! asset('assets/site/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('assets/site/js/bootstrap-select.js') !!}"></script>
<script src="{!! asset('assets/site/js/viewportchecker.js') !!}"></script>
<script src="{!! asset('assets/site/js/jquery.powertip.js') !!}"></script>
<script src="{!! asset('assets/site/js/select2.min.js') !!}"></script>
<script src="{!! asset('assets/site/js/myscripts.js') !!}"></script>

<!-- Validation -->
<script src="{{ asset('assets/admin/js/jquery.validate.min.js')}}"></script>

<script>
    function refreshCaptcha() {
        $.ajax({
            url: "{{asset('refereshcapcha')}}",
            type: 'get',
            dataType: 'html',
            success: function (json) {
                $('.refereshrecapcha').html(json);
            },
            error: function (data) {
                alert('Try Again.');
            }
        });
    }

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>


@yield('js')
