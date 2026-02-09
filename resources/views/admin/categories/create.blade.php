@extends('layout.admin-layout')
@section('content')
    <p>Create new category</p>
    <form action='/categories' method='post' enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ old('name') }}">

            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description">Description:</label>
            <input type="text" name="description" value="{{ old('description') }}">

            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="image">Image:</label>
            <input type="file" name="image" id="imageInput" accept="image/*">
            <img id="preview" style="display:none; max-width:200px; margin-top:10px;">

            @error('image')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="">
            <label for="parent_id">Parent Category:</label>
            <select name="parent_id">
                <option value="">No Parent</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach

            </select>

            @foreach ($categories as $category)
                <option value="{{ $category->id }}"> {{ str_repeat('--', $level ?? 0) }} {{ $category->name }} </option>
                @if ($category->childrenRecursive)
                    @include('admin.categories.option', [
                        'categories' => $category->childrenRecursive,
                        'level' => ($level ?? 0) + 1,
                    ])
                @endif
            @endforeach

            @error('parent_id')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <input type="submit">
    </form>

    <a href="{{ route('categories.index') }}">Back to categories</a>

    <script>
        const input = document.getElementById('imageInput');
        const preview = document.getElementById('preview');

        input.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
@endsection
