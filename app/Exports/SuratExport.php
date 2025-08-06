<?php

namespace App\Exports;

use App\Models\Surats;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;


class SuratExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Surats::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'nomor surat',
            'jenis surat',
            'pengirim',
            'tanggal_surat', 
            'tanggal_masuk',
            'Keterangan',   
            'Dibuat pada',
            'Diupdate pada',
        ];
    }

    public function map($surat): array
    {
        return [
            $surat->id,
            $surat->nomor_surat,
            $surat->jenis->jenis_surat,
            $surat->Pengirim,
            $surat->tanggal_surat ? $surat->tanggal_surat->format('d-m-Y') :'Tidak Diketahui',
            $surat->tanggal_masuk ? $surat->tanggal_masuk->format('d-m-Y') : 'Tidak Diketahui',
            $surat->Keterangan,
        ];
    }

     public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            
            1 => ['font' => ['bold' => true]],
            // Styling specific cells
            'A1:I1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9E1F2']]],
        ];
    }
}
