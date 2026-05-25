@extends('notes.layout')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Редактирование заметки</h1>

        <form method="POST" action="{{ route('notes.update', $note) }}" x-data="{ color: '{{ old('color', $note->color) }}' }">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Заголовок</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $note->title) }}"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                >
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Содержимое</label>
                <textarea
                    name="content"
                    rows="5"
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                >{{ old('content', $note->content) }}</textarea>
                @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Цвет</label>
                <div class="flex gap-3">
                    @foreach(['#6366f1', '#f43f5e', '#10b981', '#f59e0b', '#3b82f6', '#8b5cf6'] as $hex)
                        <button
                            type="button"
                            @click="color = '{{ $hex }}'"
                            class="w-8 h-8 rounded-full border-2 transition"
                            :class="color === '{{ $hex }}' ? 'border-gray-800 scale-110' : 'border-transparent'"
                            style="background-color: {{ $hex }}"
                        ></button>
                    @endforeach
                </div>
                <input type="hidden" name="color" :value="color">
                @error('color')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                    Сохранить
                </button>
                <a href="{{ route('notes.index') }}" class="px-6 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Отмена
                </a>
            </div>
        </form>
    </div>
@endsection
