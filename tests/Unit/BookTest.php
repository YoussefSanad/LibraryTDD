<?php

namespace Tests\Unit;

use App\Models\Models\Author;
use App\Models\Models\Book;
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
}
