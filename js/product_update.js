

$(document).ready(function() {

 
  
    $("#submit-all").click(function(e) {
        

         
            var titre =  $("#titre").val();
            var id =$("#id").val();
 
         
            
    
            var ajaxurl = '/product/updateproduct';
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
    
    
            $.ajax({
                url: ajaxurl,
                data: {
                    designation: titre,

                  id:id
                },
                type: 'post',
                dataType: 'json',
                success: function(data) {
    
                  console.log(data)
    
                   if(data.etat == false){
                    var alert1 = "<div class='alert alert-card alert-danger' role='alert'>";
                    alert1 += " <strong class='text-capitalize'>avertissement!</strong> "+data.text+"";
                    alert1 += " <button type='button' class='close' data-dismiss='alert' aria-label='Close'>"
                    alert1 += "  <span aria-hidden='true'>×</span></button></div>"
                    $("#msg").empty().append(alert1);
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                   }
                   if(data.etat == true){
                    window.location.href = '/product';
                   }
                    
    
                },
                error: function(data) {
    
    
                }
            });
   

       

    });




    




});