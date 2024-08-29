@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp



@if ($paginator->hasPages())



<div class="col-12">
    <ul class="paginator">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="paginator__item paginator__item--prev" >
                <a><i class="icon ion-ios-arrow-back"></i></a>
            </li>
        @else
        <li class="paginator__item paginator__item--prev">
            <a style="cursor: pointer" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" aria-label="@lang('pagination.previous')"><i class="icon ion-ios-arrow-back"></i></a>
        </li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="paginator__item"><a>{{ $element }}</a></li>
            @endif

        {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    <li class="paginator__item paginator__item--active" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}" aria-current="page"><a>{{ $page }}</a>
                    </li>
                    @else
                    <li class="paginator__item" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"><a type="button" class="page-link" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}">{{ $page }}</a>
                    </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="paginator__item paginator__item--next">
                <a style="cursor: pointer" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" aria-label="@lang('pagination.next')"><i class="icon ion-ios-arrow-forward"></i></a>
            </li>
        @else
            <li class="paginator__item paginator__item--next" aria-disabled="true" aria-label="@lang('pagination.next')">
                <a ><i class="icon ion-ios-arrow-forward"></i></a>
            </li>
        @endif

    </ul>
</div>

@endif
