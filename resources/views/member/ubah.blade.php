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
                    Form Edit Member
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form method="POST" action="/members/{{ $member->id }}">
                    @method('put')
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label ">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" required autofocus value="{{ old('nama', $member->user->name) }}" disabled>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                            @if (old('jenis_kelamin', $member->jenis_kelamin === 'laki-laki'))
                                <option value="laki-laki" selected>Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                            @else
                                <option value="laki-laki">Laki-Laki</option>
                                <option value="perempuan" selected>Perempuan</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="no_telepon" class="form-label ">No. Telepon</label>
                        <input type="number" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon"
                            name="no_telepon" required autofocus value="{{ old('no_telepon', $member->no_telepon) }}">
                        @error('no_telepon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" rows="3">{{ old('alamat', $member->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
