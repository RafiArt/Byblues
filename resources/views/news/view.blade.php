<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{asset('fontawesome-free-6.7.1-web/css/all.min.css')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@include('layouts.navbar')

<div class="container mx-auto py-10 px-4">
    <div class="flex mb-6 text-sm text-gray-600">
        <a href="/" class="hover:text-blue-500">Home</a>
        <span class="mx-2">/</span>
        <a href="/" class="hover:text-blue-500">Berita</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-blue-950">{{ $news->title }}</span>
    </div>
    <!-- Berita -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Title, Author, Created_at -->
        <div class="mb-4">
            <h1 class="text-3xl font-bold text-left text-blue-950 mb-2">{{ $news->title }}</h1>
            <p class="text-sm text-gray-600">By <span class="font-semibold">{{ $news->author }}</span> | {{ $news->created_at->format('d M Y') }}</p>
        </div>
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Left column: Image and Content -->
            <div class="md:w-2/3">
                <!-- Image (centered) -->
                <div class="flex justify-center">
                    @if($news->image_url)
                        <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-100 h-100 object-cover rounded-md mb-6">
                    @else
                        <img src="/images/no-image.jpg" alt="No Image" class="w-100 h-100 object-cover rounded-md mb-6">
                    @endif
                </div>

                <!-- Content -->
                <div class="text-gray-700 text-lg">
                    {!! $news->content !!}
                </div>
            </div>

            <!-- Right column: Recommended News -->
            <div class="md:w-1/3">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-xl font-semibold mb-4">Recommended News</h3>

                    <!-- Loop through recommended news, limiting to 3 articles -->
                    @foreach($recommendedNews->take(3) as $article)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden flex flex-col mb-4">
                            @if($article->image_url)
                                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                            @else
                                <img src="/images/no-image.jpg" alt="No Image" class="w-full h-48 object-cover">
                            @endif
                            <div class="p-5 flex-1">
                                <h2 class="text-xl font-semibold mb-4">{{ $article->title }}</h2>
                                <p class="text-gray-700 mb-1">{!! Str::limit($article->content, 20) !!}</p>
                                <a href="{{ route('news.show', $article->id) }}" class="text-blue-600 hover:underline">Read More</a>
                            </div>
                        </div>
                    @endforeach

                    <!-- If no recommended news -->
                    @if($recommendedNews->isEmpty())
                        <p class="text-gray-500">No recommendations available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')

