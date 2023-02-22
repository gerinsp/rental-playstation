@extends('layouts.app')

@section('content')
    <!-- Content Row -->
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('gagal'))
        <div class="alert alert-danger col-lg-8" role="alert">
            {{ session('gagal') }}
        </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                Data Playstation
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                </a>
                <a href="{{ route('playstation.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Harga Normal</th>
                        <th scope="col">Harga Member</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plays as $play)
                        <tr>
                            <th scope="row">
                                {{ ($plays->currentpage() - 1) * $plays->perpage() + $loop->index + 1 }}</th>
                            <td><img width="150px" src="{{ asset('storage/' . $play->image) }}">
                            </td>
                            <td>{{ $play->nama }}</td>
                            <td>{{ 'Rp ' . number_format($play->harga_normal, 0, ',', '.') }}</td>
                            <td>{{ 'Rp ' . number_format($play->harga_member, 0, ',', '.') }}</td>
                            <td>
                                <a href="/playstation/{{ $play->id }}/edit"><i class="fas fa-edit"></i></a>
                                <form action="/playstation/{{ $play->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="border-0 bg-white" onclick="return confirm('Are you sure?')"><i
                                            class="fas fa-trash-alt text-danger"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $plays->links() }}
        </div>
    </div>
    </div>
@endsection
