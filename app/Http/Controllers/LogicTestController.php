<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogicTestController extends Controller
{
    public function index()
    {
        // ========================================
        //                SOAL NOMOR 1
        // ========================================

        $input = collect([
            ['kaos kaki' => 1],
            ['kaos kaki' => 1],
            ['kaos kaki' => 3],
            ['kaos kaki' => 1],
            ['kaos kaki' => 2],
            ['kaos kaki' => 1],
            ['kaos kaki' => 3],
            ['kaos kaki' => 3],
            ['kaos kaki' => 3],
            ['kaos kaki' => 3]
        ])->groupBy('kaos kaki');

        $total = [];
        foreach ($input as $data)
        {
            $totalPasang = $data->count();
            if ($totalPasang > 1)
            {
                if ($totalPasang % 2 == 0)
                {
                    $hasil[] = $totalPasang / 2;
                } else {
                    $hasil[] = ($totalPasang - 1) / 2;
                }

                $total = array_sum($hasil);
            }
        }

        dd('Output : '.$total);

        // ========================================
        //                SOAL NOMOR 2
        // ========================================

        $input = ([
            ['text' => 'Saat meng*ecat tembok , Agung dib_antu oleh Raihan']
        ]);

        foreach ($input as $data) {
            // $lenString = str_word_count($data['text']);
            // dump($lenString);
            $string = 'text';
            $string = explode(" ", $data['text']);
            foreach ($string as $detail) {
                if (preg_match('/[^A-Za-z]/', $detail)) {
                    $hasil[] = 0;
                } else {
                    $hasil[] = 1;
                }
                    $total = array_sum($hasil);
            }
        }

        dd($total.' Karakter');
    }
}
