$(document).ready(function () {

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });





    function fill_input_client(){
        $.ajax({
            url:"/g_visites/visites/clients",
            type:"GET",
    
            success:function(data)
            {
    
                var response = JSON.stringify(data);
    
                $.each(JSON.parse(response), function() {
    
                    console.log(this.denomination);
              
                        $("#input_client").append($("<option     />").val(this.denomination).text(this.denomination));
      
                });
      
            }
        })
    }



    function update_etat(event){

        Swal.fire({
            title: "Modifier l'état de la visite",
            showCancelButton: true  ,
            cancelButtonText: "Annuler",
            html:
            '<select id="input_etat_up" class="swal2-input"  placeholder="Etat"><option value="" >Etat</option><option value="effectue">effectué</option><option value="non effectue">non effectué</option></select>',
             preConfirm: function() {

                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');

     
                var title = event.title;
                var adresse = event.adresse;
                var collaborateur = event.collaborateur;
                var etat = event.etat;
                var id = event.id;
               
               return new Promise(function(resolve) {

                        // Validate input
                    if ( $('#input_etat_up').val() == '' ) {
                        swal.showValidationMessage("Veuillez remplir tous les champs obligatoires"); 
                        $('.swal2-confirm').removeAttr("disabled")
                        $('.swal2-cancel').removeAttr("disabled")
                    } else {
                        swal.resetValidationMessage(); // Reset the validation message.
                        resolve([   


                       
                            
                       
                        
                            $.ajax({
                                url:"/g_visites/visites/action",
                                type:"POST",
                                data:{
                                    title: title,
                                    adresse: adresse,
                                    collaborateur: collaborateur,
                                    etat:   $('#input_etat_up').val(),
                                    start: start,
                                    end: end,
                                    id: id,
                                    type: 'update'
                                },
                                success:function(response)
                                {
                                    calendar.fullCalendar('refetchEvents');
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'enregistré avec succes',
                                        showConfirmButton: false,
                                        timer: 1500
                                      })
                                }
                            })
                                    






                        ]);
                    }
               
              });
             }
             }).then(function(result) {
            swal(JSON.stringify(result));
            })
 
    }

    var calendar = $('#calendar').fullCalendar({
        editable:true,
        header:{
            left:'prev,next today',
            center:'title',
            right:'month,agendaWeek,agendaDay'
        },
        lang: 'fr',
        events:'/g_visites/visites',
        selectable:true,
        selectHelper: true,
        select:function(start, end, allDay)
        {  
                fill_input_client();
                Swal.fire({
                    title: 'Créer une nouvelle visite',
                    showCancelButton: true  ,
                    cancelButtonText: "Annuler",
              
                    html:
                    '<select id="input_client" class="swal2-input" autofocus placeholder="Client"><option value="">Client</option></select>' +
                    '<input id="input_collaborateur" class="swal2-input" placeholder="Collaborateur">' +
                    '<input id="input_adresse" class="swal2-input" placeholder="Adresse">'+
                    '<select id="input_etat" class="swal2-input" autofocus placeholder="Etat"><option value="" >Etat</option><option value="effectue">effectué</option><option value="non effectue">non effectué</option></select>',
                     preConfirm: function() {

                        start = moment(start).format('YYYY-MM-DD HH:mm:00');
                        end = moment(end).format('YYYY-MM-DD HH:mm:00');
                       
                       return new Promise(function(resolve) {

                        console.log($('#input_client').val());
                        console.log($('#input_collaborateur').val());
                        console.log($('#input_adresse').val());

                                // Validate input
                            if ($('#input_client').val() == '' || $('#input_collaborateur').val() == '' || $('#input_adresse').val() == '' || $('#input_etat').val() == '' ) {
                                swal.showValidationMessage("Veuillez remplir tous les champs obligatoires"); 
                                $('.swal2-confirm').removeAttr("disabled")
                                $('.swal2-cancel').removeAttr("disabled")
                            } else {
                                swal.resetValidationMessage(); // Reset the validation message.
                                resolve([   
                                    
                               
                                
                                                $.ajax({
                                                    url:"/g_visites/visites/action",
                                                    type:"POST",
                                                    data:{
                                                        title: $('#input_client').val(),
                                                        adresse:  $('#input_adresse').val(),
                                                        collaborateur:  $('#input_collaborateur').val(),
                                                        etat:  $('#input_etat').val(),
                                                        start: start,
                                                        end: end,
                                                        type: 'add'
                                                    },
                                                    success:function(data)
                                                    {
                                                        calendar.fullCalendar('refetchEvents');
                                                        Swal.fire({
                                                            position: 'center',
                                                            icon: 'success',
                                                            title: 'Ajouter avec succes',
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                          })
                                                    }
                                                })
                                            






                                ]);
                            }
                       
                      });
                     }
                     }).then(function(result) {
                    swal(JSON.stringify(result));
                    })
                    


          
        },
        editable:true,
        eventResize: function(event, delta)
        {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var title = event.title;
            var id = event.id;

            console.log(title)
            $.ajax({
                url:"/g_visites/full-calender/action",
                type:"POST",
                data:{
                    title: title,
                    start: start,
                    end: end,
                    id: id,
                    type: 'update'
                },
                success:function(response)
                {
                    calendar.fullCalendar('refetchEvents');
                    alert("Event Updated Successfully");
                }
            })
        },
        eventDrop: function(event, delta)
        {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var title = event.title;
            var adresse = event.adresse;
            var collaborateur = event.collaborateur;
            var etat = event.etat;
            var id = event.id;
  
            $.ajax({
                url:"/g_visites/visites/action",
                type:"POST",
                data:{
                    title: title,
                    adresse: adresse,
                    collaborateur: collaborateur,
                    etat:  etat,
                    start: start,
                    end: end,
                    id: id,
                    type: 'update'
                },
                success:function(response)
                {
                    calendar.fullCalendar('refetchEvents');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'enregistré avec succes',
                        showConfirmButton: false,
                        timer: 1500
                      })
                }
            })
        },

        eventClick:function(event)
        {

            Swal.fire({
                title: 'Action :',
                text: "Choisissez votre action pour cette visite !",
                icon: 'warning',
                closeOnConfirm: false,
                closeOnCancel: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'supprimez',
                cancelButtonText: "Annuler",
                showDenyButton: true,
                denyButtonText: `Modifier l'Etat`,
              }).then((result) => {
                   var id = event.id;
       

                  if(result.value == false){
                       swal.close()
                      update_etat(event);
                  }
                 
                if (result.value == true) {
                 
               
                    $.ajax({
                        url:"/g_visites/visites/action",
                        type:"POST",
                        data:{
                            id:id,
                            type:"delete"
                        },
                        success:function(response)
                        {
                            calendar.fullCalendar('refetchEvents');
                           
                        }
                    })
                    
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Supprimer avec succes',
                        showConfirmButton: false,
                        timer: 1500
                      })
                }
              })


            
        },
        eventRender: function(eventObj, $el) {
        
            $el.popover({
              title: 'Les informations de la visite',
              content: "Collaborateur : "+eventObj.collaborateur+" <br /> Adresse &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: "+eventObj.adresse+" <br /> Etat   &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: "+eventObj.etat+"",
 
              html: true,
              trigger: 'hover',
              placement: 'top',
              container: 'body',
         
            });


          
          },
    });

});