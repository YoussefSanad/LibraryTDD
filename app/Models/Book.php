<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = $this->checkIfAuthorIdIsGivenAndExisting($author) ?
            $author : Author::firstOrCreate(['name' => $author])->id;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function checkout(User $user)
    {
        if($this->isCheckedout()) throw new \Exception();
        $this->reservations()->create([
            'user_id'     => $user->id,
            'checkout_at' => now()
        ]);
    }

    public function checkin(User $user)
    {
        $reservation = $this->reservations()->whereUserId($user->id)->whereNull('checkin_at')->first();
        if (is_null($reservation)) throw new \Exception();
        $reservation->update(['checkin_at' => now()]);
    }

    public function path()
    {
        return "/books/$this->id";
    }

    private function checkIfAuthorIdIsGivenAndExisting($id)
    {
        return Author::find($id) ? true : false;
    }

    private function isCheckedout()
    {
        return $this->reservations()->whereNull('checkin_at')->first() ? true : false;
    }
}
