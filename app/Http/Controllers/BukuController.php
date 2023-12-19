<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Gallery;
use Illuminate\Support\facades\DB;
use Illuminate\Support\Facades\Schema;

use Intervention\Image\Facades\Image;


class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $batas = 5;

    // Menggunakan paginate() untuk hasil paginasi
    $data_buku = Buku::orderBy('id', 'asc')->paginate($batas);

    // Hitung jumlah total harga menggunakan sum() pada hasil query
    $totalHarga = Buku::sum('harga');

    // Menggunakan metode total() pada objek paginasi untuk menghitung total data
    $jumlahData = $data_buku->total();
    
    // Menghitung nomor urut (no) dengan benar
    $no = $batas * ($data_buku->currentPage() - 1);

    // Menghitung jumlah rating
    if (Schema::hasColumn('buku', 'rating_1') &&
        Schema::hasColumn('buku', 'rating_2') &&
        Schema::hasColumn('buku', 'rating_3') &&
        Schema::hasColumn('buku', 'rating_4') &&
        Schema::hasColumn('buku', 'rating_5')) {

        $jumlahRating1 = Buku::sum('rating_1');
        $jumlahRating2 = Buku::sum('rating_2');
        $jumlahRating3 = Buku::sum('rating_3');
        $jumlahRating4 = Buku::sum('rating_4');
        $jumlahRating5 = Buku::sum('rating_5');

        $jumlahRating = $jumlahRating1 + $jumlahRating2 + $jumlahRating3 + $jumlahRating4 + $jumlahRating5;

        if ($jumlahRating > 0) {
            $avgRating = ($jumlahRating1 * 1 + $jumlahRating2 * 2 + $jumlahRating3 * 3 + $jumlahRating4 * 4 + $jumlahRating5 * 5) / $jumlahRating;
        } else {
            $avgRating = 0;
        }
    } else {
        // Handle error jika kolom tidak ditemukan
        // Contoh: return view('error')->with('message', 'Kolom rating tidak ditemukan.');
        $avgRating = 0; // Set nilai default jika kolom tidak ditemukan
    }

    return view('index', compact('data_buku', 'no', 'jumlahData', 'totalHarga', 'avgRating'));
}


public function listbuku(){
    $batas = 5;

    // Menggunakan paginate() untuk hasil paginasi
    $data_buku = Buku::orderBy('id', 'asc')->paginate($batas);

    // Hitung jumlah total harga menggunakan sum() pada hasil query
    $totalHarga = Buku::sum('harga');

    // Menggunakan metode total() pada objek paginasi untuk menghitung total data
    $jumlahData = $data_buku->total();

    // Menghitung nomor urut (no) dengan benar
    $no = $batas * ($data_buku->currentPage() - 1);

    return view('list_buku', compact('data_buku', 'no', 'jumlahData', 'totalHarga'));
}

public function galerbuku($buku_seo)
{
    $buku = Buku::where('buku_seo', $buku_seo)->first();
    $galeries = $buku->galleries()->orderBy('id', 'desc')->paginate(5);
    return view ('detail_buku', compact('buku', 'galeries'));
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
            'filepath'  => '/storage/' . $filePath,
            'buku_seo'  => str_replace(' ', '-', strtolower($request->judul))
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

    public function storeRating(Request $request, $id)
    {
        $this->validate($request, [
            'rating' => 'required|numeric|between:1,5',
        ]);

        $buku = Buku::findOrFail($id);

        // Update rating pada buku
        $ratingField = 'rating_' . $request->rating;
        $buku->$ratingField += 1;
        $buku->save();

        return redirect()->route('galeri.buku', ['buku_seo' => $buku->buku_seo])
            ->with('success', 'Rating berhasil disimpan.');
    }


    //Menambahkan buku ke daftar favorit
    public function addToFavourite($id)
{
    $buku = Buku::findOrFail($id);
    
    // Cek apakah buku sudah ada di daftar favorit pengguna
    if (auth()->user()->favouriteBooks->contains($buku)) {
        return redirect()->back()->with('pesan', 'Buku sudah ada di daftar favorit Anda.');
    }

    // Tambahkan buku ke daftar favorit
    auth()->user()->favouriteBooks()->attach($buku);

    return redirect()->back()->with('pesan', 'Buku berhasil ditambahkan ke daftar favorit Anda.');
}

//Menampilkan buku favorit
public function myFavouriteBooks()
{
    $favouriteBooks = auth()->user()->favouriteBooks;

    return view('myfavouritebooks', compact('favouriteBooks'));
}

public function bukuPopuler()
{
    $bukuPopuler = Buku::orderByDesc(Buku::raw('rating_1 + rating_2 + rating_3 + rating_4 + rating_5'))->take(10)->get();

    return view('populer', compact('bukuPopuler'));
}

public function kategoriIndex()
{
    $kategoriBuku = KategoriBuku::all();

    return view('kategori.index', compact('kategoriBuku'));
}

public function tambahKategori(Request $request)
{
    $request->validate([
        'nama_kategori' => 'required|string|max:255|unique:kategori_buku',
    ]);

    KategoriBuku::create(['nama_kategori' => $request->nama_kategori]);

    return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
}

public function editKategori($id)
{
    $kategori = KategoriBuku::findOrFail($id);

    return view('kategori.edit', compact('kategori'));
}

public function updateKategori(Request $request, $id)
{
    $request->validate([
        'nama_kategori' => 'required|string|max:255|unique:kategori_buku,nama_kategori,'.$id,
    ]);

    $kategori = KategoriBuku::findOrFail($id);
    $kategori->update(['nama_kategori' => $request->nama_kategori]);

    return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
}

public function hapusKategori($id)
{
    $kategori = KategoriBuku::findOrFail($id);
    $kategori->delete();

    return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
}

public function bukuByKategori($kategori_id)
{
    $kategori = KategoriBuku::findOrFail($kategori_id);
    $bukus = $kategori->bukus;

    return view('kategori.buku', compact('kategori', 'bukus'));
}

}
