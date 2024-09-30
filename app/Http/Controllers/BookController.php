<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Service\BookService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookController extends Controller
{

    protected $bookService;
    public function __construct(BookService $bookService)
    {
        return $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = $this->bookService->getAllBooks();
        return $this->sendRespons($books, 'books have been retrieved successfully');
    }

    public function indexByCategory($categoryId)
    {
        try {
            $books = $this->bookService->indexByCategory($categoryId);
            return $this->sendRespons($books, 'books by category retrieved successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendError(null,'retrieve filed');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();
        $book = $this->bookService->createBook($validated);
        return $this->sendRespons($book, 'book created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $book = $this->bookService->showById($id);
            return $this->sendRespons($book, 'book retrieved successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendError(null,'retrieve book failed');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        try {
            $validated = $request->validated();
            $book = $this->bookService->updateBook($validated, $id);
            return $this->sendRespons($book, 'book updated successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendError(null,'update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->bookService->deleteBook($id);
            return $this->sendRespons([], 'book has been deleted successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendError(null,'delete failed');
        }
    }
}
