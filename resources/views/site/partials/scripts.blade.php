<!-- jquery -->
<script src="{{ asset('frontend') }}/libs/jquery/jquery.min.js"></script>
<!-- jquery Validate -->
<script src="{{ asset('frontend') }}/libs/jquery-validation/jquery.validate.min.js"></script>
<!-- popper js -->
<script src="{{ asset('frontend') }}/libs/popper/popper.min.js"></script>
<!-- bootstrap js -->
<script src="{{ asset('frontend') }}/libs/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
<!-- owlcarousel js -->
<script src="{{ asset('frontend') }}/libs/owlcarousel2/owl.carousel.min.js"></script>
<!--inview js code-->
<script src="{{ asset('frontend') }}/libs/jquery.inview/jquery.inview.min.js"></script>
<!--CountTo js code-->
<script src="{{ asset('frontend') }}/libs/jquery.countTo/jquery.countTo.js"></script>
<!-- Animated Headlines js code-->
<script src="{{ asset('frontend') }}/libs/animated-headlines/animated-headlines.js"></script>
<!-- mb.YTPlayer js code-->
<script src="{{ asset('frontend') }}/libs/mb.YTPlayer/jquery.mb.YTPlayer.min.js"></script>
<!--internal js-->
<script src="{{ asset('frontend') }}/js/internal.js"></script>
<!--sticky header js-->
<script src="{{ asset('frontend') }}/js/sticky.js"></script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });    

    /* Add to Cart */
    function addToCart(product_id, attribute_id){        
        $.post( "cart/store", { 
            product_id: product_id,
            attribute_id: attribute_id
        })
        .done(function( data ) {
            data = JSON.parse(data);            
            if(data.status == 'success'){
                //toast
                $('#totalItems_desktop').html(data.total_items);
                $('#totalItems_mob').html(data.total_items);
            }   
            if(data.total_items){
                $(".shop-cart").removeClass("disabledbutton"); 
            }      

        });
    } 
    /* Add to Cart */   
    
    /*Product Quantity Plus/Minus Start and send to cart */
        function updateAddtoCart(cart_id, id){

            if(id.includes('add')){            
                var $qty = $('#'+id).closest('p').find('.qty');            
                var currentVal = parseInt($qty.val());            
                $qty.val(currentVal + 1); 
            }
            else if(id.includes('minus')){
                var $qty = $('#'+id).closest('p').find('.qty');            
                var currentVal = parseInt($qty.val());
                if(currentVal > 1){           
                  $qty.val(currentVal - 1); 
                }
            }           

            $.post( "/cart/update", { 
            cart_id: cart_id,
            product_quantity: $qty.val()
            })
            .done(function( data ) {
                data = JSON.parse(data);                             
                if(data.status == 'success'){                    
                    //toast
                     $('#totalItems_desktop').html(data.total_items);
                     $('#totalItems_mob').html(data.total_items);
                     
                    // finding the rowno from the id such add1, add2, minus1 etc.            
                     var row = id.substring(id.length - 1); //Displaying the last character                     
                     $('#price'+row).html(data.total_unit_price)
                     $('#sub-total-tk').html(data.sub_total);
                   // location.reload(); 
                }
              }); 
        }
   
    /*Product Quantity Plus/Minus End */


    function cartClose(cartId, delBtnId ){
        var parent = $('#'+ delBtnId).parent(); //getting the td of the del button
        
        $.post( "/cart/delete", { 
            cart_id: cartId            
            })
            .done(function( data ) {
                data = JSON.parse(data);                             
                if(data.status == 'success'){
                    //toast
                     $('#totalItems_desktop').html(data.total_items);                     
                     $('#totalItems_mob').html(data.total_items);                    
                     $('#cart-total').html(data.total_carts); 
                     $('#sub-total-tk').html(data.sub_total);
                    
                     // not to reload the page, just removing the row from DOM
                        parent.slideUp(300, function () {
                            parent.closest("tr").remove();
                        });                
                }
              }); 

    }   
   

</script>