<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FlashcardSetController;
use App\Http\Controllers\FlashcardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Nhóm route yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes cho FlashcardSet (bộ flashcard)
    Route::get('/sets', [FlashcardSetController::class, 'index'])->name('sets.index');              // danh sách bộ flashcard
    Route::get('/sets/create', [FlashcardSetController::class, 'create'])->name('sets.create');    // form tạo mới bộ flashcard
    Route::post('/sets', [FlashcardSetController::class, 'store'])->name('sets.store');             // lưu bộ flashcard mới
    Route::get('/sets/{set}/edit', [FlashcardSetController::class, 'edit'])->name('sets.edit');    // form chỉnh sửa bộ flashcard
    Route::put('/sets/{set}', [FlashcardSetController::class, 'update'])->name('sets.update');     // cập nhật bộ flashcard
    Route::delete('/sets/{set}', [FlashcardSetController::class, 'destroy'])->name('sets.destroy'); // xóa bộ flashcard
    Route::get('/sets/{set}/write', [FlashcardSetController::class, 'showWriting'])->name('sets.write');
    Route::post('/sets/{set}/write', [FlashcardSetController::class, 'submitWriting'])->name('sets.submitWriting');
    Route::get('/sets/{set}/write', [FlashcardSetController::class, 'showWriting'])->name('sets.showWriting');
    Route::get('/sets/{id}/chart', [FlashcardSetController::class, 'chart'])->name('sets.chart');


    // Routes cho Flashcard (thẻ flashcard) trong FlashcardSet
    Route::get('/sets/{set}/flashcards', [FlashcardController::class, 'index'])->name('flashcards.index');           // danh sách flashcard trong bộ
    Route::get('/sets/{set}/flashcards/create', [FlashcardController::class, 'create'])->name('flashcards.create');   // form tạo mới flashcard
    Route::post('/sets/{set}/flashcards', [FlashcardController::class, 'store'])->name('flashcards.store');          // lưu flashcard mới
    Route::get('/sets/{set}/flashcards/study', [FlashcardController::class, 'study'])->name('flashcards.study');
    Route::get('/sets/{set}/flashcards/{flashcard}/edit', [FlashcardController::class, 'edit'])->name('flashcards.edit');
    Route::put('/sets/{set}/flashcards', [FlashcardController::class, 'update'])->name('flashcards.update');
    Route::delete('/sets/{set}/flashcards/{flashcard}', [FlashcardController::class, 'destroy'])->name('flashcards.destroy');   // xóa flashcard
});

require __DIR__.'/auth.php';
