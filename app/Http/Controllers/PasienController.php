<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegPeriksa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    public function tampilpasien(Request $request)
    {
        // Get the authenticated doctor's ID
        $dokter = Auth::user()->nik;

        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());
        
        // Retrieve patients for the specified doctor
        $pasien = RegPeriksa::with('pasien')
            ->where('kd_dokter', $dokter)
            ->whereDate('tgl_registrasi', $tanggal)
            ->get();

        return view('home', ['pasien' => $pasien, 'tanggal' => $tanggal]);
    }
}