<?php

namespace Tests\Feature;

use App\Models\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created()
    {
        $response = $this->post('/authors', [
            'name' => 'Sanad',
            'dob'  => '5/15/1960'
        ]);
        $this->assertCount(1, Author::all());
        $author = Author::first();
        $response->assertRedirect($author->path());
        $this->assertInstanceOf(Carbon::class, $author->dob);
        $this->assertEquals('15/05/1960', Carbon::parse($author->dob)->format('d/m/Y'));
    }
}
