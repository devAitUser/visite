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


    subAmount();


}


var tableLength = 1;
var count = 1;



function subAmount() {
    var tableProductLength = $("#table_product tbody tr").length;
    var totalSubAmount = 0;

    for (x = 0; x < tableProductLength; x++) {
        var tr = $("#table_product tbody tr")[x];
        var count = $(tr).attr('id');
    
        count = count.substring(3);

        console.log(count)

        totalSubAmount = Number(totalSubAmount) + Number($("#total_product" + count).html());
       
    } // /for

    totalSubAmount = totalSubAmount.toFixed(2);

   

   

    // sub total
    $("#subTotal").html(totalSubAmount);
    $("#subTotalValue").val(totalSubAmount);


    // vat
    var vat = (Number($("#subTotal").html()) / 100) * 20;
    vat = vat.toFixed(2);
    $("#tva").html(vat);
    $("#tvaValue").val(vat);


    // total amount
    var totalAmount = (Number($("#subTotal").html()) + Number($("#tva").html()));
    totalAmount = totalAmount.toFixed(2);
    $("#total").html(totalAmount);

    $("#totalValue").val(totalAmount);





}




function getProductData(row = null) {

    var productId = $("#productName" + row).val();



    if (productId == "") {

        $("#rate" + row).val("");
        $("#quantite" + row).val("");
        $("#total" + row).val("");

        subAmount();




    } else {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/product/getproduct_data',
            data: {
                productId: productId
            },
            type: 'post',
            dataType: 'json',
            success: function(data) {

                
                var price = data.product.prix;
                var quantite = data.product.quantite;

              
              

                $("#price" + row).html(price);
                $("#priceValue" + row).val(price);
                $("#quantite" + row).val(quantite);

                
                $("#quantite" + row).val();
                $("#quantite" + row).attr({
                    "max" : data.product.quantite,        
                    "min" : 0         
                 });

                var total = Number(data.product.prix) * Number(data.product.quantite);
             
              
                total= total.toFixed(2);

                $("#total_product" + row).html(total);
                $("#total_productValue" + row).val(total);
               

                subAmount();

            },
            error: function(data) {


            }
        });



    }




}

function getphone() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });

    var clientId = $("#valueclient").val();

    $.ajax({
        url: '/getphone',
        data: {
            clientId: clientId
        },
        type: 'post',
        dataType: 'json',
        success: function(data) {
            
            $("#phone_client").val(data.client.telephone);
     

        },
        error: function(data) {


        }
    });

}

function removeRow(e,row) {

    e.preventDefault();

    $('html,body').animate({
        scrollTop: 9999
    }, 'slow');
    document.getElementById("row" + row).remove();
    tableLength--;
    subAmount();

}


function resetOrderForm() {
    $('html,body').animate({
        scrollTop: 9999
    }, 'slow');

	$("#FormOrder")[0].reset();

} 


$(document).ready(function() {


    $(".valide_order,.reject_order").click(function(){

        var button_attr =$(this).attr('data-key');
        var action = '';
        var ajax_url = '/validation_commande';

        if(button_attr ==  "valider" ){
            action = 'valider';
        }

        if(button_attr ==  "reject" ){
            action = 'reject';
        }


        var id_order =$("#id_order").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });



        $.ajax({
            url: ajax_url,
            type: 'post',
            data: {

                id: id_order,
                action :action 
              
            },
            dataType: 'json',
            success: function(data) {

           

                if(data.etat == true){

                    window.location.href = "/order/" + data.id + "/edit"
                }

               
            },
            error: function(data) {

                


            }
        });

        
      });

    

     $(document).on("click", ".prevent-default" , function() {
      e.preventDefault();
     });


    $("#arrow-down").click(function(e) { 
        
        e.preventDefault();
 
        $(".table-product").toggleClass("active");
     });
    

 
    $(document).on("change", "select.js-example-basic-single" , function() {
        $("select.js-example-basic-single option[value='" + $(this).data('index') + "']").prop('disabled', false);
        $(this).data('index', this.value);
        $("select.js-example-basic-single option[value='" + this.value + "']:not([value=''])").prop('disabled', true);
        $(this).find("option[value='" + this.value + "']:not([value=''])").prop('disabled', false);
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

                var count_tr = $("#table_product tbody tr").length + 1;

                

                var add_row = '<tr id=row' + count_tr + '><td><select id="productName' + count_tr + '" onchange="getProductData(' + count_tr + ')" class="js-example-basic-single form-control input-product" style="width: 100%" name="product[]" required>';
                add_row += '<option  value="">Selectionner le produit</option>';
                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                        console.log(data['products'][i].titre);

                        add_row += "<option  value='"+data["products"][i].id+"'>"+data["products"][i].titre+"</option>";



                    }
                }
                add_row += '</select></td>';
                    add_row += '<td>  <div class="d-flex "> <div id="price'+count_tr+'"> 0 </div>  <span class="text-muted pl-1">DH</span>  </div> </td>';
                add_row += ' <input type="hidden" id="priceValue'+count_tr+'" name="rate[]" class="form-control input_or" required>';
                add_row += '<td><input type="number" onclick="calcul_total('+count_tr+')" name="quantite[]" id="quantite' + count_tr + '" name="" class="form-control input_or" required></td>';
                add_row += '<td> <div class="d-flex "> <div id="total_product'+count_tr+'"> 0.00  </div>  <span class="text-muted pl-1">DH</span></div></div></td>';
                add_row += ' <input type="hidden" id="total_productValue'+count_tr+'" name="totalp[]" class="form-control input_or" required> ';
                add_row += ' <td><button class="btn btn-outline-secondary float-right" onClick="removeRow(event,' + count_tr + ')" >Supprimer</button></td></tr>';
                    



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
                        $("select.js-example-basic-single option[value='" + this.value + "']:not([value=''])").prop('disabled', true);
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
        
     
    });
    




});