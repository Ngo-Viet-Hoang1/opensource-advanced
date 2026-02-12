@if (!in_array($category->id, $excludeIds ?? []))
    <option value="{{ $category->id }}" {{ $selected == $category->id ? 'selected' : '' }}>
        {{ str_repeat('—', $level) }} {{ $category->name }}
    </option>
@endif

@if ($category->childrenRecursive->count())
    @foreach ($category->childrenRecursive as $child)
        @include('admin.categories.option', [
            'category' => $child,
            'level' => $level + 1,
            'selected' => $selected ?? null,
            'excludeIds' => $excludeIds ?? [],
        ])
    @endforeach
@endif
