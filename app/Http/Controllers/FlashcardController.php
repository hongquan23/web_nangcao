<?php

namespace App\Http\Controllers;

use App\Models\FlashcardSet;
use App\Models\Flashcard;
use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    public function __construct()
    {
        // Yêu cầu đăng nhập
        $this->middleware('auth');
    }

    // Danh sách flashcards trong 1 bộ
    public function index(FlashcardSet $set)
    {
        // $this->authorize('view', $set);

        $flashcards = $set->flashcards()->paginate(15);

        return view('flashcards.index', compact('set', 'flashcards'));
    }

    public function study(FlashcardSet $set)
{
    // $this->authorize('view', $set); // nếu có chính sách phân quyền

    // Lấy tất cả flashcards trong bộ (không phân trang để học toàn bộ)
    $flashcards = $set->flashcards()->get();

    return view('flashcards.study', compact('set', 'flashcards'));
}

    // Form tạo mới flashcard trong set
    public function create(FlashcardSet $set)
    {
        // $this->authorize('update', $set);

        return view('flashcards.create', compact('set'));
    }

    // Lưu flashcard mới
    public function store(Request $request, FlashcardSet $set)
    {
        // $this->authorize('update', $set);

        $data = $request->validate([
            'term' => 'required|string|max:1000',
            'definition' => 'required|string|max:1000',
        ]);

        $set->flashcards()->create($data);

        return redirect()->route('flashcards.index', $set->id)->with('success', 'Flashcard created successfully.');
    }

    // Form chỉnh sửa flashcard
    public function edit(FlashcardSet $set, Flashcard $flashcard)
    {
        // $set = $flashcardSet->set;

        return view('flashcards.edit', compact('set', 'flashcard'));
    }

    // Cập nhật flashcard
  public function update(Request $request, FlashcardSet $set, Flashcard $flashcard)
{
    // $this->authorize('update', $set); // Nếu bạn có policy thì bật lên

    $data = $request->validate([
        'term' => 'required|string|max:1000',
        'definition' => 'required|string|max:1000',
    ]);

     $set->flashcards()->update($data);

    return redirect()->route('flashcards.index', ['set' => $set->id])
                     ->with('success', 'Flashcard updated successfully.');
}

// Xoá flashcard
public function destroy(FlashcardSet $set, Flashcard $flashcard)
{
    // $this->authorize('update', $set);

    $flashcard->delete();

        return redirect()->route('flashcards.index', ['set' => $set->id])->with('success', 'Flashcard deleted successfully.');

    }
}
