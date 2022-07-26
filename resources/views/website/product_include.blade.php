<div class="product">
    <a href="{{ route('website.product', $product->slug) }}">
        <div class="product-img">
            <img src="{{ asset('images/' . $product->image) }}" alt="">
        </div>
    </a>
    <div class="product-body">
        <p class="product-category">{{ $category->name }}</p>
        <h3 class="product-name"><a href="{{ route('website.product', $product->slug) }}">{{ $product->name }}</a></h3>
        <h4 class="product-price">$980.00 <del class="product-old-price">{{ $product->peice }}</del>
        </h4>
        <div class="product-rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
        </div>
        <div class="product-btns">
            @include('website.addTowishlist')
            {{-- <button class="add-to-compare"><i class="fa fa-exchange"></i><span --}}
            {{-- class="tooltipp">add to compare</span></button> --}}
            {{-- <button class="quick-view"><i class="fa fa-eye"></i><span --}}
            {{-- class="tooltipp">quick view</span></button> --}}
        </div>
    </div>
    <div class="add-to-cart">
        @include('website.addToCart')
    </div>
</div>
