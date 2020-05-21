<!-- product display -->
<div class="row">
    @foreach($products as $product)
    {{-- checking the foriegn key value exists in products attributes table --}}
    @php $attributeCheck = in_array($product->id, $product->attributes->pluck('product_id')->toArray())
    @endphp
    {{-- $attributeCheck false means this is product table data --}}
    @if(!($attributeCheck) && $product->status)
    <div class="col-md-4 col-sm-6 col-xs-12 mb-3">
        <div class="dish-menu">
            <div class="item">
                <div class="box">
                    @foreach($product->images as $image)
                    <img src="{!! asset('storage/'.$image->full) !!}" alt="image" title="{{ $product->name }}"
                        class="img-responsive" />
                    @endforeach

                    <div class="caption">
                        <h4>{{ $product->name }}</h4>
                        {{-- if product discount price is available then we set it --}}
                        @if($product->discount_price)
                        <p>{{ config('settings.currency_symbol') }}-{{ round($product->discount_price,0)}}
                        </p>
                        <span
                            style="text-decoration: line-through">{{ config('settings.currency_symbol') }}-{{ round($product->price,0) }}</span>
                        {{-- calculating the discount percenate --}}
                        <span>
                            -{{ round(($product->price - $product->discount_price)*100/$product->price, 0) }}%</span>
                        @else
                        <p>{{ config('settings.currency_symbol') }}-{{ round($product->price,0) }}</p>
                        @endif
                        <span class="text-left px-1 pt-1 d-block">{{ $product->description}}</span>

                    </div>
                    {{-- <div class="cart-overlay" onclick="addToCart({{ $product->id }}, 0)">
                    <h5>Add to Cart</h5>
                </div> --}}
            </div>
            <div class="hoverbox pb-2">
                @php
                //Checking the product is added to cart or not
                if(Auth::check()){ //Auth::check() to check if the user is logged in
                // when logged user adds products to cart.
                $cart = App\Models\Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->where('order_id', NULL)
                ->where('has_attribute', 0)
                ->first();
                }else{
                // when a guest adds product to cart.
                $cart = App\Models\Cart::where('ip_address', request()->ip())
                ->where('product_id', $product->id)
                ->where('has_attribute', 0)
                ->first();
                }
                @endphp
                <button class="btn btn-theme-alt btn-cart btn-block {{ $cart ? 'display-none' : '' }}"
                    id="cartProductBtn{{ $product->id }}" onclick="addToCart({{ $product->id }}, 0)">Add to
                    Cart</button>
                <p class="{{ $cart ? '' : 'display-none' }} cart-msg" id="msg{{ $product->id }}">
                    Food is added to Cart</p>
            </div>
        </div>
    </div>
</div>
@elseif($attributeCheck && $product->status)
{{-- if product has attribute value then we display them all--}}
@foreach($product->attributes as $attribute)
<div class="col-md-4 col-sm-6 col-xs-12 mb-3">
    <div class="dish-menu">
        <div class="item">
            <div class="box">
                @foreach($product->images as $image)
                <img src="{!! asset('storage/'.$image->full) !!}" alt="image" title="{{ $product->name }}"
                    class="img-responsive" />
                @endforeach

                <div class="caption">
                    <h4>{{ $product->name }}-({{ $attribute->size }})</h4>
                    {{-- if product discount price is available then we set it --}}
                    @if($attribute->special_price)
                    <p>{{ config('settings.currency_symbol') }}-{{ round($attribute->special_price,0)}}
                    </p>
                    <span
                        style="text-decoration: line-through">{{ config('settings.currency_symbol') }}-{{ round($attribute->price,0) }}</span>
                    {{-- calculating the discount percenate --}}
                    <span>
                        -{{ round(($attribute->price - $attribute->special_price)*100/$attribute->price, 0) }}%</span>
                    @else
                    <p>{{ config('settings.currency_symbol') }}-{{ round($attribute->price,0) }}</p>
                    @endif
                    <span class="text-left px-1 py-1 d-block">{{ $product->description}}</span>

                </div>
                {{-- <div class="cart-overlay" onclick="addToCart({{ $product->id }}, {{ $attribute->id }})">
                <h5>Add to Cart</h5>
            </div> --}}
        </div>
        <div class="hoverbox pb-2">
            @php
            //Checking the product is added to cart or not
            if(Auth::check()){ //Auth::check() to check if the user is logged in
            // when logged user adds products to cart.
            $cart = App\Models\Cart::where('user_id', Auth::id())
            ->where('product_id', $attribute->id)
            ->where('order_id', NULL)
            ->where('has_attribute', 1)
            ->first();
            }else{
            // when a guest adds product to cart.
            $cart = App\Models\Cart::where('ip_address', request()->ip())
            ->where('product_id', $attribute->id)
            ->where('has_attribute', 1)
            ->first();
            }
            @endphp
            <button class="btn btn-theme-alt btn-cart btn-block {{ $cart ? 'display-none' : '' }}"
                id="cartSubProductBtn{{ $attribute->id }}" onclick="addToCart(0, {{ $attribute->id }})">Add
                to Cart</button>
            <p class="{{ $cart ? '' : 'display-none' }} cart-msg" id="subMsg{{ $attribute->id }}">
                Food is added to Cart</p>

        </div>
    </div>
</div>
</div>
@endforeach
@endif
@endforeach

</div>
<div class="pt-4">
    {{ $products->links() }}
</div>