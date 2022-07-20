{{-- Categories Page --}}
@extends('admin.master')
@section('content')

<h2>All Categories {{ $categories->count() }} </h2>

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
        <th>Crated At</th>
        <th>Actions</th>
    </tr>
    @forelse ($categories as $category)
    <tr>
        <td>{{ $category->id }}</td>
        {{-- <td>{{ $loop->iteration }}</td> --}}
        <td>{{ $category->name }}</td>
        <td>{{ $category->created_at->diffForHumans() }}</td>
        <td>
            <a href="{{ route('admin.categories.edit',$category->id) }}" class="btn btn-primary btn-sm">Edit</a>
            <form class="d-inline" action="{{ route('admin.categories.destroy',$category->id) }}" method="POST">
                @csrf
                @method('delete')
                <button onclick="return confirm('Are you sour?!')" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @empty
        <tr>
            <td colspan="4">No Data Found</td>
        </tr>
    @endforelse
    
</table>
@stop