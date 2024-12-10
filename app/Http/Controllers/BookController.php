<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua buku
        $books = Book::all();
        return view('book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'type' => 'required',
            'author' => 'required',
            'year' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Book::create([
            'name' => $request->name,
            'type' => $request->type,
            'author' => $request->author,
            'year' => $request->year,
            'stock' => $request->stock,
        ]);

        return redirect()->route('book.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $book = Book::find($id);
        return view('book.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:5',
            'type' => 'required',
            'author' => 'required',
            'year' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Book::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'author' => $request->author,
            'year' => $request->year,
            'stock' => $request->stock,
        ]);

        return redirect()->route('book.index')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Menghapus buku berdasarkan ID
        Book::where('id', $id)->delete();
        return redirect()->route('book.index')->with('success', 'Berhasil menghapus data!');
    }
}
