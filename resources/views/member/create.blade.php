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
                    Form Member
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form method="POST" action="{{ route('members.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="user_id">Nama</label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option>- Pilih User -</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="laki-laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="no_telepon" class="form-label ">No. Telepon</label>
                        <input type="number" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon"
                            name="no_telepon" required autofocus value="{{ old('no_telepon') }}">
                        @error('no_telepon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" rows="3"
                            value="{{ old('alamat') }}"></textarea>
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
