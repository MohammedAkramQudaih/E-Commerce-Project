{{-- Categories Page --}}
@extends('admin.master')
@section('content')

<h2>All Discounts {{ $discounts->count() }} </h2>

@if (session('msg'))
    <div class="alert alert-{{ session('type') }} alert-dismissible fade show">
        {{ session('msg') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>
@endif




<table class="table table-bordered">
    <tr class="bg-dark text-white">
        <th>ID</th>
        <th>Name</th>
        <th>Start Date</th>
        <th>end_Date</th>
        <th>percentage</th>
        <th>Customers</th>
        <th>Crated At</th>
        <th>Actions</th>
    </tr>
    @forelse ($discounts as $discount)
    <tr>
        <td>{{ $discount->id }}</td>
        {{-- <td>{{ $loop->iteration }}</td> --}}
        <td>{{ $discount->name }}</td>
        <td>{{ $discount->start_date }}</td>
        <td>{{ $discount->end_date }}</td>
        <td>{{ $discount->percentage }}</td>
        <td>{{ $discount->customers }}</td>
        <td>{{ $discount->created_at->diffForHumans() }}</td>
        <td>
            <a href="{{ route('admin.discount.edit',$discount->id) }}" class="btn btn-primary btn-sm">Edit</a>
            <form class="d-inline" action="{{ route('admin.discount.destroy',$discount->id) }}" method="POST">
                @csrf
                @method('delete')
                <button onclick="return confirm('Are you sour?!')" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @empty
        <tr>
            <td colspan="8"class="text-center">No Data Found</td>
        </tr>
    @endforelse
    
</table>
@stop