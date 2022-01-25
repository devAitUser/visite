$(document).ready(function() {



        $('.js-select-project').select2( {
            theme: "classic"
        });
    


    $(".update").click(function(e) {

        var id_user = $("#id_user").val();
        var nom = $("#nom").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var role_id = $("#role_id").val();
        var type_user = $("#type_user").val();
        var project_id = $('#project_id').val(); 

      



        var ajaxurl = '/g_visites/update_user';



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            url: ajaxurl,
            data: {
                id: id_user,
                nom: nom,
                email: email,
                password: password,
                role_id: role_id,
                project_id :project_id ,
                type_user: type_user,
            },
            type: 'post',
            dataType: 'json',
            success: function(data) {

                console.log(data);


                if (data.redirect_home == true) {
                    window.location.href = '/';
                }


                if (data.redirect_users == true) {
                    window.location.href = '/users';
                }

                if (data.etat == false) {
                    var alert1 = "<div class='alert alert-card alert-danger' role='alert'>";
                    alert1 += " <strong class='text-capitalize'>avertissement!</strong> le champs <strong>" + data.text + "</strong>";
                    alert1 += " est obligatoire";
                    alert1 += " <button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
                    alert1 += "  <span aria-hidden='true'>×</span></button></div>"
                    $("#msg").empty().append(alert1);

                }



            },
            error: function(data) {


            }
        });



    });


  



});