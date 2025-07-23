<?php

namespace App\Models;

use App\Models\BookCopy;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model implements JWTSubject
{
    /**
     * Get the identifier that will be stored in the JWT token.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return an array with custom claims to be added to the JWT token.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    use HasFactory;

    // public $timestamps = false;
    protected $fillable = [
        'title',
        'author',
        'category',
        'isbn',
        'added_date',
    ];

    /**
     * Appends the function status
     * @var array
     */
    protected $appends = ['status'];

    public function bookCopies()
    {
        return $this->hasMany(BookCopy::class);
    }

    /**
     * Attribute function
     * @return Attribute
     */
    public function status(): Attribute
    {
        return Attribute::get(function () {
            return $this->book_copies_count > 0 ? 'Available' : 'Unavailable';
        });
    }
}
