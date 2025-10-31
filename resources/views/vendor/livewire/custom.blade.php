@php
if (!isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false);
$currentPage = $paginator->currentPage();
$lastPage = $paginator->lastPage();
@endphp

@if ($paginator->hasPages())
    <div class="col-12">
        <ul class="paginator">
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                <li class="paginator__item paginator__item--prev">
                    <a style="cursor: pointer" class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" aria-label="@lang('pagination.previous')"><i class="icon ion-ios-arrow-back"></i></a>
                </li>
            @endif

            {{-- First Page Link (Show if necessary) --}}
            @if ($currentPage > 5)
                <li class="paginator__item"><a type="button" class="page-link" wire:click="gotoPage(1, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}">1</a></li>
                <li class="paginator__item"><a>...</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach (range(1, $lastPage) as $page)
                @if ($page == $currentPage || ($page == $currentPage - 1 || $page == $currentPage + 1))
                    <li class="paginator__item {{ $page == $currentPage ? 'paginator__item--active' : '' }}" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}">
                        @if ($page == $currentPage)
                            <a>{{ $page }}</a>
                        @else
                            <a type="button" class="page-link" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}">{{ $page }}</a>
                        @endif
                    </li>
                @endif
            @endforeach

            {{-- Last Page Link (Show if necessary) --}}
            @if ($currentPage < $lastPage - 4)
                <li class="paginator__item"><a>...</a></li>
                <li class="paginator__item"><a type="button" class="page-link" wire:click="gotoPage({{ $lastPage }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}">{{ $lastPage }}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="paginator__item paginator__item--next">
                    <a style="cursor: pointer" class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" aria-label="@lang('pagination.next')"><i class="icon ion-ios-arrow-forward"></i></a>
                </li>
            @endif
        </ul>
    </div>
@endif
