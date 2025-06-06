@if ($paginator->hasPages())
    <nav class="flex justify-center mt-4" role="navigation" aria-label="Pagination Navigation">
        {{-- The main container now has a border, and individual items will have right borders --}}
        <ul class="inline-flex items-center border border-gray-300 bg-white shadow-sm text-sm font-medium overflow-hidden" style="border-radius: 10px;">

            {{-- Tombol Start --}}
            <li>
                @if (!$paginator->onFirstPage())
                    <a href="{{ $paginator->url(1) }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 border-r border-gray-300 h-full">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Start
                    </a>
                @else
                    <span class="flex items-center px-4 py-2 text-gray-400 border-r border-gray-300 h-full cursor-not-allowed">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Start
                    </span>
                @endif
            </li>

            {{-- Logic: tampilkan 1 ... current-1, current, current+1 ... last --}}
            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $range = 2; // Number of pages to show before and after the current page
                $startPage = max(1, $current - $range);
                $endPage = min($last, $current + $range);
            @endphp

            {{-- Page 1 --}}
            @if ($startPage > 1)
                <li>
                    <a href="{{ $paginator->url(1) }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 border-r border-gray-300 h-full">1</a>
                </li>
            @endif

            {{-- Titik-titik sebelumnya --}}
            @if ($startPage > 2)
                <li><span class="px-4 py-2 text-gray-500 border-r border-gray-300 h-full">...</span></li>
            @endif

            {{-- Halaman nomor --}}
            @for ($i = $startPage; $i <= $endPage; $i++)
                <li>
                    @if ($i == $current)
                        <span class="px-4 py-2 bg-gray-200 text-gray-900 font-semibold border-r border-gray-300 h-full">
                            {{ $i }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($i) }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 border-r border-gray-300 h-full">
                            {{ $i }}
                        </a>
                    @endif
                </li>
            @endfor

            {{-- Titik-titik sesudah --}}
            @if ($endPage < $last - 1)
                <li><span class="px-4 py-2 text-gray-500 border-r border-gray-300 h-full">...</span></li>
            @endif

            {{-- Halaman terakhir --}}
            @if ($endPage < $last)
                <li>
                    <a href="{{ $paginator->url($last) }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 border-r border-gray-300 h-full">
                        {{ $last }}
                    </a>
                </li>
            @endif

            {{-- Tombol End --}}
            <li>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->url($last) }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 h-full">
                        End
                        <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                @else
                    <span class="flex items-center px-4 py-2 text-gray-400 h-full cursor-not-allowed">
                        End
                        <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </span>
                @endif
            </li>
        </ul>
    </nav>
@endif