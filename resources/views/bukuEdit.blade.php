<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Edit buku') }}
    </h2>
</x-slot>
<x-slot name="slot">
    <div class="card">
        <div class="card-header text-center" style="background-color: #08b4acf1; color: white"><h2>Edit Buku</h2></div>
        <div class="card-body">
            @if(count($errors) > 0)
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li style="margin-left: 16px">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="POST" action="{{ route('buku.update', $buku->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="inputJudul">Judul</label> 
                <input type="text" class="form-control" name="judul" id="inputJudul" value="{{ $buku->judul }}">
            </div>
            <div class="form-group">
                <label for="inputPenulis">Penulis</label> 
                <input type="text" class="form-control" name="penulis" id="inputPenulis" value="{{ $buku->penulis }}">
            </div>
            <div class="form-group">
                <label for="inputHarga">Harga</label> 
                <input type="text" class="form-control" name="harga" id="inputHarga" value="{{ $buku->harga }}">
            </div>
            <div class="form-group">
                <label for="inputTgl_terbit">Tanggal Terbit</label> 
                @php
                    $formattedDate = date('Y-m-d', strtotime(str_replace('/', '-', $buku->tgl_terbit)));
                @endphp
                <input type="date" class="form-control" name="tgl_terbit" id="inputTgl_terbit" value="{{ $formattedDate }}">
            </div>
            <div class="form-group">
                <label for="thumbnail">Thumbnail</label> 
                <input type="file" class="form-control" name="thumbnail" id="thumbnail">
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary bg-blue-500 text-white">
                    <i class="fa-regular fa-floppy-disk"></i>&nbsp;Simpan
                </button>
                
                <a href="/buku" class="btn btn-danger"><i class="fa-solid fa-ban"></i>&nbsp;Batal</a>
            </div>
            &nbsp;


            <div class="col-span-full mt-6">
                <label for="gallery" class="block text-sm font-medium leading-6 text-gray-900">Gallery</label>
                <div class="mt-2" id="fileinput_wrapper">
                    <input type="file" name="gallery[]" id="gallery" class="block w-full mb-5 border border-gray-300 p-2 rounded-md">
                    <button type="button" id="tambah" onclick="addFileInput()" class="btn btn-primary text-blue-500">Tambah Gambar Gallery</button>
                    <script type="text/javascript">
                        function addFileInput() {
                            var div = document.getElementById('fileinput_wrapper');
                            div.innerHTML += '<input type="file" name="gallery[]" id="gallery" class="block w-full mb-5 border border-gray-300 p-2 rounded-md">';
                        };
                    </script>
                </div>
            </div>
        </form>
            <div class="gallery_items mt-6 flex space-x-4">
                @foreach($buku->galleries()->get() as $gallery)
                    <div class="gallery_item flex items-center flex-col">    
                        <img
                            class="full object-cover object-center match-height"
                            src="{{ asset($gallery->path) }}"
                            alt=""
                            width="400"
                        />
                        <form action="{{ route('buku.deleteGallery', [$buku->id, $gallery->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin mau dihapus?')" class="bg-red-500 text-white p-2 mt-2">Hapus</button>
                        </form>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    </x-slot>
</x-app-layout>