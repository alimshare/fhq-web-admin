<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Model\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FinanceController extends Controller
{
    /**
     * Folder penyimpanan lampiran pada disk "public".
     */
    const ATTACHMENT_DIR = 'transactions';

    /**
     * Daftar transaksi kas masuk & keluar beserta ringkasan saldo.
     */
    public function index(Request $request)
    {
        $query = $this->filteredQuery($request);

        $transactions = $query->orderBy('tanggal', 'desc')->orderBy('id', 'desc')->get();

        $totalMasuk  = (clone $query)->where('jenis', Transaction::JENIS_MASUK)->sum('jumlah');
        $totalKeluar = (clone $query)->where('jenis', Transaction::JENIS_KELUAR)->sum('jumlah');
        $saldo       = $totalMasuk - $totalKeluar;

        return view('pages.finance.index', compact('transactions', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    /**
     * Unduh daftar transaksi (sesuai filter aktif) sebagai file Excel.
     */
    public function export(Request $request)
    {
        $filename = 'keuangan-' . date('Ymd_His') . '.xlsx';

        return (new TransactionExport)
            ->filter($request->jenis, $request->start_date, $request->end_date)
            ->download($filename);
    }

    /**
     * Form tambah transaksi.
     */
    public function create()
    {
        return view('pages.finance.create');
    }

    /**
     * Simpan transaksi baru.
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['created_by'] = Auth::id();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store(self::ATTACHMENT_DIR, 'public');
        }

        Transaction::create($data);

        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Form edit transaksi.
     */
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('pages.finance.edit', compact('transaction'));
    }

    /**
     * Perbarui transaksi.
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $data = $this->validateData($request);

        if ($request->hasFile('attachment')) {
            // Ganti lampiran lama bila ada.
            $this->deleteAttachment($transaction);
            $data['attachment'] = $request->file('attachment')->store(self::ATTACHMENT_DIR, 'public');
        }

        $transaction->update($data);

        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Hapus transaksi (beserta lampirannya).
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $this->deleteAttachment($transaction);
        $transaction->delete();

        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Bangun query daftar transaksi sesuai filter request.
     */
    private function filteredQuery(Request $request)
    {
        $query = Transaction::query();

        if (in_array($request->jenis, [Transaction::JENIS_MASUK, Transaction::JENIS_KELUAR])) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        return $query;
    }

    private function deleteAttachment(Transaction $transaction)
    {
        if ($transaction->attachment) {
            Storage::disk('public')->delete($transaction->attachment);
        }
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'tanggal'    => 'required|date',
            'jenis'      => 'required|in:masuk,keluar',
            'kategori'   => 'nullable|string|max:255',
            'jumlah'     => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);
    }
}
