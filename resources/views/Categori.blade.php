
@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col d-flex justify-content-between align-items-center">
                <h1>CATEGORI</h1>
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
                                 <th scope="col">No</th>
                                  <th scope="col">Name</th>
                                  <th scope="col">Jumlah</th>
                                  <th scope="col" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $index => $category)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category['name'] }}</td>
                    <td>{{ $category['product_count'] }}</td>
                    <td class="text-right">
                      <div class="btn-group">
                        <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-cog"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item" href="#">Edit</a>
                          <form method="POST" action="">
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

