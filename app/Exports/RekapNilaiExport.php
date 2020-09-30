<?php

namespace App\Exports;

use \App\Model\View\ViewPeserta;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapNilaiExport implements FromQuery, WithTitle, WithHeadings
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
        $query = ViewPeserta::select('day','gender','program_name','pengajar_name','nis','santri_name',
            'nilai_uts_praktek','nilai_uts_teori','nilai_uas_praktek','nilai_uas_teori',
            'khatam','kehadiran','status','catatan');

        if ($this->semesterId) {
            $query->where('semester_id', $this->semesterId);
        }

        return $query->orderBy('day','desc')
            ->orderBy('pengajar_name','asc')
            ->orderBy('santri_name','asc')
            ;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Rekap Nilai';
    }


    public function headings(): array
    {
        return [
            'Hari','Jenis Kelamin','Program','Pengajar','NIS','Nama Santri',
            'Nilai UTS Praktek','Nilai UTS Teori','Nilai UAS Praktek','Nilai UAS Teori',
            'Khatam','Kehadiran','Status','Catatan'
        ];
    }
}
