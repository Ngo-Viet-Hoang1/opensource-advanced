@foreach ($categories as $category)
    <li class="dropdown-submenu">
        <a class="dropdown-item dropdown-toggle" href="#">
            {{ $category->name }}
        </a>

        @if ($category->childrenRecursive->count())
            <ul class="dropdown-menu">
                @include('components.category-tree', ['categories' => $category->childrenRecursive])
            </ul>
        @endif
    </li>
@endforeach
