<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Eprecense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Validator;

class EprecenseController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function show()
    {
        $absensi = Eprecense::get();
        if ($absensi) {
            return response()->json([
                'success'   => true,
                'data'   => $absensi
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data absen tidak ditemukan',
            ], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->only('is_approve'), [
            'is_approve' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        if (Auth::user()->nama == 'Supervisor')
        {
            Eprecense::where('id', $id)->update([
                'is_approve' => $request->is_approve
            ]);

            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil approve absensi!'
            ], 200);

        } else {
            return response()->json([
                'success'   => true,
                'message'   => 'Anda tidak memiliki akses'
            ], 200);
        }
    }

    public function storeIn(Request $request)
    {
        $cekAbsen = Eprecense::where('id_users', Auth::user()->id)
                        ->where('type', 'IN')
                        ->where(DB::raw("(DATE_FORMAT(created_at, '%Y-%m-%d'))"), Carbon::now()->format('Y-m-d'))
                        ->count();
        if ($cekAbsen == 1) {
            return response()->json([
                'message'   => 'Anda telah melakukan absen masuk hari ini!'
            ], 200);
        } else {
            $absenMasuk = Eprecense::create([
                'id_users'    => Auth::user()->id,
                'type'       => 'IN',
                'is_approve' => 'FALSE'
            ]);

            if ($absenMasuk) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'Berhasil absen masuk!'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal absen masuk!',
                ], 401);
            }
        }
    }

    public function storeOut()
    {
        $cekAbsen = Eprecense::where('id_users', Auth::user()->id)
                        ->where('type', 'OUT')
                        ->where(DB::raw("(DATE_FORMAT(created_at, '%Y-%m-%d'))"), Carbon::now()->format('Y-m-d'))
                        ->count();

        if ($cekAbsen == 1) {
            return response()->json([
                'message'   => 'Anda telah melakukan absen keluar hari ini!'
            ], 200);
        } else {
            $absenKeluar = Eprecense::create([
                'id_users'    => Auth::user()->id,
                'type'       => 'OUT',
                'is_approve' => 'FALSE'
            ]);

            if ($absenKeluar) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'Berhasil absen keluar!'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal absen keluar!',
                ], 401);
            }
        }
    }
}
