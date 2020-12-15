<?php
/**
 * Created by PhpStorm.
 * User: Sanad
 * Date: 12/14/2020
 * Time: 3:40 PM
 */

namespace App\Http\Controllers;


use App\Models\Author;

class AuthorController extends Controller
{
    const INDEX_ROUTE = '/authors';
    public function store()
    {
        $author = Author::create($this->validateRequestData());
        return redirect($author->path());
    }

    public function update(Author $author)
    {
        $author->update($this->validateRequestData());
        return redirect($author->path());
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect(self::INDEX_ROUTE);
    }

    /**
     * @return array
     */
    public function validateRequestData()
    {
        $data = request()->validate([
            'name'  => 'required',
            'dob' => 'required'
        ]);
        return $data;
    }
}