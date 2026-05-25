<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    private function checkOwner(Note $note): void
    {
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }
    }

    public function index(Request $request)
    {
        $query = Note::where('user_id', auth()->id())
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $notes = $query->paginate(20);

        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|max:255',
            'content' => 'nullable|string',
            'color'   => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['color'] = $validated['color'] ?? '#6366f1';

        Note::create($validated);

        return redirect()->route('notes.index')->with('success', 'Заметка создана');
    }

    public function edit(Note $note)
    {
        $this->checkOwner($note);

        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $this->checkOwner($note);

        $validated = $request->validate([
            'title'   => 'required|max:255',
            'content' => 'nullable|string',
            'color'   => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $validated['color'] = $validated['color'] ?? '#6366f1';

        $note->update($validated);

        return redirect()->route('notes.index')->with('success', 'Заметка обновлена');
    }

    public function destroy(Note $note)
    {
        $this->checkOwner($note);
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Заметка удалена');
    }

    public function togglePin(Note $note)
    {
        $this->checkOwner($note);
        $note->update(['is_pinned' => !$note->is_pinned]);

        return response()->json(['is_pinned' => $note->is_pinned]);
    }
}
