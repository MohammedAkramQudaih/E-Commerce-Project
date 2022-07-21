{{-- Categories Page --}}
@extends('admin.master')
@section('content')

    <h2>Update Discount: <b class="text-info">{{ $discount->name }}</b></h2>
    @include('admin.errors')
    <form action="{{ route('admin.discount.update',$discount->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="mb-3">
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name',$discount->name) }}">
        </div>
        <div class="mb-3">
            <input type="datetime-local" class="form-control" name="start_date" placeholder="Start Date" value="{{ old('start_date',$discount->start_date) }}">
        </div>
        <div class="mb-3">
            <input type="datetime-local" class="form-control" name="end_date" placeholder="End Date" value="{{ old('end_date',$discount->end_date) }}">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="percentage" placeholder="Percentage" value="{{ old('percentage',$discount->percentage) }}">
        </div>
        <div class="mb-3">
            <input type="number" class="form-control" name="customers" placeholder="Customers" value="{{ old('customers',$discount->customers) }}">
        </div>
        <button class="btn btn-warning btn-lg">UPDATE</button>
    </form>
@stop
