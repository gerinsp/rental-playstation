<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Member;
use App\Models\Playstation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $member = Member::count();
        $play = Playstation::count();
        $transaction = Transaction::count();
        $revenue = Transaction::sum('total');
        return view('home', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'member' => $member,
            'play' => $play,
            'transaksi' => $transaction,
            'pendapatan' => $revenue
        ]);
    }

    public function pieCartData()
    {
        $member = Transaction::where('status', 'member')->where('status_transaksi', 'sukses')->sum('total');
        $umum = Transaction::where('status', 'umum')->where('status_transaksi', 'sukses')->sum('total');
        $revenue = Transaction::sum('total');
        $persenUmum = ($umum / $revenue) * 100;
        $persenMember = ($member / $revenue) * 100;
        $labels = [
            'Umum (' . round($persenUmum, 1) . '%)',
            'Member (' . round($persenMember, 1) . '%)'
        ];
        $totalRevenue = [
            $umum,
            $member
        ];
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $totalRevenue,
                    'backgroundColor' => ['#4e73df', '#1cc88a', '#36b9cc'],
                    'hoverBackgroundColor' => ['#2e59d9', '#17a673', '#2c9faf'],
                    'hoverBorderColor' => "rgba(234, 236, 244, 1)",
                ]
            ]
        ];
        return $chartData;
    }

    public function pieCartData2()
    {
        $ps5 = 0;
        $ps4 = 0;
        $ps3 = 0;
        $device = Device::where('playstation_id', 1)->get();
        foreach ($device as $d) {
            $ps5 = Transaction::where('status_transaksi', 'sukses')->where('device_id', $d->id)->sum('total');
        }

        $device = Device::where('playstation_id', 2)->get();

        foreach ($device as $d) {
            $ps4 = Transaction::where('status_transaksi', 'sukses')->where('device_id', $d->id)->sum('total');
        }

        $device = Device::where('playstation_id', 3)->get();

        foreach ($device as $d) {
            $ps3 = Transaction::where('status_transaksi', 'sukses')->where('device_id', $d->id)->sum('total');
        }

        $revenue = Transaction::sum('total');
        $persenPs5 = ($ps5 / $revenue) * 100;
        $persenPs4 = ($ps4 / $revenue) * 100;
        $persenPs3 = ($ps3 / $revenue) * 100;
        $labels = [
            'Playstation 5 (' . round($persenPs5, 1) . '%)',
            'Playstation 4 (' . round($persenPs4, 1) . '%)',
            'Playstation 3 (' . round($persenPs3, 1) . '%)'
        ];
        $totalRevenue = [
            $ps5,
            $ps4,
            $ps3
        ];
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $totalRevenue,
                    'backgroundColor' => ['#4e73df', '#1cc88a', '#36b9cc'],
                    'hoverBackgroundColor' => ['#2e59d9', '#17a673', '#2c9faf'],
                    'hoverBorderColor' => "rgba(234, 236, 244, 1)",
                ]
            ]
        ];
        return $chartData;
    }

    public function areaCartData()
    {
        $totals = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $total = Transaction::whereMonth('created_at', $bulan)->where('status_transaksi', 'sukses')->sum('total');
            $totals[] = $total;
        }

        $chartData = [
            'datasets' => [
                [
                    "label" => "Pendapatan",
                    "lineTension" => 0.3,
                    "backgroundColor" => "rgba(78, 115, 223, 0.05)",
                    "borderColor" => "rgba(78, 115, 223, 1)",
                    "pointRadius" => 3,
                    "pointBackgroundColor" => "rgba(78, 115, 223, 1)",
                    "pointBorderColor" => "rgba(78, 115, 223, 1)",
                    "pointHoverRadius" => 3,
                    "pointHoverBackgroundColor" => "rgba(78, 115, 223, 1)",
                    "pointHoverBorderColor" => "rgba(78, 115, 223, 1)",
                    "pointHitRadius" => 10,
                    "pointBorderWidth" => 2,
                    "data" => $totals,
                ]
            ]
        ];

        return $chartData;
    }

    public function profile()
    {
        return view('profile.index', [
            'title' => 'Profile',
            'active' => ''
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'required|min:8',
            'status' => 'required'
        ]);

        if ($request->password === $user->password) {
            unset($validatedData['password']);
        } else {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        User::where('id', $id)->update($validatedData);

        return redirect('/profile')->with('success', 'Profile berhasil di update.');
    }
}
