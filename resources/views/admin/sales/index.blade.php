@extends('admin.app')

@section('title')
{{-- Getting $pageTitle from BaseController setPageTitle()--}}
{{ $pageTitle }}
@endsection

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-paw"></i>&nbsp;{{ $pageTitle }}</h1>
        <p>{{ $subTitle }}</p>
    </div>
</div>
@include('admin.partials.flash')

<div class="row justify-content-center">
    <div class="col-sm-12">
        <div class="tile">
            <div class="tile-body">
                {{-- <h3 class="tile-title">{{ __('Sales') }}</h3> --}}
                <!-- For defining autocomplete -->

                <div class="row">
                    <div class="col-md-8 text-center">
                        <div class="form-group row mt-2">
                            <label class="col-md-4 col-form-label font-weight-bold text-right text-uppercase">Search
                                Product</label>
                            <div class="col-md-6 text-left">
                                <input type="text" class="form-control" id="product_search" name="product_search"
                                    placeholder="Find Foods">
                            </div>
                        </div>
                        {{-- to display cart message --}}
                        <div class="form-group row mt-2">
                            <div class="col-md-12 text-center" style="margin-bottom:-10px;" id="message">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <table class="table table-bordered" id="tbl-sale-cart">
                                    <thead>
                                        <tr>
                                            <th class="text-left pl-3"> Food Name </th>
                                            <th class="text-center"> Price </th>
                                            <th class="text-center"> Qty </th>
                                            <th class="text-center"> Subtotal </th>
                                            <th style="min-width:50px;" class="text-center text-danger"><i
                                                    class="fa fa-bolt"> </i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; $total_taka = 0; @endphp
                                        @foreach(App\Models\Sale::where('admin_id', Auth::id())->where('ordersale_id',
                                        NULL)->get() as $sale)
                                        <tr>
                                            <td class="text-left pl-3">{{ $sale->product_name }}</td>
                                            <td class="text-center">{{ round($sale->unit_price,0) }}</td>
                                            {{-- <td class="text-center">{{ $sale->product_quantity }}</td> --}}
                                            <td>
                                                <p class="qtypara">
                                                    <span id="minus{{$i}}" class="minus"
                                                        onclick="updateAddtoSale({{ $sale->id }}, 'minus{{$i}}' )"><i
                                                            class="fa fa-minus" aria-hidden="true"></i></span>
                                                    <input type="text" name="product_quantity" id="input-quantity{{$i}}"
                                                        value="{{ $sale->product_quantity  }}" size="2"
                                                        class="form-control qty" readonly />
                                                    <span id="add{{$i}}" class="add"
                                                        onclick="updateAddtoSale({{ $sale->id }}, 'add{{$i}}' )"><i
                                                            class="fa fa-plus" aria-hidden="true"></i></span>
                                                </p>
                                            </td>
                                            <td class="text-center" id="price{{$i}}">
                                                {{ round($sale->product_quantity * $sale->unit_price,0) }}</td>
                                            @php $total_taka += $sale->product_quantity * $sale->unit_price @endphp
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-danger" id="cart-close{{$i}}"
                                                    onclick="cartClose({{ $sale->id }}, 'cart-close{{$i}}')"><i
                                                        class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-sm-12" style="visibility:{{ $total_taka ? 'visible': 'hidden' }};"
                                        id="total">
                                        @if(config('settings.tax_percentage'))
                                        <h5 class="text-right pb-3  pr-5 border-bottom">Subtotal :
                                            <span id="sub-total-tk">{{ $total_taka }}</span><span
                                                class="pr-5 pl-1">{{ config('settings.currency_symbol') }}</span>
                                        </h5>
                                        <h5 class="text-right pb-3 pt-1 pr-5 border-bottom">Vat :
                                            <span
                                                id="vat-percent">{{ $total_taka * (config('settings.tax_percentage')/100) }}</span><span
                                                class="pr-5 pl-1">{{ config('settings.currency_symbol') }}</span>
                                        </h5>
                                        @endif
                                        <h5 class="text-right pb-3 pt-1 pr-5 border-bottom">Order Total :
                                            <span
                                                id="total-tk">{{ $total_taka + ($total_taka * (config('settings.tax_percentage')/100))}}</span><span
                                                class="pr-5 pl-1">{{ config('settings.currency_symbol') }}</span>
                                        </h5>
                                        <h5 class="text-right pb-2 pt-1 border-bottom" id="discount-blk">
                                            <label style="padding-right:3.9em" id="discount-lbl"><input type="checkbox"
                                                    class="radio-inline" name="dicount" id="discount_check"
                                                    onclick="discountCheck()"> Discount :
                                            </label>
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control" id="discount_reference"
                                                    placeholder="Reference Name (Required)" name="discount_reference"
                                                    style="display:none;">
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control" id="discount"
                                                    placeholder="Amount (Required)" name="discount"
                                                    style="display:none;">
                                            </div>
                                        </h5>
                                        <h5 class="text-right pb-3 pt-1 pr-5 border-bottom">Due Amount:
                                            <span
                                                id="due-tk">{{ $total_taka + $total_taka * (config('settings.tax_percentage')/100)  }}</span><span
                                                class="pr-5 pl-1">{{ config('settings.currency_symbol') }}</span>
                                        </h5>
                                        <div class="text-right pb-2 border-bottom font-weight-normal"
                                            style="padding-right:6.8em;">
                                            <select name="payment-method" id="payment-method"
                                                class="form-check-inline pr-5 discount-w" dir="rtl">
                                                <option></option>
                                                <option value="cash">Cash</option>
                                                <option value="card">Card</option>
                                                <option value="mobile_banking">Mobile Banking</option>
                                            </select>
                                        </div>
                                        <h5 class="text-right pb-2 border-bottom font-weight-normal">

                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <!--pos printing-->

                        <div class="border px-4 rounded pb-4 mb-4" style="border-color:rgb(182, 182, 182);">
                            <h4 class="text-center mt-3 mb-4">Customer Print Receipt</h4>

                            <div class="text-center">
                                <label class="checkbox">
                                    <input type="checkbox" id="useDefaultPrinter" /> <strong>Print to
                                        Default
                                        printer</strong>
                                </label>
                                <br>
                                <div id="installedPrinters">
                                    <label for="installedPrinterName">or Select an installed Printer:</label><br>
                                    <select name="installedPrinterName" id="installedPrinterName"
                                        class="form-control mt-1 mb-2"></select>
                                </div>

                                <button type="button" onclick="print();"
                                    class="btn btn-primary text-center text-uppercase"
                                    style="display:block; width:100%;" {{ $order_id ? '' : 'disabled' }}>Print
                                    Receipt</button>
                            </div>
                        </div>

                        <!--end of pos print using javascript-->
                        <form method="POST" action="{{ route('admin.sales.orderplace') }}">
                            @csrf
                            <input type="hidden" id="order_discount" name="order_discount" value="">
                            <input type="hidden" id="order_discount_reference" name="order_discount_reference" value="">
                            <input type="hidden" id="payment_method" name="payment_method" value="">
                            {{-- <input type="hidden" class="reference" name="discount_reference"> --}}
                            <div class="border px-4 rounded" style="border-color:rgb(182, 182, 182);">
                                <h4 class="text-center mt-3 mb-4">Customer Details</h4>
                                <div class="form-group my-2">
                                    <input type="text" class="form-control @error('order_tableNo') is-invalid @enderror"
                                        id="order_tableNo" placeholder="Enter Order Table No (required)"
                                        name="order_tableNo" required>
                                    @error('order_tableNo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group my-2">
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                        id="customer_name" placeholder="Customer Name" name="customer_name">

                                    @error('customer_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <div class="form-group my-2">
                                    <input type="text"
                                        class="form-control @error('customer_mobile') is-invalid @enderror"
                                        id="customer_mobile" placeholder="Customer Phone No" name="customer_mobile"
                                        maxlength="13">

                                    @error('customer_mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group my-2">
                                    <textarea class="form-control" id="customer_address" rows="3"
                                        name="customer_address" placeholder="Customer Address"></textarea>
                                </div>

                                <div class="form-group my-2">
                                    <textarea class="form-control" id="customer_notes" rows="3" name="customer_notes"
                                        placeholder="Customer Notes"></textarea>
                                </div>
                                <div class="form-group mt-2 mb-4">
                                    <button type="submit" class="btn btn-primary text-uppercase"
                                        style="display:block; width:100%;" id="submit">Place
                                        Order </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('backend') }}/js/pos/zip.js"></script>
<script src="{{ asset('backend') }}/js/pos/zip-ext.js"></script>
<script src="{{ asset('backend') }}/js/pos/deflate.js"></script>
<script src="{{ asset('backend') }}/js/pos/JSPrintManager.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>
<script type="text/javascript">
    // getting CSRF Token from meta tag
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){  
        
     // POS system starts here
     // Initialize jQuery UI autocomplete on #product_search field.
      $("#product_search").autocomplete({
        //Using source option to send AJAX post request to route('employees.getEmployees') to fetch data
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url:"{{ route('admin.sales.getfoods') }}",
            type: 'post',
            dataType: "json",
            // passing CSRF_TOKEN along with search value in the data
            data: {
               _token: CSRF_TOKEN,
               search: request.term
            },
            //On successful callback pass response in response() function.
            success: function( data ) {
               response( data );
            }
          });
        },
        // Using select option to display selected option label in the #product_search
        select: function (event, ui) {
           // Set selection           
           $('#product_search').val(ui.item.label); // display the selected text
        //  calling to add to cart function addToSale  
           addToSale(ui.item.label, ui.item.value);
           return false;
        }
      });

      function addToSale(foodName, foodId){
        $.post("{{ route('admin.sales.addtosales') }}", {        
            _token: CSRF_TOKEN,
            foodName: foodName,
            foodId: foodId
        }).done(function(data) {
            data = JSON.parse(data);
            if(data.status == "success") {
                    var i = document.getElementById("tbl-sale-cart").rows.length;
                    tableBody = $("table tbody"); 
                    markup = "<tr><td class='text-left pl-3'>"  + data.foodname + "</td>" + 
                    "<td class='text-center'>"  + Math.round(data.price) + "</td>" +                   
                    "<td><p class='qtypara'><span id='minus"+ i +"' class='minus' onclick='updateAddtoSale("+ data.id +", \"minus"+ i +"\")' >" +
                         "<i class='fa fa-minus' aria-hidden='true'></i></span>"+                                    
                         "<input type='text' name='product_quantity' id='input-quantity"+i+"' value="+ data.qty +" size= '2' class='form-control qty' readonly />" + "<span id='add"+i+"' class='add'" +
                                "onclick='updateAddtoSale("+ data.id +", \"add"+ i +"\")' >" +
                                "<i class='fa fa-plus' aria-hidden='true'></i></span></p></td>" +

                    "<td class='text-center' id='price"+i+"'>"  + data.price*data.qty + "</td>" +
                    "<td class='text-center'>"+ 
                        "<button class='btn btn-sm btn-danger' id='close" +i+
                        "' onclick='cartClose(" + data.id +", \"close"+ i + "\")' >" +
                                           "<i class='fa fa-trash'></i></button></td>"+ 
                    "</tr>"; 
                    tableBody.append(markup);
                    $('#total').css('visibility', 'visible');
                    if("{{ config('settings.tax_percentage') }}"){
                        $("#sub-total-tk").html(data.sub_total);
                        $("#vat-percent").html( data.sub_total * "{{ config('settings.tax_percentage')/100 }}");
                    }
                    $("#total-tk").html(data.sub_total + (data.sub_total * "{{ config('settings.tax_percentage')/100 }}") ); 
                    $('#due-tk').html((data.sub_total + (data.sub_total * "{{ config('settings.tax_percentage')/100 }}")) - $('#discount').val());
                }
                
            if(data.status == 'info'){
                message = '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +                
                            data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                           '<span aria-hidden="true">&times;</span></button></div>';                
                $('#message').html(message);
            }   
            
        });
        }

        $("#customer_mobile").autocomplete({
        //Using source option to send AJAX post request to route('employees.getEmployees') to fetch data
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url:"{{ route('admin.sales.customermobile') }}",
            type: 'post',
            dataType: "json",
            // passing CSRF_TOKEN along with search value in the data
            data: {
               _token: CSRF_TOKEN,
               search: request.term
            },
            //On successful callback pass response in response() function.
            success: function( data ) {
               response( data );               
            }
          });
        },
        // Using select option to display selected option label in the #product_search
        select: function (event, ui) {
           // Set selection           
           $('#customer_mobile').val(ui.item.label); // display the selected text           
           fillCustomerData(ui.item.label);
           return false;
        }
      });

      function fillCustomerData(customerMobile){
        $.post("{{ route('admin.sales.customerInfo') }}", {        
            _token: CSRF_TOKEN,
            mobile: customerMobile            
        }).done(function(data) { 
            $('#customer_name').val(data[0].customer_name);
            $('#customer_address').val(data[0].customer_address);        
            $('#customer_notes').val(data[0].customer_notes); 
        });
        }

        // pos system discount deduct from salescart order total.       
       $('#discount').on('input', function() {
            orderTotal = $('#total-tk').text();
            discount = $.trim($('#discount').val()); 
            dueAmount = orderTotal - discount;
            //setting due amount 
            $('#due-tk').text(dueAmount); 
            // setting discount data to order_discount form hidden input field
            $('#order_discount').val(discount);
        });

        // setting reference name for discount to order_discount_reference form hidden input field
        $('#discount_reference').on('input', function() {            
            $('#order_discount_reference').val($('#discount_reference').val());
        });

        // POS payment methods
        $('#payment-method').select2({
                placeholder: "Payment Methods",              
                multiple: false, 
                minimumResultsForSearch: -1,                        
        }); 
        // while submit cilck, validating the discount_reference field.
        // this discount and discount reference fields are not inside form    
        $('#submit').click(function(e){
            var isValid = true;

            //when discount field is not numeric.
            if(!$.isNumeric( $.trim( $('#discount').val() ) ) ){
                isValid = false;
                $('#discount').css({
                "border": "2px solid #007065",
                "background": "#e4f5f3"
                });                 

            }else{
                $('#discount').css({
                    "border": "",
                    "background": ""
                });
            }
            //when discount reference field is empty.
            if ($.trim($('#discount_reference').val()) == '' && $.trim($('#discount').val()) != '') {
                isValid = false;
                $('#discount_reference').css({
                    "border": "2px solid #007065",
                    "background": "#e4f5f3"
                });               
               
            }else{
                $('#discount_reference').css({
                    "border": "",
                    "background": ""
                });
            }
            //when both field is empty.
            if($.trim($('#discount_reference').val()) == '' && $.trim($('#discount').val()) == ''){
                isValid = false;
                $('#discount_reference').css({
                    "border": "2px solid #007065",
                    "background": "#e4f5f3"
                });  
                $('#discount').css({
                "border": "2px solid #007065",
                "background": "#e4f5f3"
                });   
            }else{

                $('#discount_reference').css({
                    "border": "",
                    "background": ""
                });
                $('#discount').css({
                    "border": "",
                    "background": ""
                });

            }      

            if (isValid == false)
                e.preventDefault();
        });

    });

     /*Product Quantity Plus/Minus Start and send to cart */
        function updateAddtoSale(sale_id, id) {
            if (id.includes("add")) {
                var $qty = $("#" + id)
                    .closest("p")
                    .find(".qty");
                var currentVal = parseInt($qty.val());
                $qty.val(currentVal + 1);
            } else if (id.includes("minus")) {
                var $qty = $("#" + id)
                    .closest("p")
                    .find(".qty");
                var currentVal = parseInt($qty.val());
                if (currentVal > 1) {
                    $qty.val(currentVal - 1);
                }
            }

            $.post("{{ route('admin.sales.saleCartUpdate') }}", {
                _token: CSRF_TOKEN,
                sale_id: sale_id,
                product_quantity: $qty.val()
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.status == "success") { 
                    // finding the rowno from the id such add1, add2, minus1 etc.
                    var row = id.substring(id.length - 1); //Displaying the last character                    
                    $("#price" + row).html(data.total_unit_price);
                    if("{{ config('settings.tax_percentage') }}"){
                        $("#sub-total-tk").html(data.sub_total);
                        $("#vat-percent").html( data.sub_total * "{{ config('settings.tax_percentage')/100 }}");
                    }
                    $("#total-tk").html(data.sub_total + (data.sub_total * "{{ config('settings.tax_percentage')/100 }}") ); 
                    $('#due-tk').html((data.sub_total + (data.sub_total * "{{ config('settings.tax_percentage')/100 }}")) - $('#discount').val());
                    // location.reload();
                }
            });
        }

        function cartClose(saleId, delBtnId) {
            var parent = $("#" + delBtnId).parent(); //getting the td of the del button
            $.post("{{ route('admin.sales.saleCartDelete') }}", {
                _token: CSRF_TOKEN,
                sale_id: saleId
            }).done(function(data) {
                data = JSON.parse(data);
                if (data.status == "success") {                 
                    // not to reload the page, just removing the row from DOM
                    if("{{ config('settings.tax_percentage') }}"){
                        $("#sub-total-tk").html(data.sub_total);
                        $("#vat-percent").html( data.sub_total * "{{ config('settings.tax_percentage')/100 }}");
                    }
                    $("#total-tk").html(data.sub_total + (data.sub_total * "{{ config('settings.tax_percentage')/100 }}") ); 
                    $('#due-tk').html((data.sub_total + (data.sub_total * "{{ config('settings.tax_percentage')/100 }}")) - $('#discount').val());

                    parent.slideUp(100, function() {
                        parent.closest("tr").remove();
                    });
                    if(!data.sub_total){
                        $('#total').css('visibility', 'hidden');
                    }
                }
            });
        }
        //pos system discount option is showing or hiding.
        function discountCheck(){             
            if($("#discount_check").prop("checked") == true) { 
                $('#discount-lbl').css('padding-right','0');
                $('.form-check-inline').addClass('discount-w');
                $('#discount_reference').show();
                $('#discount').show();  
                $('#discount-blk').removeClass('pt-1');
            }else{
                //when unchecked chkbox we set discount to null and due amount to order total.
                $('#discount-lbl').css('padding-right','3.9em');
                $('#discount_reference').removeAttr("style").hide();
                $('#discount').removeAttr("style").hide(); 
                $('.form-check-inline').removeClass('discount-w');                 
                $('#discount').val("");
                $('#due-tk').html($("#total-tk").html());  
                $('#discount-blk').addClass('pt-1');           
            }           
        }


    

  //POS PRINT RECEIPT : https://www.neodynamic.com/articles/How-to-print-raw-ESC-POS-commands-from-Javascript/
  
  //WebSocket settings
  JSPM.JSPrintManager.auto_reconnect = true;
    JSPM.JSPrintManager.start();
    JSPM.JSPrintManager.WS.onStatusChanged = function () {
        if (jspmWSStatus()) {
            //get client installed printers
            JSPM.JSPrintManager.getPrinters().then(function (myPrinters) {
                var options = '';
                for (var i = 0; i < myPrinters.length; i++) {
                    options += '<option>' + myPrinters[i] + '</option>';
                }
                $('#installedPrinterName').html(options);
            });
        }
    };
 
    //Check JSPM WebSocket status
    function jspmWSStatus() {
        if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open)
            return true;
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
            alert('JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm');
            return false;
        }
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked) {
            alert('JSPM has blocked this website!');
            return false;
        }
    }
 
    //Do printing...
    function print(o) {
        if (jspmWSStatus()) {
            //Create a ClientPrintJob
            var cpj = new JSPM.ClientPrintJob();
            //Set Printer type (Refer to the help, there many of them!)
            if ($('#useDefaultPrinter').prop('checked')) {
                cpj.clientPrinter = new JSPM.DefaultPrinter();
            } else {
                cpj.clientPrinter = new JSPM.InstalledPrinter($('#installedPrinterName').val());
            }
            //Set content to print...
            //Create ESP/POS commands for sample label
            var esc = '\x1B'; //ESC byte in hex notation
            var newLine = '\x0A'; //LF byte in hex notation            
            var cmds = esc + "@"; //Initializes the printer (ESC @)
            cmds += esc + '!' + '\x38'; //Emphasized + Double-height + Double-width mode selected (ESC ! (8 + 16 + 32)) 56 dec => 38 hex
            cmds += "{{ config('settings.site_name') }}"; //text to print site name
            cmds += "----------------------------------";
            cmds += newLine + newLine;
            cmds += esc + '!' + '\x00'; //Character font A selected (ESC ! 0)
            cmds += "{{ config('settings.contact_address') }}"; //text to print site address
            cmds += newLine;
            cmds += "Contact no: {{ config('settings.phone_no') }}";
            cmds += newLine;
            cmds += "Date: {{ date('d-M-Y h:i:s A') }}";
            cmds += newLine;
            cmds += "Customer order table no: {{ $order_id ? App\Models\Ordersale::find($order_id)->order_tableNo : ''}}"
            cmds += "----------------------------------";
            cmds += newLine + newLine;
            cmds += "#Item     #Qty     #Price     #subtotal";
            cmds += "----------------------------------";
            cmds += newLine;
            @if($order_id)
            @foreach(App\Models\Sale::where('ordersale_id', $order_id)->get() as $saleCart)
        
                cmds += ''+ "{{ $saleCart->product_name }}" + '   ' + "{{ $saleCart->product_quantity}}" + ' X ' + "{{ $saleCart->unit_price }}"
                cmds += newLine; 
                cmds += "{{ $saleCart->product_quantity *  $saleCart->unit_price }} "
                cmds += "----------------------------------";
                cmds += newLine;            
            
            @endforeach
            @endif
            cmds += 'COOKIES                   5.00'; 
            cmds += newLine;
            cmds += 'MILK 65 Fl oz             3.78';
            cmds += newLine + newLine;
            cmds += 'SUBTOTAL                  8.78';
            cmds += newLine;
            cmds += 'TAX 5%                    0.44';
            cmds += newLine;
            cmds += 'TOTAL                     9.22';
            cmds += newLine;
            cmds += 'CASH TEND                10.00';
            cmds += newLine;
            cmds += 'CASH DUE                  0.78';
            cmds += newLine + newLine;
            cmds += esc + '!' + '\x18'; //Emphasized + Double-height mode selected (ESC ! (16 + 8)) 24 dec => 18 hex
            cmds += '# ITEMS SOLD 2';
            cmds += esc + '!' + '\x00'; //Character font A selected (ESC ! 0)
            cmds += newLine + newLine;
            cmds += '11/03/13  19:53:17';
 
            cpj.printerCommands = cmds;
            //Send print job to printer!
            cpj.sendToClient();
        }
    }

</script>
@endpush