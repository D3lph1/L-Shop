{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="btn btn-warning disabled"><i class="fa fa-chevron-left"></i></a>
        @else
            <a class="btn btn-warning" href="{{ $paginator->previousPageUrl() }}"><i class="fa fa-chevron-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a class="btn btn-warning disabled"><i class="fa fa-ellipsis-h"></i></a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page === $paginator->currentPage())
                        <a class="btn btn-warning disabled">{{ $page }}</a>
                    @else
                        <a class="btn btn-warning" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="btn btn-warning" href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-chevron-right"></i></a>
        @else
            <a class="btn btn-warning disabled"><i class="fa fa-chevron-right"></i></a>
        @endif
    </div>
@endif