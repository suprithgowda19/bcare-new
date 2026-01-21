@if ($paginator->hasPages())
    <nav aria-label="pagination-demo">
        <ul class="pagination justify-content-center">
            
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-xs color-black bg-transparent bg-theme shadow-xl border-0 opacity-30">
                        <i class="fa fa-angle-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-xs color-black bg-transparent bg-theme shadow-xl border-0" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- Active Page (Highlighted) --}}
                            <li class="page-item active" aria-current="page">
                                <a class="page-link rounded-xs bg-highlight shadow-l border-0 text-white" href="#">{{ $page }}</a>
                            </li>
                        @else
                            {{-- Other Pages --}}
                            <li class="page-item">
                                <a class="page-link rounded-xs color-black bg-theme shadow-l border-0" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-xs color-black bg-transparent bg-theme shadow-l border-0" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link rounded-xs color-black bg-transparent bg-theme shadow-l border-0 opacity-30">
                        <i class="fa fa-angle-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif