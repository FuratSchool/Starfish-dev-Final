{{-- Pagination party! --}}
<ul class="pagination">
    {{-- Previous page --}}
    <li class="{{ ($page==1)?'disabled':'' }}">
        <a href="{{ ($page != 1)?route($routeName, ['page' => $page-1]):'' }}" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
        </a>
    </li>
    {{-- First page will always be displayed --}}
    <li class="{{ ($page==1)?'active':'' }}">
        <a href="{{ route($routeName, ['page' => 1]) }}">1</a>
    </li>

    {{-- If there are more pages before the active page, use ...'s to show there are more --}}
    @if($page > 4)
        <li><span>...</span></li>
    @endif

    {{-- Now we generate a couple of page points. But don't generate <= 1 and >= $pages --}}
    @for($i = $page-2; $i < $page+3; $i++)
        @continue($i <= 1 || $i >= $pages)
        <li class="{{ ($page == $i)?' active':'' }}">
            <a href="{{ route($routeName, ['page' => $i]) }}">{{ $i }}</a>
        </li>
    @endfor

    {{-- If there are more pages after the active page, use ...'s to show there are more --}}
    @if($page+3 < $pages)
        <li><span>...</span></li>
    @endif

    {{-- Unless the amount of pages == 1, we want to always display the last page --}}
    @unless($pages == 1)
        <li class="{{ ($page==$pages)?' active':'' }}">
            <a href="{{ route($routeName, ['page' => $pages]) }}">{{ $pages }}</a>
        </li>
    @endunless

    {{-- Next page --}}
    <li class="{{ ($page==$pages)?'disabled':'' }}">
        @if($page == $pages)
            <span aria-hidden="true">&raquo;</span>
        @else
            <a href="{{ route($routeName, ['page' => $page+1]) }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        @endif
    </li>
</ul>