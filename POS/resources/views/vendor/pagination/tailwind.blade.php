@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between px-4 py-3">
        {{-- Versión móvil --}}
        <div class="flex justify-between flex-1 sm:hidden">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default select-none">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring ring-gray-300">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring ring-gray-300">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default select-none">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Versión escritorio --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            {{-- Información de “Mostrando X de Y” (opcional) --}}
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    {!! __('Mostrando') !!}
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    {!! __('a') !!}
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    {!! __('de') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('resultados') !!}
                </p>
            </div>

            {{-- Enlaces de página --}}
            <div>
                <ul class="inline-flex items-center -space-x-px text-sm">
                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <li>
                            <span class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg cursor-default select-none">
                                {!! __('pagination.previous') !!}
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 ml-0 leading-tight text-gray-700 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 focus:outline-none focus:ring ring-gray-300">
                                {!! __('pagination.previous') !!}
                            </a>
                        </li>
                    @endif

                    {{-- Elementos de paginación --}}
                    @foreach ($elements as $element)
                        {{-- Puntos suspensivos --}}
                        @if (is_string($element))
                            <li>
                                <span class="px-3 py-2 leading-tight text-gray-700 bg-white border border-gray-300 select-none">
                                    {{ $element }}
                                </span>
                            </li>
                        @endif

                        {{-- Array de enlaces --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li>
                                        <span aria-current="page"
                                              class="px-3 py-2 leading-tight text-blue-700 bg-blue-100 border border-blue-300 font-bold select-none">
                                            {{ $page }}
                                        </span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $url }}"
                                           class="px-3 py-2 leading-tight text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring ring-gray-300">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 leading-tight text-gray-700 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 focus:outline-none focus:ring ring-gray-300">
                                {!! __('pagination.next') !!}
                            </a>
                        </li>
                    @else
                        <li>
                            <span class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg cursor-default select-none">
                                {!! __('pagination.next') !!}
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
