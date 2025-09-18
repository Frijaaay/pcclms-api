<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class BookCopy extends Model implements JWTSubject
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

    protected $fillable = [
        'book_id',
        'condition',
        'status'
    ];

    // ORM Relationships
    public function book()
    {
        return $this->belongsTo(Book::class); // Many to One Relationship
    }

    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class);
    }
}
