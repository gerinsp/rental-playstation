@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    Form Transaksi
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form method="POST" action="{{ route('transaction.store') }}">
                    @csrf
                    <input type="hidden" id="id_transaksi" name="id_transaksi">
                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" onchange="onChangeWrapper()">
                            <option value="member">-Pilih Status-</option>
                            <option value="member">Member</option>
                            <option value="umum">Umum</option>
                        </select>
                    </div>
                    <div class="mb-3" id="nama">
                        <label for="nama" class="form-label ">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" value="{{ old('nama') }}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3" id="member">
                        <label for="member">Nama Member</label>
                        <select class="form-control" id="member_id" name="member_id">
                            @foreach ($members as $member)
                                @if (old('member_id') == $member->id)
                                    <option value="{{ $member->id }}" selected>{{ $member->nama }}</option>
                                @else
                                    <option value="{{ $member->id }}">{{ $member->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="playstation">Jenis Playstation</label>
                        <select class="form-control" id="playstation_id" name="playstation_id" onchange="showPrice()">
                            @foreach ($playstations as $playstation)
                                @if (old('playstation_id') == $playstation->id)
                                    <option value="{{ $playstation->id }}" selected>{{ $playstation->nama }}</option>
                                @else
                                    <option value="{{ $playstation->id }}">{{ $playstation->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label ">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga"
                            name="harga" required autofocus value="{{ old('harga') }}">
                        @error('harga')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jam_main" class="form-label ">Jam Main</label>
                        <input type="number" class="form-control @error('jam_main') is-invalid @enderror" id="jam_main"
                            name="jam_main" required autofocus value="{{ old('jam_main') }}" onchange="showTotal()">
                        @error('jam_main')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label ">Total</label>
                        <input type="number" class="form-control @error('total') is-invalid @enderror" id="total"
                            name="total" required autofocus value="{{ old('total') }}">
                        @error('total')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary btn-sm" type="submit" onclick="generateId()">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const nama = document.getElementById('nama');
        const member = document.getElementById('member');

        member.style.display = "none";
        nama.style.display = "none";

        function onChangeWrapper() {
            showInput();
            showPrice();
        }

        function showInput() {
            const status = document.getElementById('status').value;
            const nama = document.getElementById('nama');
            const member = document.getElementById('member');

            if (status === 'member') {
                member.style.display = "block";
                nama.style.display = "none";
            } else {
                member.style.display = "none";
                nama.style.display = "block";
            }
        }

        function showPrice() {
            const play = document.getElementById('playstation_id').value;
            const harga = document.getElementById('harga');
            const jamMain = parseFloat(document.getElementById('jam_main').value);
            let status = document.getElementById('status').value;

            axios.get('/api/get-harga', {
                    params: {
                        playstation: play
                    }
                })
                .then(function(response) {
                    console.log(response.data);
                    if (status === 'member') {
                        harga.value = response.data.harga.harga_member;
                        const total = harga.value * jamMain;
                        document.getElementById('total').value = total;
                    } else {
                        harga.value = response.data.harga.harga_normal;
                        const total = harga.value * jamMain;
                        document.getElementById('total').value = total;
                    }
                })
                .catch(function(error) {
                    console.log(error)
                });
        }

        function showTotal() {
            const harga = parseFloat(document.getElementById('harga').value);
            const jamMain = parseFloat(document.getElementById('jam_main').value);
            const total = harga * jamMain;
            document.getElementById('total').value = total;
        }

        function generateId() {
            let rand = Math.floor(Math.random() * 9000000000) + 1000000000;
            let rand_str = rand.toString();

            if (rand_str.length < 10) {
                rand_str = '0'.repeat(10 - rand_str.length) + rand_str;
            }

            document.getElementById('id_transaksi').value = rand_str;
        }
    </script>
@endsection
