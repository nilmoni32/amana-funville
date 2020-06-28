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
                <div class="form-group row mt-2">
                    <label class="col-sm-4 col-form-label font-weight-bold text-right text-uppercase">Search
                        Product</label>
                    <div class="col-sm-4 text-center">
                        <input type="text" class="form-control" id="product_search" name="product_search"
                            placeholder="Find Products">
                    </div>
                    {{-- <!-- For displaying selected option value from autocomplete suggestion -->
                    <div class="col-sm-4">
                        <input type="hidden" id='product_id' name="product_id" readonly>
                    </div> --}}
                </div>
                <div class="row mt-5">
                    <div class="col-sm-8">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center"> Food Name </th>
                                    <th class="text-center"> Price </th>
                                    <th class="text-center"> Qty </th>
                                    <th class="text-center"> Subtotal </th>
                                    <th style="width:100px; min-width:100px;" class="text-center text-danger"><i
                                            class="fa fa-bolt"> </i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(App\Models\Sale::where('admin_id', Auth::id())->where('ordersale_id',
                                NULL)->get() as $sale)
                                <tr>
                                    <td class="text-center">{{ $sale->product_name }}</td>
                                    <td class="text-center">{{ $sale->unit_price }}</td>
                                    <td class="text-center">{{ $sale->product_quantity }}</td>
                                    <td class="text-center">{{ $sale->product_quantity * $sale->unit_price }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <div class="border px-3 rounded" style="border-color:rgb(182, 182, 182);">
                            <h4 class="text-center my-3">Customer Details</h4>
                            <div class="form-group my-4">
                                <input type="text" class="form-control" id="customer_name" placeholder="Customer Name"
                                    name="customer_name">
                            </div>
                            <div class="form-group my-4">
                                <input type="text" class="form-control" id="customer_phone"
                                    placeholder="Customer Phone No" name="customer_phone">

                            </div>
                            <div class="form-group my-4">
                                <input type="email" class="form-control" id="customer_email"
                                    placeholder="Customer Email" name="customer_email">
                            </div>
                            <div class="form-group my-4">
                                <textarea class="form-control" id="customer_notes" rows="4" name="customer_notes"
                                    placeholder="Customer Notes"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8 text-right" style="margin-top:-40px;">
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    // getting CSRF Token from meta tag
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){
        //Initialize jQuery UI autocomplete on #product_search field.
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
        //    $('#product_id').val(ui.item.value); // save selected id to input
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
            if (data.status == "success") {
                tableBody = $("table tbody"); 
                markup = "<tr><td class='text-center'>"  + data.foodname + "</td>" + 
                         "<td class='text-center'>"  + data.price + "</td>" + 
                         "<td class='text-center'>"  + data.qty + "</td>" + 
                         "<td class='text-center'>"  + data.price * data.qty + "</td>" + 
                         "<td class='text-center'>"  + "<div class='btn-group' role='group' aria-label='Second group'>" + 
                            "<a href='#' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a></div>"  + "</td>" +
                         "</tr>"; 
                tableBody.append(markup); 
            }
        });
        }

    });

</script>
@endpush