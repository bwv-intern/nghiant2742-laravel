<nav class="d-flex flex-wrap justify-content-between align-items-end mt-5 mb-2">
    <label>Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries</label>
    <ul class="pagination gap-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="btn btn-light border disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true">First</span>
            </li>
            <li class="btn btn-light border disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true">&lsaquo;</span>
            </li>
        @else
            <li >
                <a class="btn btn-light border" href="{{ $paginator->url(1) }}">First</a>
            </li>
            <li>
                <a class="btn btn-light border" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="btn disabled btn-light border active" aria-current="page" class="btn btn-light border"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}" class="btn btn-light border">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a class="btn btn-light border" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
            <li >
                <a class="btn btn-light border" href="{{ $paginator->url($paginator->lastPage()) }}">Last</a>
            </li>
        @else
            <li class="btn btn-light border disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span aria-hidden="true">&rsaquo;</span>
            </li>
            <li class="btn btn-light border disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true">Last</span>
            </li>
        @endif
    </ul>
</nav>
