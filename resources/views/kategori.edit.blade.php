<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kategori Buku') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="card">
            <div class="card-header text-center" style="background-color: #08b4acf1; color: white">
                <h2>Edit Kategori Buku</h2>
            </div>
            <div class="card-body">
                @if(count($errors) > 0)
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li style="margin-left: 16px">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <form method="POST" action="{{ route('kategori.update', $kategori->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="inputNamaKategori">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama_kategori" id="inputNamaKategori" value="{{ $kategori->nama_kategori }}">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary bg-blue-500 text-white">
                            <i class="fa-regular fa-floppy-disk"></i>&nbsp;Simpan
                        </button>
                        <a href="{{ route('kategori.index') }}" class="btn btn-danger">
                            <i class="fa-solid fa-ban"></i>&nbsp;Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-app-layout>
