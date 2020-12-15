<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_new_author_from_book()
    {
        Book::create(['title' => 'John Doe', 'author_id' => 'John Doe']);
        self::assertCount(1, Author::all());
    }

    /** @test */
    public function book_factory_creates_a_book_and_an_author()
    {
        $book = Book::factory()->create();
        $this->assertCount(1, Author::all());
        $this->assertCount(1, Book::all());
        $author = Author::first();
        $this->assertEquals($book->author_id, $author->id);

    }

    /** @test */
    public function not_creating_author_when_given_an_existing_author_id()
    {
        Author::factory()->create();
        Book::factory()->create(['author_id' => 1]);
        $this->assertCount(1, Author::all());
    }

    /** @test */
    public function creating_author_when_given_a_non_existing_author_id()
    {
        Author::factory()->create();
        Book::factory()->create(['author_id' => 2]);
        $this->assertCount(2, Author::all());
    }


}
