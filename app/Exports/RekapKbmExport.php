<?php

namespace App\Exports;

use App\Model\View\ViewKbm;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapKbmExport implements FromQuery, WithTitle, WithHeadings
{
    use Exportable;

    private $semesterId;
    private $startDate;
    private $endDate;

    public function __construct()
    {
    }


    public function forSemester(int $semesterId)
    {
        $this->semesterId = $semesterId;
        
        return $this;
    }

    public function filterPeriod($startDate, $endDate)
    {
        $this->startDate    = $startDate;
        $this->endDate      = $endDate;
        return $this;
    }

    public function query()
    {
        $query = ViewKbm::select('tgl','program_name','pengajar_name',DB::raw('DATE_FORMAT(start_time, "%H:%i") as start'),DB::raw('DATE_FORMAT(end_time, "%H:%i") as end'),'description','management_note','jumlah_peserta','hadir','tidak_hadir');

        if ($this->semesterId) {
            $query->where('semester_id', $this->semesterId);
        }

        if (!empty($this->startDate) && !empty($this->endDate)) {
            $query->whereBetween('tgl', [$this->startDate, $this->endDate]);
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
            'Tanggal','Program','Pengajar','Mulai','Selesai','Catatan','Catatan Manajemen','Jumlah Peserta','Hadir','Tidak Hadir'
        ];
    }
}
