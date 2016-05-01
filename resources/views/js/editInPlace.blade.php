<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script>
    $( function() {
        // Remember to set the $token on the parent template
        $.fn.editable.defaults.ajaxOptions = {method: 'PATCH'};
        $(".editable").editable({
            params: function (params) {
                var data = {};
                data['id'] = params.pk;
                data[params.name] = params.value;
                data['_token'] = '{{ $token }}';
                return data;
            },
            success: function (response, newValue) {
                var parent = $(this).parent();
                if (parent.hasClass('progress-bar')) {
                    parent.width(newValue + '%');
                }
            }
        });
    });
</script>