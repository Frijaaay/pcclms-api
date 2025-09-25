<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnedBook extends Model
{
    /** @use HasFactory<\Database\Factories\ReturnedBooksFactory> */
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'borrowed_book_id',
        'librarian_id',
        'returned_condition',
        'penalty',
        'returned_at'
    ];

    protected $casts = [
        'returned_at' => 'date:M/d/y',
        'due_at' => 'date:M/d/y'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
    * Assign a custom unique ID to each new ReturnedBooks record.
    */
    protected static function booted()
    {
        static::creating(function ($model) {
            if(empty($model->id)) {
                $date = now()->format('Ymd');
                $random = substr(str_replace('-', '', Str::uuid()->toString()), 0, 8); // Generate an 8-character random string from a UUID for uniqueness
                $id = "RTN-{$date}-{$random}";

                $model->id = $id;
            }
        });
    }

    /** Eloquent ORM */
    public function borrowRecord()
    {
        return $this->belongsTo(BorrowedBook::class);
    }
}
