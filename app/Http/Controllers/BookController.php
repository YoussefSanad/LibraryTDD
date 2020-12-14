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
    public function store()
    {
        Book::create($this->validateRequestData());
    }

    public function update(Book $book)
    {
        $book->update($this->validateRequestData());
    }

    /**
     * @return array
     */
    public function validateRequestData()
    {
        $data = request()->validate([
            'title'  => 'required',
            'author' => 'required'
        ]);
        return $data;
    }
}