@if ($paginator->lastPage() > 1)
<nav>
    <ul class="pagination">
        <!-- {{-- 上一页按钮 --}} -->
        @if($paginator->currentPage() > 1)
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                <span>&laquo;</span>
            </a>
        </li>
        @else
        <li class="page-item disabled">
            <a class="page-link" href="#"><span>&laquo;</span></a>
        </li>
        @endif

        <!-- {{-- 显示第一页 --}} -->
        @if($paginator->currentPage() - 3 >= 1)
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
        </li>
        @endif

        <!-- {{-- 如果当前页前还有更多页，则显示省略号 --}} -->
        @if($paginator->currentPage() - 4 >= 1)
        <li class="page-item disabled">
            <a class="page-link" href="#"><span>...</span></a>
        </li>
        @endif

        <!-- {{-- 显示当前页之前的页码链接 --}} -->
        @for($p = max(1, $paginator->currentPage() - 2); $p <= max(0, $paginator->currentPage() - 1); $p++)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($p) }}">{{ $p }}</a>
            </li>
            @endfor

            <!-- {{-- 显示当前页码 --}} -->

            <li class="page-item active">
                <a class="page-link" href="javascript:">{{ $paginator->currentPage() }}</a>
            </li>

            <!-- {{-- 显示当前页之后的页码链接 --}} -->
            @for($p = $paginator->currentPage() + 1; $p <= min($paginator->lastPage(), $paginator->currentPage() + 2); $p++)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($p) }}">{{ $p }}</a>
                </li>
                @endfor

                <!-- {{-- 如果当前页后还有更多页，则显示省略号 --}} -->
                @if($paginator->currentPage() + 4 <= $paginator->lastPage())
                    <li class="page-item disabled">
                        <a class="page-link" href="#"><span>...</span></a>
                    </li>
                    @endif

                    <!-- {{-- 显示最后一页 --}} -->
                    @if($paginator->currentPage() + 3 <= $paginator->lastPage())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                        </li>
                        @endif

                        <!-- {{-- 下一页按钮 --}} -->
                        @if($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">&raquo;</a>
                        </li>
                        @else
                        <li class="page-item disabled">
                            <a class="page-link" href="#"><span>&raquo;</span></a>
                        </li>
                        @endif
    </ul>
</nav>
@endif