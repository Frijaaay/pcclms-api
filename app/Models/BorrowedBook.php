<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\ReturnedBook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BorrowedBook extends Model
{
    /** @use HasFactory<\Database\Factories\BorrowedBooksFactory> */
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
    * Assign a custom unique ID to each new BorrowedBooks record.
    */
    protected static function booted()
    {
        static::creating(function ($model) {
            if(empty($model->id)) {
                $date = now()->format('Ymd');
                $random = substr(str_replace('-', '', Str::uuid()->toString()), 0, 8); // Generate an 8-character random string from a UUID for uniqueness
                $id = "BRW-{$date}-{$random}";

                $model->id = $id;
            }
        });
    }

    /** Eloquent ORM */
    public function returnRecord()
    {
        return $this->hasOne(ReturnedBook::class);
    }
}
