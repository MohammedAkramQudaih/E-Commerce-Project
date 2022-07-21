{{-- Categories Page --}}
@extends('admin.master')
@section('content')

    <h2>Add New Discounts</h2>
    @include('admin.errors')
    <form action="{{ route('admin.discount.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="text" class="form-control" name="name" placeholder="Name">
        </div>
        <div class="mb-3">
            <input type="datetime-local" class="form-control" name="start_date" placeholder="Start Date">
        </div>
        <div class="mb-3">
            <input type="datetime-local" class="form-control" name="end_date" placeholder="End Date">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="percentage" placeholder="Percentage">
        </div>
        <div class="mb-3">
            <input type="number" class="form-control" name="customers" placeholder="Customers">
        </div>
        
        <button class="btn btn-success btn-lg">SAVE</button>
    </form>
@stop
