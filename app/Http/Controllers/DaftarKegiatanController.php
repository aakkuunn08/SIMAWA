<?php

namespace App\Http\Controllers;

use App\Models\DaftarKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarKegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = DaftarKegiatan::all(); // ambil data dari DB
        return view('kegiatan.index', compact('kegiatan')); // kirim ke view
    }

    /**
     * Get events for calendar display
     */
    public function getEvents()
    {
        $kegiatan = DaftarKegiatan::all();
        $events = [];
        
        foreach ($kegiatan as $k) {
            $date = $k->tanggal_kegiatan;
            if (!isset($events[$date])) {
                $events[$date] = [];
            }
            $events[$date][] = [
                'id' => $k->id_kegiatan,
                'nama' => $k->nama_kegiatan,
                'tempat' => $k->tempat,
                'waktu_mulai' => $k->waktu_mulai,
                'waktu_selesai' => $k->waktu_selesai,
            ];
        }
        
        return response()->json($events);
    }

    /**
     * Store a new activity
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:200',
            'tanggal_kegiatan' => 'required|date',
            'tempat' => 'required|string|max:200',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        // Get authenticated user ID
        $userId = Auth::user()->id;

        $kegiatan = DaftarKegiatan::create([
            'user_id' => $userId,
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'tanggal_kegiatan' => $validated['tanggal_kegiatan'],
            'tempat' => $validated['tempat'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'status_kegiatan' => 'scheduled',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil ditambahkan',
            'data' => $kegiatan
        ]);
    }

    /**
     * Get single activity details
     */
    public function show($id)
    {
        $kegiatan = DaftarKegiatan::findOrFail($id);
        return response()->json($kegiatan);
    }

    /**
     * Update an activity
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:200',
            'tanggal_kegiatan' => 'required|date',
            'tempat' => 'required|string|max:200',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        $kegiatan = DaftarKegiatan::findOrFail($id);
        $kegiatan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil diupdate',
            'data' => $kegiatan
        ]);
    }

    /**
     * Delete an activity
     */
    public function destroy($id)
    {
        $kegiatan = DaftarKegiatan::findOrFail($id);
        $kegiatan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kegiatan berhasil dihapus'
        ]);
    }
}
