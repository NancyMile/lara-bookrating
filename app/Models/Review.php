<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable= ['review','rating'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    //clear the cache when a change happens
    protected static function booted()
    {
        // when a modification is done to a model, // if you use mass assignment,or you use raw query  it wont be trigger,
        // in database transaction if wont be trigger if the transaction is rolled back
        //So if you load the model and then modify.. this may be trigged
        static::updated(fn(Review $review) =>  cache()->forget('book:'.$review->book_id));
        static::deleted(fn(Review $review) => cache()->forget('book:'.$review->book_id));
    }
}
