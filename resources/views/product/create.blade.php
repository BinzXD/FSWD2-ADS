@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="border rounded p-4" style="border-color: #e0e0e0;">
                <h4 class="mb-4">Create Produk</h4>
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Photo Product *</label>
                        <div class="border rounded p-3 text-center" style="border-color: #e0e0e0;">
                            <input type="file" name="images[]" id="formFileMultiple" class="form-control-file d-none" accept="image/png, image/jpeg, image/jpg, image/svg" multiple>
                            <label for="formFileMultiple" class="d-block text-center" style="cursor: pointer;" id="fileLabel">
                                <div class="text-muted" id="fileText">Drag and Drop or <a href="#">Choose File</a> to Upload</div>
                                <small class="text-muted">Supported formats: SVG, JPG, JPEG, or PNG | Maximum Size: 5MB</small>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="form-label">Name Product *</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name Product">
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="form-label">Categori *</label>
                        <select name="category_id" class="form-control" id="category_id">
                            @foreach($category as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" id="price" placeholder="Masukkan Harga">
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary me-3">Cancel</a>
                        <button type="submit" class="btn btn-success ml-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('formFileMultiple').addEventListener('change', function(event) {
        var input = event.target;
        var label = document.getElementById('fileText');
        var files = input.files;
        var fileNames = [];

        for (var i = 0; i < files.length; i++) {
            fileNames.push(files[i].name);
        }

        if (fileNames.length > 0) {
            label.textContent = fileNames.join(', ');
        } else {
            label.textContent = 'Drag and Drop or Choose File to Upload';
        }
    });
</script>
@endsection
