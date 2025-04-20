@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Daftar Meja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.meja.create') }}" class="btn btn-primary mb-3">Tambah Meja</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nomor Meja</th>
                <th>QR Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mejas as $key => $meja)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $meja->nomor_meja }}</td>
                    <td>
                        {!! QrCode::size(100)->generate(url('/login') . '?nomor_meja=' . $meja->nomor_meja) !!}
                    </td>

                    <td>
                        <form action="{{ route('admin.meja.destroy', $meja->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus meja ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
