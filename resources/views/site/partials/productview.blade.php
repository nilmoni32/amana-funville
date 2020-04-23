<!-- product display -->
<div class="row">
    @foreach($products as $product)
    {{-- checking the foriegn key value exists in products attributes table --}}
    @php $attributeCheck = in_array($product->id, $product->attributes->pluck('product_id')->toArray())
    @endphp
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
                        <span class="text-left pt-1 d-block">{{ $product->description}}</span>

                    </div>
                    <div class="cart-overlay" onclick="addToCart({{ $product->id }}, 0)">
                        <h5>Add to Cart</h5>
                    </div>
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
                        <span class="text-left pt-1 d-block">{{ $product->description}}</span>
                    </div>
                    <div class="cart-overlay" onclick="addToCart({{ $product->id }}, {{ $attribute->id }})">
                        <h5>Add to Cart</h5>
                    </div>
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