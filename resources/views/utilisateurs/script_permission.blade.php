
  
   <script src="{{ asset('js/plugins/jquery-3.5.1.min.js') }}"></script>
   <script>
  $(document).ready(function() {
    $(document).on('click', '.role-permission', function() {
        var roleName = $(this).attr('data-role');
        var page = $(this).attr('data-page');
        var key = $(this).attr('data-key');
        var val = 0;
        if ($(this).is(':checked')) {
            val = 1;
        }

        console.log(roleName, page, key);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "post",
            url: "{{ url('/permission_assigner') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                role: roleName,
                page: page,
                key: key,
                value: val
            },
            success: function() {
                var test_value = "désactivé ";
                if (val == true) {
                    test_value = "activé";
                } else {
                    test_value = "désactivé "
                }
                var key_text = "";
                switch (key) {
                    case 'read':
                        key_text = "Accéder a ";
                        break;
                    case 'delete':
                        key_text = "Supprimer";
                        break;
                    case 'update':
                        key_text = "Modifier";
                        break;
                    case 'create':
                        key_text = "Créer";
                        break;


                }

                var message = 'La Permission de ' + key_text + '  la page ' + page + ' est ' + test_value;
               
                toastr.success("pour le role " + roleName + " !", message, {
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    positionClass: "toast-bottom-right",
                    progressBar: !0,
                    showDuration: 300
                });

            },
            error: function(err) {
                console.log(err);
            }
        });
    });
});
   </script>
  