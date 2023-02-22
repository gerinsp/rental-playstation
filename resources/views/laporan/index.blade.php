@extends('layouts.app')

@section('content')
    <div class="col-lg-6" style="margin-bottom: 225px">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Transaksi</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="/generate-pdf">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Dari Tanggal</label>
                            <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Sampai Tanggal</label>
                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Generate PDF</button>
                </form>
            </div>
        </div>
    </div>
@endsection
