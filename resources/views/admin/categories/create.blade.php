{{-- Categories Page --}}
@extends('admin.master')
@section('content')

    <h2>Add New Categories</h2>
    @include('admin.errors')
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="text" class="form-control" name="name" placeholder="Name">

        </div>
        <button class="btn btn-success btn-lg">SAVE</button>
    </form>
@stop
