<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Http\Requests\StoreAnggotaRequest;
use App\Http\Requests\UpdateAnggotaRequest;
 
class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggotas = Anggota::latest()->get();
        
        // Statistik
        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'Aktif')->count();
        $anggotaNonaktif = Anggota::where('status', 'Nonaktif')->count();
        
        return view('anggota.index', compact(
            'anggotas',
            'totalAnggota',
            'anggotaAktif',
            'anggotaNonaktif'
        ));
    }

    public function create() {
    return view('anggota.create');
}
 
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.show', compact('anggota'));
    }
    
 
    // Methods lainnya akan diimplementasi di pertemuan 13
    public function store(StoreAnggotaRequest $request)
{
    try {

        Anggota::create($request->validated());

        return redirect()->route('anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan!');

    } catch (\Exception $e) {

        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal menambahkan anggota: '.$e->getMessage());

    }
}

    public function edit(string $id)
{
    $anggota = Anggota::findOrFail($id);

    return view('anggota.edit', compact('anggota'));
}

   public function update(UpdateAnggotaRequest $request, string $id)
{
    try {

        $anggota = Anggota::findOrFail($id);

        $anggota->update($request->validated());

        return redirect()->route('anggota.show', $anggota->id)
            ->with('success', 'Data anggota berhasil diupdate!');

    } catch (\Exception $e) {

        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal mengupdate anggota : '.$e->getMessage());

    }
}
}


