<?php

namespace App\Models;

use App\Models\BookCopy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    use HasFactory, SoftDeletes;

    // public $timestamps = false;
    protected $fillable = [
        'title',
        'author',
        'author_1',
        'author_2',
        'author_3',
        'isbn',
        'category',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Appends the function status
     * @var array
     */

    public function bookCopies()
    {
        return $this->hasMany(BookCopy::class);
    }

    public function availableBookCopies()
    {
        return $this->hasMany(BookCopy::class)->where('status', 'Available');
    }

    protected $appends = ['status'];
    /**
     * Attribute function
     * @return Attribute
    */
    public function status(): Attribute
    {
        return Attribute::get(function () {
            return $this->availableBookCopies()
                        ->count() > 0 ? 'Available' : 'Unavailable';
        });
    }
}
