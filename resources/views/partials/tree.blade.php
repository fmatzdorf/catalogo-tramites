@foreach($categories as $category)
    <div class="category-item" style="margin-left: {{ $level * 20 }}px;">
        <div class="flex items-center justify-between py-2 px-3 border-l-4 border-blue-500 bg-white rounded mb-1">
            <div class="flex items-center">
                <span class="text-gray-600 mr-2">
                    @if($level > 0)
                        @for($i = 0; $i < $level; $i++)
                            <span class="text-gray-400">│</span>
                        @endfor
                        <span class="text-gray-400">├─</span>
                    @endif
                </span>
                <span class="font-medium text-gray-900">{{ $category->name }}</span>
            </div>
            <div class="flex space-x-2">
                @can('update', $category)
                    <a href="{{ route('categories.edit', $category) }}"
                       class="text-indigo-600 hover:text-indigo-900 text-sm"
                       title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                @endcan
            </div>
        </div>

        @if($category->children->isNotEmpty())
            @include('categories.partials.tree', ['categories' => $category->children, 'level' => $level + 1])
        @endif
    </div>
@endforeach
