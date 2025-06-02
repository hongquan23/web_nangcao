<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = ['term', 'definition', 'flashcard_set_id'];

    public function flashcardSet()
    {
        return $this->belongsTo(FlashcardSet::class);
    }
}

