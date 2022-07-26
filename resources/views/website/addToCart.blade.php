<form action="{{ route('website.buy') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="type" value="cart">
    <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
</form>
