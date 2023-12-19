<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="dark:bg-gray-800 overflow-hidden rounded-lg shadow-md m-5">
                <section id="album" class="py-4 text-center bg-light">
                    <div class="container mx-auto">
                        <h2 class="text-3xl font-bold mb-4">{{ $buku->judul }}</h2>
                        <hr class="my-2">
                        <div class="mb-4">
                            <p><span class="font-bold">Penulis:</span> {{ $buku->penulis }}</p>
                            <p><span class="font-bold">Harga:</span> {{ $buku->harga }}</p>
                            <p><span class="font-bold">Tanggal Terbit:</span> {{ $buku->tgl_terbit }}</p>
                            <p><span class="font-bold">Rating:</span>
                                @if ($buku->avgRating > 0)
                                    <span class="text-green-500">{{ number_format($buku->avgRating, 2, '.', '') }}</span>
                                @else
                                    <span class="text-red-500">Belum ada rating</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-4 overflow-x-auto">
                            @foreach($buku->galleries as $gallery)
                                <div class="flex-shrink-0 flex flex-col items-center rounded-md bg-white m-2 p-4">
                                    <a href="{{ asset($gallery->path) }}" data-lightbox="image-1" data-title="{{ $gallery->keterangan }}">
                                        <img src="{{ asset($gallery->path) }}" class="w-200 h-150 object-cover rounded-md" alt="{{ $gallery->nama_galeri }}" width="200" height="150">
                                    </a>
                                    <p class="mt-2 text-sm">{{ $gallery->nama_galeri }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-4">
                            <form action="{{ route('buku.storeRating', $buku->id) }}" method="POST">
                                @csrf
                                <label for="rating" class="font-bold">Beri Rating:</label>
                                <select name="rating" id="rating" class="form-select">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <button type="submit" class="inline-block px-4 py-2 border border-blue-500 text-blue-500 bg-blue-100 rounded mt-4">Berikan Rating</button>
                            </form>
                        </div>

                        <div class="mb-4">
                            <p>Simpan buku ini he halaman favorit Anda!</p>
                        <form action="{{ route('buku.addToFavourite', $buku->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-block px-4 py-2 border border-blue-500 text-blue-500 bg-blue-100 rounded mt-4">Simpan ke Daftar Favorit</button>
                        </form>
                        </div>
                        
                    </div>
                </section>
                <a href="{{ route('list.buku') }}" class="inline-block px-4 py-2 border border-blue-500 text-blue-500 bg-blue-100 rounded mt-4">
                    {{ __('Kembali ke Daftar Buku') }}
                </a>
            </div>
        </div>
    </div>

    <script src="{{ asset('dist/js/lightbox-plus-jquery.min.js') }}"></script>
</x-app-layout>
