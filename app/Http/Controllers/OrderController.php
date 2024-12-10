<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function exportExcel()
    {
        return Excel::download(new OrderExport, 'orders.xlsx');
    }
    public function index(Request $request)
    {
        $search_day = $request->search_day ? $request->search_day . '%' : '%';

        $orders = Order::where('user_id', Auth::id())
            ->where('created_at', 'LIKE', $search_day)
            ->with('user')
            ->simplePaginate(5);

        // return $orders;

        return view('order.user.user', compact('orders'));
    }

    public function indexAdmin(Request $request)
    {
        $search_day = $request->search_day ? $request->search_day . '%' : '%';

        $orders = Order::with('user')
            ->where('created_at', 'LIKE', $search_day) // Pencarian dengan LIKE pada created_at
            ->simplePaginate(5);

        return view('order.admin.data', compact("orders"));
    }

    public function create()
    {
        $books = Book::where('stock', '>', 0)->get(); // Ambil buku dengan stok lebih dari 0
        // return $books;
        return view('order.user.form', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'name_customer' => 'required|string|max:255',
            'orders' => 'required|array', // Pastikan ada setidaknya satu item yang dipilih
        ]);

        // Menghitung jumlah setiap item dalam array orders
        $arrayValues = array_count_values($request->orders);
        $arrayNewOrders = [];
        $books = Book::whereIn('id', array_keys($arrayValues))->get()->keyBy('id');

        foreach ($arrayValues as $key => $value) {
            $book = $books->get($key);

            if (!$book || $book->stock < $value) {
                return redirect()->back()->withInput()->with([
                    'failed' => 'Stok buku tidak cukup untuk ' . ($book ? $book->name : 'ID #' . $key),
                    'ValueBefore' => [
                        'name_customer' => $request->name_customer,
                        'orders' => $request->orders,
                    ],
                ]);
            }

            // Kurangi stok buku
            $book->stock -= $value;
            $book->save();

            // Susun data order baru
            $arrayNewOrders[] = [
                'id' => $key,
                'name' => $book->name,
                'author' => $book->author,
                'type' => $book->type,
                'year' => $book->year,
                'qty' => $value,
            ];
        }

        // Hitung total jumlah buku
        $totalQty = array_reduce($arrayNewOrders, fn($sum, $item) => $sum + $item['qty'], 0);

        // Simpan order ke database
        Order::create([
            'user_id' => Auth::id(),
            'books' => $arrayNewOrders,
            'name_customer' => $request->name_customer,
            'sum_book' => $totalQty,
        ]);

        return redirect()->route('pinjam.index')->with('berhasil', 'Tes session berhasil!');

    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with('book')->findOrFail($id);
        return view('order.user.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $books = Book::where('stock', '>', 0)->get();
        return view('order.user.edit', compact('order', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Validasi status
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        // Update status
        $order->update($request->only('status'));
        return redirect()->route('pinjam.index')->with('success', 'Peminjaman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $books = $order->books;
        $order->delete();

        foreach ($books as $book) {
            Book::find($book['id'])->increment('stock', $book['qty']);
        }

        return redirect()->route('pinjam.index')->with('success', 'Peminjaman berhasil dihapus!');
    }

    public function print($id)
    {
        $order = Order::with('user')->findOrFail($id);
        // return $order;
        return view('order.user.print', compact('order'));
    }

    public function printPdf($id)
    {
        $order = Order::with('user')->findOrFail($id);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('order.user.print-pdf', compact('order'));
        return $pdf->stream('invoice.pdf');
    }
}
