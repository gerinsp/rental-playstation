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
                    <input type="hidden" name="status_transaksi" value="sukses">
                    <input type="hidden" name="transaksi" value="transaksi">
                    <input type="hidden" name="status_device" value="digunakan">
                    <div class="mb-3">
                        <label for="status">Status Keanggotaan</label>
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
                                    <option value="{{ $member->id }}" selected>{{ $member->user->name }}</option>
                                @else
                                    <option value="{{ $member->id }}">{{ $member->user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="device">
                        <label for="device">Nama Perangkat</label>
                        <select class="form-control" id="device_id" name="device_id" onchange="showPrice()">
                            @foreach ($devices as $device)
                                @if (old('device_id') == $device->id)
                                    <option value="{{ $device->id }}" selected>{{ $device->nama }}</option>
                                @else
                                    <option value="{{ $device->id }}">{{ $device->nama }}</option>
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
                        <label for="waktu_mulai" class="form-label ">Jam Mulai</label>
                        <input type="text" class="form-control @error('waktu_mulai') is-invalid @enderror"
                            id="waktu_mulai" name="waktu_mulai" required autofocus value="{{ old('waktu_mulai') }}">
                        @error('waktu_mulai')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jam_main" class="form-label ">Jam Main</label>
                        <input type="number" class="form-control @error('jam_main') is-invalid @enderror" id="jam_main"
                            name="jam_main" required autofocus value="{{ old('jam_main') }}" onchange="showChangeMaster()">
                        @error('jam_main')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="waktu_Selesai" class="form-label ">Jam Selesai</label>
                        <input type="text" class="form-control @error('waktu_Selesai') is-invalid @enderror"
                            id="waktu_Selesai" name="waktu_Selesai" required autofocus value="{{ old('waktu_Selesai') }}">
                        @error('waktu_Selesai')
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
        const d = new Date();

        member.style.display = "none";
        nama.style.display = "none";
        console.log(d.getHours() + " : " + d.getMinutes());

        document.getElementById('waktu_mulai').value =
            `${d.getHours() < 10 ? '0' + d.getHours() : d.getHours() }:${d.getMinutes() < 10 ? '0' + d.getMinutes() : d.getMinutes()}`;

        function onChangeWrapper() {
            showInput();
            showPrice();
        }

        function showChangeMaster() {
            showTime();
            showTotal();
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
            const device = document.getElementById('device_id').value;
            const harga = document.getElementById('harga');
            const jamMain = parseFloat(document.getElementById('jam_main').value);
            let status = document.getElementById('status').value;
            console.log(device)
            axios.get('/api/get-harga', {
                    params: {
                        device: device
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

        function showTime() {
            const waktu_mulai = document.getElementById('waktu_mulai').value;
            const waktu_selesai = document.getElementById('waktu_Selesai');
            const jam_main = document.getElementById('jam_main').value;
            console.log(jam_main)
            const tanggal = new Date().toISOString().slice(0, 10);
            const date = new Date();

            const waktu_mulai_split = waktu_mulai.split(':');
            date.setHours(waktu_mulai_split[0]);
            date.setMinutes(waktu_mulai_split[1]);
            console.log(date)
            date.setHours(date.getHours() + parseInt(jam_main));

            waktu_selesai.value =
                `${date.getHours()}:${date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()}`;

            console.log(`${date.getHours()}:${date.getMinutes()}`)
        }
    </script>
@endsection
