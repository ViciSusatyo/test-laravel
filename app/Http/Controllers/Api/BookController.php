<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Menampilkan semua buku
    public function index()
    {
        return response()->json([
            'data'   => Book::all(),
            'status' => 'success',
        ], 200);
    }

    // Menyimpan buku baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'status'      => 'nullable|integer',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'data'   => $book,
            'status' => 'success',
        ], 201);
    }

    // Menampilkan satu buku berdasarkan ID
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
                'status'  => 'error',
            ], 404);
        }

        return response()->json([
            'data'   => $book,
            'status' => 'success',
        ], 200);
    }

    // Memperbarui buku
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
                'status'  => 'error',
            ], 404);
        }

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status'      => 'sometimes|nullable|integer',
        ]);

        $book->update($validated);

        return response()->json([
            'data'   => $book,
            'status' => 'success',
        ], 200);
    }

    // Menghapus buku
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
                'status'  => 'error',
            ], 404);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully',
            'status'  => 'success',
        ], 200);
    }
}