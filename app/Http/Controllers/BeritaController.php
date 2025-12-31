<?php
namespace App\Http\Controllers;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller {
    public function index() {
        return Berita::where('published', true)->get();
    }

    public function getData() {
        return Berita::where('published', true)->get();
    }

    public function store(Request $request) {
        $request->validate([
            'url_sumber' => 'required|url',
            'published' => 'boolean'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['tanggal_publikasi'] = now();

        Berita::create($data);
        return response()->json(['success' => true]);
    }

    public function show($id) {
        return Berita::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'url_sumber' => 'required|url',
            'published' => 'boolean'
        ]);

        Berita::findOrFail($id)->update($request->all());
        return response()->json(['success' => true]);
    }

    public function destroy($id) {
        Berita::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
