<?php

namespace App\Exports;

use App\Model\View\ViewKbm;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapKbmExport implements FromQuery, WithTitle, WithHeadings
{
    use Exportable;

    private $semesterId;

    public function __construct()
    {
    }


    public function forSemester(int $semesterId)
    {
        $this->semesterId = $semesterId;
        
        return $this;
    }

    public function query()
    {
        $query = ViewKbm::select('tgl','program_name','pengajar_name','description','management_note','jumlah_peserta','hadir','tidak_hadir');

        if ($this->semesterId) {
            $query->where('semester_id', $this->semesterId);
        }

        return $query->orderBy('tgl','desc');

    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Rekap KBM';
    }


    public function headings(): array
    {
        return [
            'Tanggal','Program','Pengajar','Catatan','Catatan Manajemen','Jumlah Peserta','Hadir','Tidak Hadir'
        ];
    }
}
