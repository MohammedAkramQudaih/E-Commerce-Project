<form action="{{ route('website.buy') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="type" value="wishlist">
    <button style="border: none;padding: 0;background: none"><i class="fa fa-heart-o"></i> add to
        wishlist</button>
</form>
