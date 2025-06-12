<?php

namespace App\Http\Controllers;

use App\Models\FlashcardSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Score;


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
    $user = Auth::user();

    // Lấy danh sách bộ flashcard + đếm số từ
    $sets = $user->flashcardSets()
        ->withCount('flashcards') // đếm số từ
        ->with(['scores' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->latest()
        ->paginate(10);

    // Tính toán dữ liệu trung bình cho từng bộ
    foreach ($sets as $set) {
        $userScores = $set->scores;

        $reviewCount = $userScores->count();
        $avgScore = $reviewCount > 0
            ? round($userScores->avg(function ($score) {
                return $score->total_questions > 0
                    ? ($score->correct_answers / $score->total_questions) * 100
                    : 0;
            }))
            : 0;

        $set->avg_review = $reviewCount;
        $set->avg_score = $avgScore;
    }

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


    public function showWriting(FlashcardSet $set)
{
    $flashcards = $set->flashcards;
    return view('sets.write', compact('set', 'flashcards'));
}

public function submitWriting(Request $request, FlashcardSet $set)
{
    $flashcards = $set->flashcards;
    $answers = $request->input('answers', []);
    $correct = 0;
    $results = [];

    foreach ($flashcards as $f) {
        $userAnswer = trim($answers[$f->id] ?? '');
        $isCorrect = strtolower($userAnswer) === strtolower($f->term);

        if ($isCorrect) $correct++;

        $results[] = [
            'term' => $f->term,
            'definition' => $f->definition,
            'user_answer' => $userAnswer,
            'is_correct' => $isCorrect,
        ];
    }

    // Lưu điểm vào bảng scores
    Score::create([
        'user_id' => auth()->id(),
        'flashcard_set_id' => $set->id,
        'total_questions' => $flashcards->count(),
        'correct_answers' => $correct,
    ]);

    // Truyền kết quả qua session
    return redirect()
        ->route('sets.showWriting', $set->id)
        ->with([
            'correct' => $correct,
            'total' => $flashcards->count(),
            'results' => $results,
        ]);
}

public function chart($id)
{
    $userId = Auth::id();

    // Lấy bộ flashcard
    $set = FlashcardSet::findOrFail($id);

    // Lấy 5 lần làm bài gần nhất của user, theo thứ tự thời gian cũ → mới
    $scores = Score::where('user_id', $userId)
        ->where('flashcard_set_id', $id)
        ->latest() // tương đương orderBy('created_at', 'desc')
        ->take(5) // lấy 5 lần làm bài gần nhất
        ->get()
        ->reverse(); // đảo lại để hiển thị từ cũ đến mới

    // Chuẩn bị dữ liệu cho biểu đồ
    $chartData = $scores->map(function ($score) {
        return [
            'date' => $score->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i'),

            'accuracy' => $score->total_questions > 0
                ? round(($score->correct_answers / $score->total_questions) * 100, 2)
                : 0,
        ];
    });

    return view('sets.chart', [
        'set' => $set,
        'chartData' => $chartData
    ]);
}
}
