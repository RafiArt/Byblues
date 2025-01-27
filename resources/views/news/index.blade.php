<x-dashboard-layout title="News">
    <form id="filterForm" class="flex items-center mb-3 w-full lg:w-1/4" action="{{ route('news.index') }}" method="GET">
        <div class="flex w-full space-x-3">
            <!-- Search Input -->
            <div class="relative flex-grow">
                <input
                    name="search"
                    type="text"
                    class="w-full pl-4 pr-10 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 border border-blue-500 rounded-md"
                    placeholder="Search by Name..."
                    value="{{ request('search') }}"
                >
                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <i class="fas fa-search"></i> <!-- FontAwesome search icon -->
                </span>
            </div>
        </div>
    </form>

    <a href="{{ route('news.create') }}" class="inline-block px-6 py-2 mb-3 text-white bg-green-500 rounded-md hover:bg-green-600">
        <span class="font-semibold">News</span>
        <i class="fa-solid fa-plus text-lg text-white ml-2"></i>
    </a>


    @if ($news->isNotEmpty())
    <div class="w-full overflow-x-auto">
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-400 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-4 text-white text-left">No.</th>
                    <th class="py-3 px-4 text-white text-left">Title</th>
                    <th class="py-3 px-4 text-white text-left">Content</th>
                    <th class="py-3 px-4 text-white text-left">Author</th>
                    <th class="py-3 px-4 text-white text-left">Published Date</th>
                    <th class="py-3 px-4 text-white text-left">Image</th>
                    <th class="py-3 px-4 text-white text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($news as $index => $article)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-4 text-left whitespace-nowrap">
                            {{ $news->firstItem() + $index }}
                        </td>
                        <td class="py-3 px-4 text-left">
                            <div class="flex items-center">
                                {{ $article->title }}
                            </div>
                        </td>
                        <td class="py-3 px-4 text-left">
                            {{ $article->content }}
                        </td>
                        <td class="py-3 px-4 text-left">
                            {{ $article->author }}
                        </td>
                        <td class="py-3 px-4 text-left">
                            {{ date('d M Y', strtotime($article->created_at)) }}
                        </td>
                        <td class="py-3 px-4 text-left">
                            @if($article->image_url)
                                <img src="{{ $article->image_url }}" alt="{{$article->title}}" class="w-20 h-20 object-cover rounded-md">
                            @else
                                <img src="/images/no-image.jpg" alt="No Image" class="w-20 h-20 object-cover rounded-md">
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button id="btn-modal-delete-{{ $article->id }}"
                                        class="w-8 h-8 flex items-center justify-center bg-red-500 text-white rounded-md transform hover:bg-red-600 hover:scale-110">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal -->
                            <div id="modal-{{ $article->id }}" class="fixed top-0 hidden flex items-center justify-center right-0 w-full h-screen bg-gray-900 bg-opacity-80 z-[99999]">
                                <div class="bg-white w-[30rem] p-6 rounded-lg opacity-100 flex items-center justify-center flex-col gap-5">
                                    <i class="fa-solid fa-circle-exclamation text-5xl text-red-500"></i>
                                    <p>Are you sure you want to <span class="font-bold">delete</span> this news article?</p>
                                    <div class="flex items-center gap-6">
                                        <button id="cancel-btn-{{ $article->id }}" type="button"
                                                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Cancel</button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('news.destroy', $article->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- JavaScript to handle modal visibility -->
                            <script>
                                const modal{{ $article->id }} = document.getElementById('modal-{{ $article->id }}')
                                const cancelBtn{{ $article->id }} = document.getElementById('cancel-btn-{{ $article->id }}')
                                const openModal{{ $article->id }} = document.getElementById('btn-modal-delete-{{ $article->id }}')

                                // Show modal when the delete button is clicked
                                openModal{{ $article->id }}.addEventListener('click', () => {
                                    modal{{ $article->id }}.classList.toggle('hidden')
                                })

                                // Hide modal when cancel button is clicked
                                cancelBtn{{ $article->id }}.addEventListener('click', () => {
                                    modal{{ $article->id }}.classList.toggle('hidden')
                                })
                            </script>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    @if ($news->total() > 10)
        <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
            <div class="flex flex-1 justify-between sm:hidden">
                {{-- Mobile View: Previous Page Link --}}
                @if ($news->onFirstPage())
                    <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $news->previousPageUrl() }}"
                    class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                @endif

                {{-- Mobile View: Next Page Link --}}
                @if ($news->hasMorePages())
                    <a href="{{ $news->nextPageUrl() }}"
                    class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                @else
                    <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Next</span>
                @endif
            </div>

            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">{{ $news->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $news->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $news->total() }}</span>
                        results
                    </p>
                </div>

                <div class="flex items-center space-x-2">
                    {{-- Previous Button --}}
                    @if ($news->onFirstPage())
                        <span class="cursor-not-allowed opacity-50">
                            <button type="button" disabled
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 cursor-not-allowed">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Previous
                            </button>
                        </span>
                    @else
                        <a href="{{ $news->previousPageUrl() }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Previous
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    <div class="flex space-x-1">
                        @foreach (range(max(1, $news->currentPage() - 2), min($news->lastPage(), $news->currentPage() + 2)) as $page)
                            @if ($page == $news->currentPage())
                                <span aria-current="page"
                                    class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $news->url($page) }}"
                                class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    {{-- Next Button --}}
                    @if ($news->hasMorePages())
                        <a href="{{ $news->nextPageUrl() }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                            <svg class="h-5 w-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 5.293a1 1 0 011.414 0L10 7.586l1.293-1.293a1 1 0 111.414 1.414l-2 2a1 1 0 010 1.414l2 2a1 1 0 01-1.414 1.414L10 12.414l-1.293 1.293a1 1 0 01-1.414-1.414l2-2a1 1 0 010-1.414l-2-2a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span class="cursor-not-allowed opacity-50">
                            <button type="button" disabled
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50">
                                Next
                                <svg class="h-5 w-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 5.293a1 1 0 011.414 0L10 7.586l1.293-1.293a1 1 0 111.414 1.414l-2 2a1 1 0 010 1.414l2 2a1 1 0 01-1.414 1.414L10 12.414l-1.293 1.293a1 1 0 01-1.414-1.414l2-2a1 1 0 010-1.414l-2-2a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif
    @else
    <div class="bg-gray-100 p-8 text-center">
        <div class="bg-transparent mx-auto w-full max-w-xs rounded overflow-hidden">
            <div class="flex justify-center">
                <video autoplay loop muted playsinline class="w-64 h-64"
                    style="background-color: transparent;">
                    <source src="{{ asset('video/vid2-rm.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
        <p class="text-gray-500 mt-4 ">Tidak ada catatan berita yang ditemukan.</p>
    </div>
    @endif
</x-dashboard-layout>
