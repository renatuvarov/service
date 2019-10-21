@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination-item" aria-disabled="true">
                    <span class="pagination-disabled pagination-link" aria-hidden="true">
                        <span class="pagination-inner">&lsaquo;&lsaquo;</span>
                    </span>
                </li>
                <li class="pagination-item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="pagination-disabled pagination-link" aria-hidden="true">
                        <span class="pagination-inner">&lsaquo;</span>
                    </span>
                </li>
            @else
                <li class="pagination-item">
                    <a class="pagination-link"
                       href="{{ $paginator->toArray()['first_page_url'] }}"
                       title="К началу">
                        <span class="pagination-inner">&lsaquo;&lsaquo;</span>
                    </a>
                </li>
                <li class="pagination-item">
                    <a class="pagination-link"
                       href="{{ $paginator->previousPageUrl() }}"
                       rel="prev"
                       aria-label="@lang('pagination.previous')"  title="Назад">
                        <span class="pagination-inner">&lsaquo;</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="pagination-item" aria-disabled="true">
                        <span class="pagination-disabled pagination-link">
                            <span class="pagination-inner">{{ $element }}</span>
                        </span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination-item" aria-current="page">
                                <span class="pagination-active pagination-link">
                                    <span class="pagination-inner">{{ $page }}</span>
                                </span>
                            </li>
                        @else
                            <li class="pagination-item">
                                <a class="pagination-link" href="{{ $url }}">
                                    <span class="pagination-inner">{{ $page }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination-item">
                    <a class="pagination-link"
                       href="{{ $paginator->nextPageUrl() }}"
                       rel="next"
                       aria-label="@lang('pagination.next')" title="Вперед">
                        <span class="pagination-inner">&rsaquo;</span>
                    </a>
                </li>
                <li class="pagination-item">
                    <a class="pagination-link"
                       href="{{ $paginator->toArray()['last_page_url'] }}"
                       title="В конец">
                        <span class="pagination-inner">&rsaquo;&rsaquo;</span>
                    </a>
                </li>
            @else
                <li class="pagination-item" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="pagination-disabled pagination-link" aria-hidden="true">
                        <span class="pagination-inner">&rsaquo;</span>
                    </span>
                </li>
                <li class="pagination-item" aria-disabled="true">
                    <span class="pagination-disabled pagination-link" aria-hidden="true">
                        <span class="pagination-inner">&rsaquo;&rsaquo;</span>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
