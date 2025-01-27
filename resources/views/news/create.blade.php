<x-dashboard-layout title="Create News">
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-full w-full bg-white p-6 rounded-lg shadow-md">

            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title Field -->
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-lg font-medium mb-2">Judul Berita</label>
                    <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Content Field -->
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 text-lg font-medium mb-2">Konten Berita</label>
                    <textarea class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Author Field -->
                <div class="mb-4">
                    <label for="author" class="block text-gray-700 text-lg font-medium mb-2">Penulis</label>
                    <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('author') border-red-500 @enderror" id="author" name="author" value="{{ old('author') }}" required>
                    @error('author')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image URL Field -->
                <div class="mb-4">
                    <label for="image_url" class="block text-gray-700 text-lg font-medium mb-2">Unggah Gambar (Opsional)</label>
                    <input type="file" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image_url') border-red-500 @enderror" id="image_url" name="image_url" accept="image/*" required>
                    @error('image_url')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-between gap-4 mb-4 w-1/4">
                    <!-- Back Button -->
                    <a href="{{ route('news.index') }}" class="w-full sm:w-1/2 p-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-300 text-center">
                        Kembali
                    </a>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full sm:w-1/2 p-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                        Simpan
                    </button>

                </div>
            </form>
        </div>
    </div>


</x-dashboard-layout>
