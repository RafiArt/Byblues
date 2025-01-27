<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy("created_at","desc")->paginate(10);
        return view("news.index",compact("news"));
    }

    public function create()
    {
        return view("news.create");
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'author' => 'required|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Handle image upload if present
            $imagePath = null;
            if ($request->hasFile('image_url')) {
                $image = $request->file('image_url');
                $fileName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();

                // Pastikan direktori exists
                if (!file_exists(public_path('berita'))) {
                    mkdir(public_path('berita'), 0777, true);
                }

                // Simpan gambar ke public/berita
                $image->move(public_path('berita'), $fileName);
                $imagePath = '/berita/' . $fileName;  // Menggunakan folder berita
            }

            // Create news record
            News::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'author' => $validated['author'],
                'image_url' => $imagePath,
                'slug' => Str::slug($request->title)
            ]);

            return redirect()
                ->route('news.index')
                ->with('success', 'Berita berhasil ditambahkan!');

        } catch (\Exception $e) {
            // If something goes wrong, delete uploaded image if it exists
            if ($imagePath && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan berita. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        // Find the article by ID
        $article = News::findOrFail($id);

        if ($article->image_url && file_exists(public_path($article->image_url))) {
            unlink(public_path($article->image_url));
        }


        // Delete the article
        $article->delete();

        // Redirect back with a success message
        return redirect()->route('news.index')->with('success', 'News deleted successfully');
    }







}
