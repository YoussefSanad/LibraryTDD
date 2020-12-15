<?php

namespace Tests\Feature;

use App\Models\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        
        $response = $this->addBook();
        $this->assertCount(1, Book::all());
        $book = Book::first();
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required()
    {
        $response = $this->addBook('');
        $response->assertSessionHasErrors('title');
    }


    /** @test */
    public function an_author_is_required()
    {
        $response = $this->addBook('Cool Title', '');
        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->addBook();
        $book = Book::first();
        $response = $this->patch("/books/$book->id", [
            'title'  => 'Updated Book Title',
            'author' => 'Updated Author'
        ]);
        $book = Book::first();
        $this->assertEquals('Updated Book Title', $book->title);
        $this->assertEquals('Updated Author', $book->author);
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->addBook();
        $book = Book::first();
        $response = $this->delete("/books/$book->id");
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');

    }

    /**
     * @param string $title
     * @param string $author
     * @return \Illuminate\Testing\TestResponse
     */
    protected function addBook($title = 'Cool Book', $author = 'Sanad')
    {
        $response = $this->post('/books', [
            'title'  => $title,
            'author' => $author
        ]);
        return $response;
    }
}
