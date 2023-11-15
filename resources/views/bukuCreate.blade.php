<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah buku') }}
            </h2>
    </x-slot>
    <x-slot name="slot">
    
        <div class="card">
            <div class="card-header text-center" style="background-color: #0B5ED7; color: white"><h2>Tambah Buku</h2></div>
            <div class="card-body">
                @if(count($errors) > 0)
                    <ul class="alert alert-danger list-group">
                        @foreach ($errors->all() as $error)
                            <li class="list-group-item">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <form method="POST" action="{{ route('buku.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label for="inputJudul">Judul</label> 
                        <input type="text" class="form-control" name="judul" id="inputJudul">
                    </div>
                    <div class="form-group">
                        <label for="inputPenulis">Penulis</label> 
                        <input type="text" class="form-control" name="penulis" id="inputPenulis">
                    </div>
                    <div class="form-group">
                        <label for="inputHarga">Harga</label> 
                        <input type="text" class="form-control" name="harga" id="inputHarga">
                    </div>
                    <div class="form-group">
                        <label for="inputTgl_terbit">Tanggal Terbit</label> 
                        <input type="date" class="date form-control" name="tgl_terbit" id="inputTgl_terbit" placeholder="yyyy/mm/dd">
                    </div> 

                    <div class="form-group">
                        <label for="thubnail">thubnail buku</label> 
                        <input type="file" class="form-control" name="thumbnail" id="thumbnail">
                    </div> 

                    {{-- <div class="col-span-full mt-6">
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
                    </div> --}}
                    <div class="form-group">
                        <label for="filepath">Gallery</label>
                        <div id="fileinput_wrapper" class="mt-2 mb-2">
    
                        </div>
                        <a href="javascript:void(0)" onclick="addFileInput()" class="btn btn-outline-primary">Tambah Gambar Gallery</a>
                        <script type="text/javascript">
                            function addFileInput() {
                                var div = document.getElementById('fileinput_wrapper');
                                div.innerHTML += '<input type="file" class="btn btn-outline-primary mb-2" id="gallery" name="gallery[]" placeholder="Gallery">';
                            }
                        </script>
                    </div>
                    &nbsp;
                    <div>
                        <button type="submit" class="btn bg-blue-500 text-white">
                            <i class="fa-regular fa-floppy-disk"></i>&nbsp;Simpan
                        </button>
                        
                        <a href="/buku" class="btn btn-danger"><i class="fa-solid fa-ban"></i>&nbsp;Batal</a>
                    </div>
                </form>
                
            </div>
        </div>
        </x-slot>
    </x-app-layout>