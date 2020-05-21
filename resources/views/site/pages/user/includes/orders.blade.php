<div class="user-payment">
    <div class="table-responsive-md">
        @if(App\Models\Order::where('user_id', auth()->user()->id)->first())
        <div class="row">
            <div class="col-12">
                @php $orders = App\Models\Order::orderBy('created_at', 'desc')->where('user_id',
                auth()->user()->id)->paginate(5); @endphp
                @foreach($orders as $order)
                <div class="item-entry">
                    <span class="order-id">Order ID: {{ $order->order_number }}</span>
                    <div class="item-content">
                        <div class="item-body">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Food Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( App\Models\Cart::where('order_id', $order->id)->get() as $cart)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td class="text-left" style="text-transform:capitalize">
                                            <img src="{{ asset('storage/'.$cart->product->images->first()->full) }}"
                                                title="{{ $cart->product->name }}" class="img-responsive pr-2 rounded"
                                                width="70px" />
                                            @if($cart->has_attribute)
                                            {{-- if this condition is true then $cart product_id is product_attribute id --}}
                                            {{ App\Models\ProductAttribute::find($cart->product_id)->product->name }}-({{ App\Models\ProductAttribute::find($cart->product_id)->size }})
                                            @else
                                            {{ $cart->product->name }}
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if($cart->has_attribute)
                                            {{ $cart->product_quantity }}
                                            @else
                                            {{ $cart->product_quantity }}
                                            @endif
                                        </td>

                                        <td class="text-center" style="text-transform:capitalize">
                                            @if($cart->has_attribute)
                                            {{-- we face data from product attribute table --}}
                                            {{-- if this condition is true then $cart product_id is product_attribute id --}}
                                            @if( App\Models\ProductAttribute::find($cart->product_id)->special_price)
                                            {{ round(App\Models\ProductAttribute::find($cart->product_id)->special_price,0) }}
                                            @else
                                            {{ round(App\Models\ProductAttribute::find($cart->product_id)->price,0) }}
                                            @endif
                                            @else
                                            @if($cart->product->discount_price)
                                            {{ round($cart->product->discount_price,0) }}
                                            @else
                                            {{ round($cart->product->price,0) }}
                                            @endif
                                            @endif

                                        </td>
                                        <td class="text-center" style="text-transform:capitalize">
                                            @if($cart->has_attribute)
                                            {{-- we face data from product attribute table --}}
                                            {{-- if this condition is true then $cart product_id is product_attribute id --}}
                                            @if( App\Models\ProductAttribute::find($cart->product_id)->special_price)
                                            {{ App\Models\ProductAttribute::find($cart->product_id)->special_price *  $cart->product_quantity }}
                                            @else
                                            {{ App\Models\ProductAttribute::find($cart->product_id)->price *  $cart->product_quantity  }}
                                            @endif
                                            @else
                                            @if($cart->product->discount_price)
                                            {{ $cart->product->discount_price *  $cart->product_quantity }}
                                            @else
                                            {{ $cart->product->price  *  $cart->product_quantity }}
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="item-footer">
                            <p>
                                @if($order->status == 'cancel')
                                <span class="btn btn-danger text-white text-capitalize">{{ $order->status }}</span>
                                @else
                                <span class="btn btn-success text-white text-capitalize">{{ $order->status }}</span>
                                @endif
                                <strong>Order Date:</strong>{{ $order->order_date }}<strong>Grand
                                    Total:</strong>{{ config('settings.currency_symbol') }}
                                {{ round($order->grand_total,0) }}
                            </p>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </div>

        <div class="pt-4 text-center">
            {{ $orders->links() }}
        </div>

        @else
        <div class="col-12 text-center">
            <h4 class="p-5">
                {{ __( 'No Transaction has been made' )}}
            </h4>
        </div>
        @endif
    </div>
</div>