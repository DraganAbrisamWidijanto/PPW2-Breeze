<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Buku') }}
    </h2>
</x-slot>
<x-slot name="slot">
    <div class="container" style="margin-top: 16px">
        <div class="col-md-12">
            @if(session('pesan'))
                <div class="alert alert-success" id="pesan">
                    {{ session('pesan') }}
                </div>
                <script type="text/javascript">
                    // Setelah 2 detik, hapus pesan notifikasi
                    setTimeout(function(){
                        document.getElementById('pesan').style.display = 'none';
                    }, 3000); // 2000 milidetik = 2 detik
                </script>
            @endif
            

            <div class="card">
                <div class="card-header text-center" style="background-color: #08b4acf1; color: white"><h2>Daftar Buku</h2></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        @if (Auth::check() && Auth::user()->level == 'admin')
                        <a style="left: right; margin-bottom: 16px" href="{{ route('buku.create') }}">
                            <button class="btn btn-success"><i class="fa-solid fa-plus"></i>&nbsp;Tambah Buku</button>
                        </a>
                        @endif
                        <form action="{{ route('buku.search') }}" method="get">
                            @csrf
                            <input type="text" name="kata" class="form form-control" placeholder="Cari ..." style="float:right;">
                        </form>

                        
                    </div>
                    <table class="table table-striped table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Gambar</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Harga</th>
                                <th>Rating</th>
                                <th>Tgl. Terbit DD/MM/YYYY</th>
                                @if (Auth::check() && Auth::user()->level == 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_buku as $buku)
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <td>
                                        <div>
                                            <img class="h-full w-full object-cover object-center"
                                                style="max-width: 240px; max-height: 320px;" src="{{asset($buku->filepath)}}">
                                        </div>
                                    </td>
                                    <td>{{ $buku->judul }}</td>
                                    <td>{{ $buku->penulis }}</td>
                                    <td>{{ "Rp ".number_format($buku->harga, 2, ',', '.') }}</td>
                                    <td>
                                        @if ($buku->avgRating > 0)
                                            <span class="text-green-500">{{ number_format($buku->avgRating, 2, '.', '') }}</span>
                                        @else
                                            <span class="text-red-500">Belum ada rating</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d/m/Y') }}</td>
                                    @if (Auth::check() && Auth::user()->level == 'admin')
                                        <td>
                                            <div class="btn-group" role="group" style="overflow-x: auto;">
                                                <a href="{{ route('bukuEdit', $buku->id) }}" class="btn btn-primary"><i
                                                        class="fa-regular fa-pen-to-square"></i>&nbsp;Edit</a>
                                                &nbsp;
                                                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-danger" onClick="return confirm('Are you sure?')"><i
                                                            class="fas fa-trash"></i>&nbsp;Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div>{{ $data_buku->links('vendor.pagination.bootstrap-5') }}</div>
                    <div><strong>Jumlah Buku : {{ $jumlahData }}</strong></div>
                    <div><strong>Jumlah Harga Buku : Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></div>
                </div>
            </div>
        </div>
                </x-slot>
    </x-app-layout>