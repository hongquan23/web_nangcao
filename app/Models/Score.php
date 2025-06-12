<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Score extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'flashcard_set_id', 'total_questions', 'correct_answers'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flashcardSet()
    {
        return $this->belongsTo(FlashcardSet::class);
    }
}
