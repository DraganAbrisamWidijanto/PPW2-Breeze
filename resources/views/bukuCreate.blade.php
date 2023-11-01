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
                <form method="POST" action="{{ route('buku.store') }}">
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