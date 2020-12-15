<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservatioTest extends TestCase
{
    use RefreshDatabase;
    protected $book;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->book = Book::factory()->create();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function a_book_can_be_checked_out()
    {
        $this->book->checkout($this->user);
        self::assertCount(1, Reservation::all());
        $reservation = Reservation::first();
        self::assertEquals($reservation->user_id, $this->user->id);
        self::assertEquals($reservation->book_id, $this->book->id);
        self::assertEquals($reservation->checkout_at, now());
    }

    /** @test */
    public function a_book_can_be_checked_in()
    {
        $this->book->checkout($this->user);
        $this->book->checkin($this->user);
        $reservation = Reservation::first();
        self::assertEquals($reservation->checkin_at, now());
    }

    /** @test */
    public function a_book_cant_be_checked_in_without_being_checked_out()
    {
        $this->expectException(\Exception::class);
        $this->book->checkin($this->user);
    }

    /** @test */
    public function a_user_can_check_a_book_out_more_than_once_after_checking_it_in()
    {
        $this->book->checkout($this->user);
        $this->book->checkin($this->user);
        $lastReservation = Reservation::first();
        self::assertNotNull($lastReservation->checkin_at);

        $this->book->checkout($this->user);
        self::assertCount(2, Reservation::all());

        $lastReservation = Reservation::whereUserId($this->user->id)->whereNull('checkin_at')->first();
        self::assertEquals($this->user->id, $lastReservation->user_id);
        self::assertEquals($this->book->id, $lastReservation->book_id);
        self::assertNull($lastReservation->checkin_at);

        $this->book->checkin($this->user);
        $lastReservation->refresh();
        self::assertNotNull($lastReservation->checkin_at);

    }

    /** @test */
    public function cant_checkout_a_book_twice_without_checkin()
    {
        $this->expectException(\Exception::class);
        $this->book->checkout($this->user);
        $this->book->checkout($this->user);
    }
}
