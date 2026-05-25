@extends('notes.layout')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Мои заметки</h1>
        <a href="{{ route('notes.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + Новая заметка
        </a>
    </div>

    <form method="GET" action="{{ route('notes.index') }}" class="mb-6">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Поиск по заголовку..."
            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
        >
    </form>

    @if($notes->isEmpty())
        <p class="text-gray-500">Заметок пока нет.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($notes as $note)
                <div
                    x-data="{ pinned: {{ $note->is_pinned ? 'true' : 'false' }} }"
                    class="bg-white rounded shadow overflow-hidden flex flex-col"
                >
                    <div class="h-2" style="background-color: {{ $note->color }}"></div>

                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="font-semibold text-gray-800 text-lg">{{ $note->title }}</h2>

                            <button
                                @click="fetch('{{ route('notes.togglePin', $note) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json'
                                        }
                                    })
                                    .then(res => res.json())
                                    .then(data => { pinned = data.is_pinned })"
                                class="text-xl ml-2"
                                :title="pinned ? 'Открепить' : 'Закрепить'"
                            >
                                <span x-text="pinned ? '📌' : '📍'"></span>
                            </button>
                        </div>

                        <p class="text-gray-600 text-sm flex-1">{{ Str::limit($note->content, 100) }}</p>

                        <div class="flex justify-end gap-2 mt-4">
                            <a href="{{ route('notes.edit', $note) }}" class="text-sm text-indigo-600 hover:underline">
                                Редактировать
                            </a>

                            <form method="POST" action="{{ route('notes.destroy', $note) }}">
                                @csrf
                                <button type="submit" class="text-sm text-red-500 hover:underline"
                                        onclick="return confirm('Удалить заметку?')">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $notes->links() }}
        </div>
    @endif
@endsection
