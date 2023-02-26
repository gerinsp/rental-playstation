@extends('layouts.app')

@section('content')
    <div class="col-lg-6" style="margin-bottom: 225px">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Transaksi</h6>
            </div>
            <div class="card-body">
                <form method="GET" id="form">
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
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="submit" class="btn btn-primary btn-sm" id="button-pdf">Generate PDF</button>
                        <button type="submit" class="btn btn-success btn-sm" id="button-excel">Generate Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const form = document.getElementById('form');
        const button_excel = document.getElementById('button-excel');
        const button_pdf = document.getElementById('button-pdf');

        button_excel.addEventListener('click', function(event) {
            event.preventDefault();
            form.action = "/generate-excel";
            form.submit();
        });

        button_pdf.addEventListener('click', function(event) {
            event.preventDefault();
            form.action = "/generate-pdf";
            form.submit();
        })
    </script>
@endsection
