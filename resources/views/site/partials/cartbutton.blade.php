<form class="form-online" action="{{ route('cart.store') }}" method="post">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <div class="buttons">
        <button type="submit" class="btn btn-theme-alt btn-md">Add to Cart</button>
    </div>
</form>