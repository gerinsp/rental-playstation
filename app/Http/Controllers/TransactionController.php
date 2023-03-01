<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Member;
use App\Models\Playstation;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->status === 'admin') {
            $transaction = Transaction::latest()->paginate(5);
            return view('transaction.index', [
                'title' => 'Data Tansaksi',
                'active' => 'transaction',
                'transactions' => $transaction
            ]);
        } else {
            $transaction = Transaction::where('user_id', auth()->user()->id)->latest()->paginate(5);
            return view('transaction.index', [
                'title' => 'Data Tansaksi',
                'active' => 'transaction',
                'transactions' => $transaction
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $device = Device::all();
        $member = Member::all();
        $playstation = Playstation::all();
        return view('transaction.create', [
            'title' => 'Create Transaction',
            'active' => 'transaction',
            'members' => $member,
            'playstations' => $playstation,
            'devices' => $device
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tanggal = Carbon::now()->format('Y-m-d');
        $start_time = $request->waktu_mulai;
        $end_time = $request->waktu_Selesai;
        if ($start_time > '22:00' || $start_time < '08:00') {
            return redirect('booking/' . $request->device_id)->with('gagal', 'Maaf, rental sudah tutup!. Silahkan melakukan booking ketika rental sudah beroprasi kembali pada pukul 08:00.');
        }
        // Mengecek apakah waktu mulai dan waktu selesai sudah ada di database
        $existingTransaction = Transaction::where('device_id', $request->device_id)->whereDate('created_at', $tanggal)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->where(function ($query) use ($start_time) {
                    $query->where('waktu_mulai', '<=', $start_time)
                        ->where('waktu_Selesai', '>', $start_time);
                })
                    ->orWhere(function ($query) use ($end_time) {
                        $query->where('waktu_mulai', '<', $end_time)
                            ->where('waktu_Selesai', '>=', $end_time);
                    });
            })
            ->doesntExist();

        // Jika waktu mulai dan waktu selesai sudah ada di database, kembalikan response error

        if ($request->transaksi) {
            if (!$existingTransaction) {
                return redirect('transaction')->with('gagal', 'Tidak bisa memilih waktu tersebut. Perangkat sudah di booking.');
            }
        }

        if (!$existingTransaction) {
            return redirect('booking/' . $request->device_id)->with('gagal', 'Tidak bisa memilih waktu tersebut. Perangkat sudah di booking.');
        }


        $validatedData = $request->validate([
            'id_transaksi' => 'required',
            'status' => 'required',
            'member_id' => '',
            'nama' => '',
            'device_id' => 'required',
            'user_id' => '',
            'harga' => 'required',
            'jam_main' => 'required|max:2',
            'waktu_mulai' => 'required',
            'waktu_Selesai' => 'required',
            'total' => 'required',
            'status_transaksi' => 'required'
        ]);

        if ($request->transaksi) {
            $device = Device::find($request->device_id);

            $device->update(['status' => $request->status_device]);
        }

        Transaction::create($validatedData);

        if ($request->transaksi) {
            return redirect('transaction')->with('success', 'Data transaksi berhasil disimpan.');
        }

        return redirect('booking/' . $request->device_id)->with('success', 'Berhasil melakukan Booking.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaction::where('id_transaksi', $id)->delete();

        return redirect('transaction')->with('success', 'Data transaksi berhasil dihapus.');
    }

    public function getHarga(Request $request)
    {
        $device = $request->query('device');

        $devices = Device::find($device);
        $harga = Playstation::find($devices->playstation_id);

        return response()->json(['harga' => $harga]);
    }

    public function updateStatus(Request $request, $id)
    {
        Transaction::where('id_transaksi', $id)->update(['status_transaksi' => $request->status_transaksi]);
        Device::where('id', $request->device_id)->update(['status' => $request->status]);

        return redirect('transaction')->with('success', 'Status transaksi berhasil diupdate.');
    }
}
