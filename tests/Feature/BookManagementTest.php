<?php

namespace Tests\Feature;

use App\Models\Models\Author;
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

        $response = $this->post('/books', $this->data());
        $this->assertCount(1, Book::all());
        $book = Book::first();
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_title_is_required()
    {
        $response = $this->post('/books', $this->data(''));
        $response->assertSessionHasErrors('title');
    }


    /** @test */
    public function an_author_id_is_required()
    {
        $response = $this->post('/books', $this->data('Cool Title', ''));
        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->post('/books', $this->data());
        $book = Book::first();
        $response = $this->patch("/books/$book->id", $this->data('Updated Book Title', 'Updated Author'));
        $book->refresh();

        $this->assertEquals('Updated Book Title', $book->title);
        $this->assertEquals(2, $book->author_id);
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->post('/books', $this->data());
        $book = Book::first();
        $response = $this->delete("/books/$book->id");
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');

    }

    /** @test */
    public function a_new_author_is_automatically_added_with_book()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', $this->data());
        $book = Book::first();
        $author = Author::first();
        $this->assertCount(1, Author::all());
        $this->assertEquals($author->id, $book->author_id);
    }

    /** @test */
    public function new_book_with_same_author()
    {
        $this->post('/books', $this->data());
        $this->post('/books', $this->data('Another Title'));
        self::assertCount(1, Author::all());
    }


    /**
     * @param string $title
     * @param string $author
     * @return array
     */
    protected function data($title = 'Cool Book', $author = 'Sanad')
    {
        return [
            'title'     => $title,
            'author_id' => $author
        ];
    }
}
