<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Gallery;
use Illuminate\Support\facades\DB;
use Intervention\Image\Facades\Image;


class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
    $batas = 5;

    // Menggunakan paginate() untuk hasil paginasi
    $data_buku = Buku::orderBy('id', 'asc')->paginate($batas);

    // Hitung jumlah total harga menggunakan sum() pada hasil query
    $totalHarga = Buku::sum('harga');

    // Menggunakan metode total() pada objek paginasi untuk menghitung total data
    $jumlahData = $data_buku->total();

    // Menghitung nomor urut (no) dengan benar
    $no = $batas * ($data_buku->currentPage() - 1);

    return view('index', compact('data_buku', 'no', 'jumlahData', 'totalHarga'));
}


    public function search(Request $request)
{
    $batas = 5;
    $cari = $request->kata;
    
    // Menghitung jumlah data buku yang sesuai dengan kriteria pencarian
    $jumlahData = Buku::where('judul', 'like', "%" . $cari . "%")
                      ->orWhere('penulis', 'like', "%" . $cari . "%")
                      ->count();
    
    // Menghitung total harga buku yang sesuai dengan kriteria pencarian
    $totalHarga = Buku::where('judul', 'like', "%" . $cari . "%")
                      ->orWhere('penulis', 'like', "%" . $cari . "%")
                      ->sum('harga');
    
    // Mengambil data buku yang sesuai dengan kriteria pencarian
    $data_buku = Buku::where('judul', 'like', "%" . $cari . "%")
                     ->orWhere('penulis', 'like', "%" . $cari . "%")
                     ->orderBy('id', 'asc')
                     ->simplePaginate($batas);
    
    $jumlah_buku = $data_buku->count();
    $no = $batas * ($data_buku->currentPage() - 1);

    return view('search', compact('jumlah_buku', 'jumlahData', 'totalHarga', 'data_buku', 'no', 'cari'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bukuCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
            'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);


        if ($request->file('thumbnail')) {
            $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
        }
        $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');

        Image::make(storage_path().'/app/public/uploads/'.$fileName)
            ->fit(240,320)
            ->save();

        Buku::create([
            'judul'     => $request->judul,
            'penulis'   => $request->penulis,
            'harga'     => $request->harga,
            'tgl_terbit'=> $request->tgl_terbit,
            'filename'  => $fileName,
            'filepath'  => '/storage/' . $filePath
        ]);
    
        $buku = Buku::where('judul', $request->judul)->first();
        if ($request->file('gallery')) {
            foreach ($request->file('gallery') as $key => $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
    
                $gallery = Gallery::create([
                    'nama_galeri' => $fileName,
                    'path' => '/storage/' . $filePath,
                    'foto' => $fileName,
                    'buku_id' => $buku->id
                ]);
            }
        }

        return redirect('/buku')->with('pesan', 'Data Buku Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::find($id);
        return view('bukuEdit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        $buku = Buku::find($id);
        $this->validate($request, [
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
            'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('thumbnail')) {
            $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');
    
            Image::make(storage_path().'/app/public/uploads/'.$fileName)
                ->fit(240,320)
                ->save();
    
            $buku->update([
                'judul'     => $request->judul,
                'penulis'   => $request->penulis,
                'harga'     => $request->harga,
                'tgl_terbit'=> $request->tgl_terbit,
                'filename'  => $fileName,
                'filepath'  => '/storage/' . $filePath
            ]);
        }

        if ($request->file('gallery')) {
            foreach($request->file('gallery') as $key => $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
    
                $gallery = Gallery::create([
                    'nama_galeri'   => $fileName,
                    'path'          => '/storage/' . $filePath,
                    'foto'          => $fileName,
                    'buku_id'       => $id
                ]);
            }
        }
        return redirect('/buku')->with('pesan', 'Data Buku Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::find($id);
        $buku->delete();
        return redirect('/buku')->with('pesan', 'Data Buku Berhasil Dihapus');
    }

    // public function construct()
    // {
    //     $this->middleware('auth');
    // }

    public function deleteGallery($bukuId, $galleryId)
    {
        $buku = Buku::findOrFail($bukuId);
        $gallery = $buku->galleries()->findOrFail($galleryId);
        $gallery->delete();
    
        return redirect()->back()->with('success', 'Gambar berhasil dihapus');
    }
}
