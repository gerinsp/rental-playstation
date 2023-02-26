@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    Form Edit Perangkat
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form method="POST" action="/device/{{ $device->id }}">
                    @method('put')
                    @csrf
                    <input type="hidden" name="status" value="tersedia">
                    <div class="mb-3">
                        <label for="nama" class="form-label ">Nama Perangkat</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" required autofocus value="{{ old('nama', $device->nama) }}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="playstation_id">Jenis Playstation</label>
                        <select class="form-control" id="playstation_id" name="playstation_id">
                            @foreach ($playstations as $playstation)
                                @if (old('playstation_id', $device->playstation_id) === $playstation->id)
                                    <option value="{{ $playstation->id }}" selected>{{ $playstation->nama }}</option>
                                @else
                                    <option value="{{ $playstation->id }}">{{ $playstation->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status">Jenis Playstation</label>
                        <select class="form-control" id="status" name="status">
                            @if (old('status', $device->status) === 'tersedia')
                                <option value="tersedia" selected>Tersedia</option>
                                <option value="digunakan">Digunakan</option>
                            @else
                                <option value="tersedia">Tersedia</option>
                                <option value="digunakan" selected>Digunakan</option>
                            @endif
                        </select>
                    </div>
                    <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
