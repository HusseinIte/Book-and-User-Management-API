<?php

namespace App\Service;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookService
{
    public function getAllBooks()
    {
        $books = Book::all();
        return $books;
    }

    public function indexByCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $books = $category->books;
        return $books;
    }
    public function createBook(array $data)
    {
        return Book::create([
            'title'        => $data['title'],
            'author'       => $data['author'],
            'published_at' => $data['published_at'],
            'category_id'  => $data['category_id']
        ]);
    }

    public function updateBook(array $data, $bookId)
    {
        $book = Book::findOrFail($bookId);
        $book->update([
            'title'        => isset($data['title']) ? $data['title'] : $book->title,
            'author'       => isset($data['author']) ? $data['author'] : $book->author,
            'published_at' => isset($data['published_at']) ? $data['published_at'] : $book->published_at,
            'is_active'    => isset($data['is_active']) ? $data['is_active'] : $book->is_active,
            'category_id'  => isset($data['category_id']) ? $data['category_id'] : $book->category_id
        ]);
        return $book;
    }

    public function showById($bookId)
    {

        $book = Book::findOrFail($bookId);
        return $book;
    }

    public function deleteBook($bookId)
    {
        $book = Book::findOrFail($bookId);
        $book->delete();
    }
}
