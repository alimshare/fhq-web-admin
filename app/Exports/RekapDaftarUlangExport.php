<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapDaftarUlangExport implements FromCollection, WithHeadings, WithMapping
{

    private $data;
    private $rowNumber = 1; 

    function __construct($data)
    {
        $this->data     = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings() : array {
        return [
            'No', 'Waktu DU', 
            'Hari Lama', 'Jenis KBM Lama',
            'Program Lama', 'Pengajar Lama',  
            'NIS', 'Santri', 'Status',  
            'Pilihan Hari', 'Pilihan Jenis KBM', 
            'Bukti transfer', 'Tanggal Verifikasi'
        ];
    }
    
    public function map($row): array
    {
        return [
            $this->rowNumber++,
            $row->created_at,
            $row->hari_lama, 
            $row->jenis_kbm_lama,
            $row->program_name,
            $row->pengajar_name,
            $row->nis,
            $row->santri_name,
            $row->status,
            $row->hari,
            $row->jenis_kbm,
            "https://admin.fhqannashr.org/storage/daftar-ulang/".$row->upload_file,
            $row->verified_at,
        ];
    }
}
