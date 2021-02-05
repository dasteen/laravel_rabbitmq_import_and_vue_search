@extends('app')

@section('content')
        @include('messages')

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                <a href="{{ route('index') }}" class="text-sm text-gray-700 underline">Home</a>

                <a href="{{ route('import') }}" id="importBtn" class="ml-4 text-sm text-gray-700 underline">Import</a>
            </div>

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 products_container" id="vueApp">
                <div class="mt-8 dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <input id="searchInput" type="text" width="100%">
                </div>
                <div id="productCounter">Найдено @{{ productsFound }}</div>
                <div class="mt-8 dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2" id="productsContainer" v-for="product in products">
                        <div class="p-6">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold"><a href="@{{ product.link }}" class="underline text-gray-900 dark:text-white">@{{ product.name }}</a></div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    @{{ product.description_mini }}
                                </div>
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    @{{ product.human_price }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <nav role="navigation" class="flex items-center justify-between">
                    <div class="flex justify-between flex-1 sm:hidden">

                        <a v-if="pagination.prevPageLink" v-bind:href="pagination.prevPageLink" class="sm:rounded-lg relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500  border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            {!! __('pagination.previous') !!}
                        </a>
                        <span v-if="!pagination.prevPageLink" class="sm:rounded-lg relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700  border border-gray-300 cursor-default leading-5 rounded-md">
                            {!! __('pagination.previous') !!}
                        </span>

                        <a v-if="pagination.nextPageLink" v-bind:href="pagination.nextPageLink" class="sm:rounded-lg relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            {!! __('pagination.next') !!}
                        </a>
                        <span v-if="!pagination.nextPageLink" class="sm:rounded-lg relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700  border border-gray-300 cursor-default leading-5 rounded-md">
                            {!! __('pagination.next') !!}
                        </span>
                    </div>
                </nav>

            </div>
        </div>
@endsection
