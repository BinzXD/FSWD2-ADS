@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col d-flex justify-content-between align-items-center">
                <h1>PRODUK</h1>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <form class="d-flex justify-content-between mb-3">
                    <div class="d-flex">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Search" style="width: 250px;" value="{{ request('search') }}">
                    </div>

                    <div class="d-flex">
                        <button class="btn btn-outline-success mr-2" type="submit">Filter</button>
                        <a href="{{ route('product.create') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Create
                        </a>
                    </div>
                </form>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Photo Product</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Link</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if(isset($item['assets'][0]['image']))
                                    <img src="{{ asset('storage/' . $item['assets'][0]['image']) }}" alt="Product Image" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                    No Image
                                    @endif
                                </td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['categori']['name'] }}</td>
                                <td><a href="#" class="text-primary">{{ $item['slug'] }}</a></td>
                                <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('product.edit', $item['id']) }}">Edit</a>
                                            <form method="POST" action="{{ route('product.destroy', $item['id']) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item confirm-button" type="submit">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
