@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Tambah Nomor Meja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.meja.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nomor_meja" class="form-label">Nomor Meja</label>
            <input type="number" class="form-control" id="nomor_meja" name="nomor_meja" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Meja</button>
    </form>
</div>
@endsection
