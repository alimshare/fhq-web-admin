<?php

namespace App\Exports;

use App\Model\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    use Exportable;

    private $jenis;
    private $startDate;
    private $endDate;

    public function filter($jenis = null, $startDate = null, $endDate = null)
    {
        $this->jenis     = $jenis;
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        return $this;
    }

    public function query()
    {
        $query = Transaction::query();

        if (in_array($this->jenis, [Transaction::JENIS_MASUK, Transaction::JENIS_KELUAR])) {
            $query->where('jenis', $this->jenis);
        }
        if (!empty($this->startDate)) {
            $query->whereDate('tanggal', '>=', $this->startDate);
        }
        if (!empty($this->endDate)) {
            $query->whereDate('tanggal', '<=', $this->endDate);
        }

        return $query->orderBy('tanggal', 'desc')->orderBy('id', 'desc');
    }

    /**
     * @param Transaction $trx
     */
    public function map($trx): array
    {
        return [
            $trx->tanggal->format('d/m/Y'),
            $trx->isMasuk() ? 'Masuk' : 'Keluar',
            $trx->kategori,
            $trx->keterangan,
            $trx->jumlah,
        ];
    }

    public function title(): string
    {
        return 'Transaksi Keuangan';
    }

    public function headings(): array
    {
        return [
            'Tanggal', 'Jenis', 'Kategori', 'Keterangan', 'Jumlah',
        ];
    }
}
