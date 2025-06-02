<?php

namespace App\Http\Controllers;

use App\Models\FlashcardSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashcardSetController extends Controller
{
    public function __construct()
    {
        // Bảo vệ tất cả route phải đăng nhập
        $this->middleware('auth');
    }

    // Hiển thị danh sách bộ flashcard của user hiện tại
    public function index()
    {
        $sets = Auth::user()->flashcardSets()->latest()->paginate(10);
        return view('sets.index', compact('sets'));
    }

    // Form tạo mới
    public function create()
    {
        return view('sets.create');
    }

    // Lưu bộ flashcard mới
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Auth::user()->flashcardSets()->create($data);

        return redirect()->route('sets.index')->with('success', 'Flashcard set created successfully.');
    }

    // Hiển thị chi tiết bộ flashcard cùng flashcards bên trong
    public function show(FlashcardSet $set)
    {
        // $this->authorize('view', $set); // kiểm tra quyền (nếu có policy)

        $set->load('flashcards'); // eager load flashcards

        return view('sets.show', compact('set'));
    }

    // Form chỉnh sửa bộ flashcard
    public function edit(FlashcardSet $set)
    {
        

        return view('sets.edit', compact('set'));
    }

    // Cập nhật bộ flashcard
    public function update(Request $request, FlashcardSet $set)
    {
        // $this->authorize('update', $set);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $set->update($data);

        return redirect()->route('sets.index')->with('success', 'Flashcard set updated successfully.');
    }

    // Xoá bộ flashcard
    public function destroy(FlashcardSet $set)
    {
        // $this->authorize('delete', $set);

        $set->delete();

        return redirect()->route('sets.index')->with('success', 'Flashcard set deleted successfully.');
    }
}
