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
                Data Perangkat
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                </a>

                @if (auth()->user()->status === 'admin')
                    <a href="{{ route('device.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
                @endif
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Perangkat</th>
                        <th scope="col">Jenis Playstation</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                        <tr>
                            <th scope="row">
                                {{ ($devices->currentpage() - 1) * $devices->perpage() + $loop->index + 1 }}</th>
                            <td>{{ $device->nama }}</td>
                            <td>{{ $device->playstation->nama }}</td>
                            @if ($device->status === 'tersedia')
                                <td><i class="fa fa-circle text-success" aria-hidden="true"></i>
                                    {{ ucfirst($device->status) }}</td>
                                <td>
                                @else
                                <td><i class="fa fa-circle text-danger" aria-hidden="true"></i>
                                    {{ ucfirst($device->status) }}</td>
                                <td>
                            @endif

                            @if (auth()->user()->status === 'admin')
                                <a href="/device/{{ $device->id }}/edit"><i class="fas fa-edit"></i></a>
                                <form action="/device/{{ $device->id }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="border-0 bg-white" onclick="return confirm('Are you sure?')"><i
                                            class="fas fa-trash-alt text-danger"></i></button>
                                </form>
                                </td>
                            @else
                                <a href="/booking/{{ $device->id }}" class="btn btn-sm btn-primary">Lihat Jadwal</a>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $devices->links() }}
        </div>
    </div>
    </div>
@endsection
