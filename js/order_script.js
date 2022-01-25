function validateForm() {

    
    var tableProductLength = $("#table_product tbody tr").length;

    if(tableProductLength == 0){
        toastr.info("il faut choisir au mois un produit", {
            progressBar: !0,
            positionClass: "toast-bottom-right",
            showDuration: 200
        });

        return false;

    }
 
    for (x = 0; x < tableProductLength; x++) {
        var tr = $("#table_product tbody tr")[x];
        var count = $(tr).attr('id');
        count = count.substring(3);
       var val_quantite =  $("#quantite" + count).val();
          if(val_quantite <= 0.0 && val_quantite){
              
           
            toastr.info(" etre superieure de 0", "La valeur de quantite doit", {
                progressBar: !0,
                positionClass: "toast-bottom-right",
                showDuration: 200
            });
           return false;
          }
          
      
    } 


    var date =   $("#picker3").val();

    if(date == '' ){

        toastr.info("La Date de commande", "Veuillez choisir ", {
            progressBar: !0,
            positionClass: "toast-bottom-right",
            showDuration: 200
        });
        return false;


    }




}


function calcul_total(row) {

   var new_price =  $("#price" + row).html();
   var new_quantite =  $("#quantite" + row).val();
    
    var total = Number(new_price) * Number(new_quantite);

     total= total.toFixed(2);
             

                    

    $("#total_product" + row).html(total);
    $("#total_productValue" + row).val(total);




}


var tableLength = 1;
var tableLength_2 = 1;
var count = 1;
var count_2 = 1;













function removeRow(e,row) {

    e.preventDefault();

    $('html,body').animate({
        scrollTop: 9999
    }, 'slow');
    document.getElementById("row" + row).remove();
    tableLength--;



}

function removeRow_table(e,row) {

    e.preventDefault();

    $('html,body').animate({
        scrollTop: 9999
    }, 'slow');
    document.getElementById("row_" + row).remove();
    tableLength_2--;


}


function resetOrderForm() {
    $('html,body').animate({
        scrollTop: 9999
    }, 'slow');

	$("#FormOrder")[0].reset();

} 


$(document).ready(function() {

      const d = new Date();
      let year = d.getFullYear();
    
        $("#date_system").val(year);


    

    

     $(document).on("click", ".prevent-default" , function() {
      e.preventDefault();
     });


    $("#arrow-down").click(function(e) { 
        
        e.preventDefault();
 
        $(".table-product").toggleClass("active");
     });


     $(document).on("change", ".js-example-basic-single" , function() {
        $("select.js-example-basic-single option[value='" + $(this).data('index') + "']").prop('disabled', false);
        $(this).data('index', this.value);
        $("select.js-example-basic-single option[value='" + this.value + "']:not([value=''])").prop('disabled', true);
        $(this).find("option[value='" + this.value + "']:not([value=''])").prop('disabled', false);
     });




    $(".btn-add-n").click(function(e) {



        e.preventDefault();

        $('html,body').animate({
            scrollTop: 9999
        }, 'slow');


   
        count_2++;

        

        var add_row = '<tr id=row_' + count_2 + '  >';

  


        add_row += '<td><input type="text" name="product[]"  required>';

  
        add_row += '</td>';
       

        add_row += '<td>  ';
        add_row += '<input type="text" name="unite[]" required>';
        add_row += ' </td>';
        add_row += '<td>  ';
        add_row += '<input type="number" name="quantity[]" required>';
        add_row += ' </td>';
        add_row += '<td> <input type="number" name="prix[]" required> </td>';

        add_row += ' <td><a href="" class="prevent-default" onClick="removeRow_table(event,' + count_2 + ')" ><i class="i-Close-Window text-19 text-danger font-weight-700""></i></a></td></tr>';
            



        if (tableLength_2 > 0) {

            $("#table_product-n tbody tr:last").after(add_row);
        }
        if (tableLength_2 == 0) {

            $("#table_product-n tbody ").append(add_row);
        }
        tableLength_2++;




    

    });



    $(".btn-add").click(function(e) {



        e.preventDefault();


        $('html,body').animate({
            scrollTop: 9999
        }, 'slow');

        var ajaxurl = '/product/getproduct';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            url: ajaxurl,
            type: 'get',
            dataType: 'json',
            success: function(data) {

                len = data['products'].length;
                count++;

                
 
                var add_row = '<tr id=row' + count + '  >';


                add_row += '<td><select   class="    form-control input-product" style="width: 100%" name="product[]" required>';
                add_row += '<option  value="">Selectionner le produit</option>';
                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                      
                        add_row += "<option  value='"+data["products"][i].designation+"'>"+data["products"][i].designation	+"</option>";

                    }
                }
                add_row += '</select></td>';

                add_row += '<td>   <input type="text" name="unite[]" required> ';

                add_row += ' </td> ';
                add_row += '<td>   <input type="number" name="quantity[]" required> ';

                add_row += ' </td> ';



                add_row += ' <td>    <input type="number" name="prix[]" required> </td>';
                add_row += ' <td><a href="" onClick="removeRow(event,'+count+')" ><i class="i-Close-Window text-19 text-danger font-weight-700 prevent-default"></i></a> </td></tr>';
                    



                if (tableLength > 0) {

                    $("#table_product tbody tr:last").after(add_row);
                }
                if (tableLength == 0) {

                    $("#table_product tbody ").append(add_row);
                }
                tableLength++;

                $('.js-example-basic-single').select2({
                    theme: "classic"
                });

                $(".js-example-basic-single").map(function() {
               
                    if(this.value != null){
                  
               
                       $(".js-example-basic-single option[value='" + this.value + "']:not([value=''])").prop('disabled', true);
                       
                    }
                  
               }).get();

           

               
                

            },
            error: function(data) {


            }
        });

    });




    $(window).on("load", function() {
        
        $('.js-example-basic-single').select2({
            theme: "classic"
        });
        $('.js-client-dropdown').select2({
            theme: "classic"
        });
        
        
     
    });
    




});