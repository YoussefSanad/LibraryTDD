<?php

namespace Tests\Unit;

use App\Models\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function add_author_without_dob()
    {
        Author::firstOrCreate(['name' => 'John Doe']);
        self::assertCount(1, Author::all());
    }
}
