<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Member;
use App\Models\Playstation;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        $device = Device::all();
        $timeNow = Carbon::now();
        $getTime = $timeNow->format('H:i:s');

        foreach ($transactions as $transaksi) {
            if ($transaksi->waktu_Selesai <= $getTime) {
                $device = Device::find($transaksi->device_id);
                $device->status = 'tersedia';
                $device->save();
            }
        }

        if ($transactions->isEmpty()) {
            foreach ($device as $d) {
                $d->status = 'tersedia';
                $d->save();
            }
        }

        $device = Device::paginate(5);
        return view('device.index', [
            'title' => 'Data Perangkat',
            'active' => 'device',
            'devices' => $device
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $play = Playstation::all();
        return view('device.create', [
            'title' => 'Tambah Perangkat',
            'active' => 'device',
            'plays' => $play
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
        $play = Playstation::find($request->playstation_id);
        $device = Device::where('playstation_id', $request->playstation_id);

        if ($device->count() >= intval($play->stok)) {
            return redirect('device')->with('gagal', 'Data gagal ditambahkan, Stok sudah habis.');
        }

        $validatedData = $request->validate([
            'nama' => 'required|min:3',
            'playstation_id' => 'required',
            'status' => 'required'
        ]);

        Device::create($validatedData);

        return redirect('device')->with('success', 'Data perangkat berhasil ditambahkan.');
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
        $device = Device::find($id);
        $playstation = Playstation::all();
        return view('device.edit', [
            'title' => 'Edit Perangkat',
            'active' => 'device',
            'device' => $device,
            'playstations' => $playstation
        ]);
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
        $validatedData = $request->validate([
            'nama' => 'required|min:3',
            'playstation_id' => 'required',
            'status' => 'required'
        ]);

        Device::where('id', $id)->update($validatedData);

        return redirect('device')->with('success', 'Data perangkat berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Device::destroy($id);

        return redirect('device')->with('success', 'Data perangkat berhasil dihapus.');
    }

    public function booking($id)
    {
        $tanggal = Carbon::now()->format('Y-m-d');
        $device = Device::find($id);
        $transactions = Transaction::where('device_id', $id)->whereDate('created_at', $tanggal)->paginate(5);
        // ddd($transactions);
        return view('device.booking', [
            'title' => 'Booking',
            'active' => 'device',
            'transactions' => $transactions,
            'device' => $device
        ]);
    }

    public function bookingAdd($id)
    {
        $device = Device::find($id);
        $member = Member::all();
        $playstation = Playstation::all();
        return view('device.booking-add', [
            'title' => 'Add Booking',
            'active' => 'device',
            'members' => $member,
            'playstations' => $playstation,
            'device' => $device,
        ]);
    }
}
