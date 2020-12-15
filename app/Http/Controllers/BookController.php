<?php
/**
 * Created by PhpStorm.
 * User: Sanad
 * Date: 12/14/2020
 * Time: 3:40 PM
 */

namespace App\Http\Controllers;


use App\Models\Models\Book;

class BookController extends Controller
{
    const INDEX_ROUTE = '/books';

    public function store()
    {
        $book = Book::create($this->validateRequestData());
        return redirect($book->path());
    }

    public function update(Book $book)
    {
        $book->update($this->validateRequestData());
        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect(self::INDEX_ROUTE);
    }

    /**
     * @return array
     */
    public function validateRequestData()
    {
        $data = request()->validate([
            'title'     => 'required',
            'author_id' => 'required'
        ]);
        return $data;
    }
}