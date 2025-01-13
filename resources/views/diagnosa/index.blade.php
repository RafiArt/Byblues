<x-dashboard-layout title="Diagnosis">

    <!-- Search Form -->
    <form class="flex items-center mb-3" action="{{ route('diagnosa.index') }}" method="GET">
        <div class="flex w-full max-w-sm border border-blue-500 rounded-md overflow-hidden">
            <input name="search" type="text"
                class="flex-grow px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 border-none"
                placeholder="Search Diagnosis..."
                value="{{ old('search', $search ?? '') }}">
            <button type="submit"
                class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600">
                Search
            </button>
        </div>
    </form>


    <!-- Add New Diagnosis Button -->
    <a href="{{route('diagnosa.create')}}" class="inline-block px-6 py-2 mb-3 text-white bg-green-500 rounded-md hover:bg-green-600">
        <span class="font-semibold">Diagnosis</span>
        <i class="fa-solid fa-plus text-lg text-white ml-2"></i>
    </a>




</x-dashboard-layout>
