<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Mengambil koleksi data untuk diekspor.
     */
    public function collection()
    {
        return Order::with('user')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Menentukan judul kolom dalam file Excel.
     */
    public function headings(): array
    {
        return [
            'ID Peminjaman',
            'Nama Staff',
            'Nama Peminjam',
            'Detail Buku yang Dipinjam',
            'Total Buku',
            'Tanggal Peminjaman',
        ];
    }

    /**
     * Format data setiap baris untuk diekspor.
     */
    public function map($order): array
    {
        $dataBuku = '';

        foreach ($order->books as $index => $book) {
            $dataBuku .= ($index + 1) . '. ' . $book['name'] .
                ' | Penulis: ' . $book['author'] .
                ' | Jenis: ' . $book['type'] .
                ' | Tahun: ' . $book['year'] .
                ' | Qty: ' . $book['qty'] . "\n";
        }

        return [
            $order->id, // ID peminjaman
            $order->user->name ?? '-', // Nama staff (bisa null, jadi gunakan fallback '-')
            $order->name_customer, // Nama peminjam
            trim($dataBuku), // Detail buku yang dipinjam
            $order->sum_book, // Total jumlah buku
            Carbon::parse($order->created_at)->locale('id')->translatedFormat('l, d F Y'), // Format tanggal
        ];
    }
}
