{{-- Categories Page --}}
@extends('admin.master')
@section('content')

    <h2>Update Products: <b class="text-info">{{ $products->name }}</b></h2>
    @include('admin.errors')
    <form action="{{ route('admin.products.update',$products->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="mb-3">
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name',$products->name) }}">
        </div>

        <div class="mb-3">
            <input type="text" class="form-control" name="price" placeholder="Price" value="{{ old('price',$products->peice) }}">
        </div>
        
        <div class="mb-3">
            <label for="">Image</label>
            <input type="file" class="form-control" name="image" >
        </div>
        <div class="mb-3">
            <label for="">Album</label>
            <input type="file" class="form-control" multiple name="album[]" >
        </div>
        <div class="mb-3">
            <input type="number" class="form-control" name="quantity" placeholder="Quantity" value="{{ old('quantity',$products->quantity) }}">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="serial_number" placeholder="Serial Number" value="{{ old('serial_number',$products->serial_number) }}">
        </div>
        <div class="mb-3">
            <textarea icols="30" rows="10" class="form-control" name="description" placeholder="Description"> {{ old('description',$products->description) }}</textarea>
        </div>
        {{-- <div class="mb-3">
            <select class="form-control" name="category_id" id="">
                <option value="" selected disabled>Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <select class="form-control" name="discount_id" id="">
                <option value="" disabled selected>Select Discount</option>
                @foreach ($discounts as $discount)
                    <option value="{{ $discount->id}}">{{ $discount->name }}</option>
                @endforeach
            </select>
        </div> --}}
        <button class="btn btn-warning btn-lg">UPDATE</button>
    </form>
@stop
