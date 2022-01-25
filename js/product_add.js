$(document).ready(function() {




  $(document).on("keyup", ".control_input", function() {

      var length = $(this).val().length;

      var check_price = $(this).attr('id');

      check_price

      if (check_price == "prix") {
          $(this).next().next().removeClass("display_input");
          $(this).removeClass("invalid");

      }


      if (length > 0) {

          $(this).next().removeClass("display_input");
          $(this).removeClass("invalid");

      }

      if (length == 0) {

          $(this).next().addClass("display_input");
          $(this).addeClass("invalid");

      }



  });



  




  $("#submit-all").click(function(e) {


    

      $(".form-control").addClass("control_input");


      var designation = $("#designation").val();

     


      if (designation == "") {
          $("#designation").next().addClass("display_input");
          $("#designation").addClass("invalid");


      }


  
      
        

          var ajaxurl = '/product/store';
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
           });
          $.ajax({
              
              url: ajaxurl,
              data: {
                designation: designation,
              },
              type: 'post',
              dataType: 'json',
              success: function(data) {

                  if (data.etat == false) {
                      $("html, body").animate({
                          scrollTop: 0
                      }, "slow");
                     
                  }
                  if (data.etat == true) {
                      window.location.href = '/product';
                  }
              },
              error: function(data) {
              }
          });
      
  });
});