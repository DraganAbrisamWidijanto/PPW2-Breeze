<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <x-slot name="slot">
        <div class="container mt-4">
            <div class="col-md-12">

                @if($jumlah_buku > 0)
                <div class="alert alert-success">
                    <h4>Ditemukan <strong>{{ $jumlah_buku }}</strong> data dengan kata: <strong>{{ $cari }}</strong></h4>
                    <a href="/buku" class="btn btn-warning mt-2">Kembali</a>
                </div>
                @else
                <div class="alert alert-warning">
                    <h4>Data {{ $cari }} tidak ditemukan</h4>
                    <a href="/buku" class="btn btn-warning mt-2">Kembali</a>
                </div>
                @endif

                <div class="card">
                    <div class="card-header text-center" style="background-color: #0B5ED7; color: white"><h3>Daftar Buku</h3></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            @if (Auth::check() && Auth::user()->level == 'admin')
                            <a href="{{ route('buku.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i>&nbsp;Tambah Buku</a>
                            @endif
                            <form action="{{ route('buku.search') }}" method="get" class="form-inline">
                                @csrf
                                <input type="text" name="kata" class="form-control" placeholder="Cari ..." style="float:right;">
                            </form>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Gambar</th>
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Harga</th>
                                    <th>Tgl. Terbit DD/MM/YYYY</th>
                                    @if (Auth::check() && Auth::user()->level == 'admin')
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_buku as $buku)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td><div>
                                        <img class="h-full w-full object-cover object-center"
                                        style="max-width: 240px; max-height: 320px;" 
                                        src="{{asset($buku->filepath)}}"</div></td>
                                    <td>{{ $buku->judul }}</td>
                                    <td>{{ $buku->penulis }}</td>
                                    <td>{{ "Rp ".number_format($buku->harga, 0, ',', '.') }}</td>
                                    <td>{{\Carbon\Carbon::parse($buku->tgl_terbit)->format('d/m/Y')}}</td>
                                    @if (Auth::check() && Auth::user()->level == 'admin')
                                    <td>
                                        <div class="btn-group" role="group" style="overflow-x: auto;">
                                            <a href="{{ route('bukuEdit', $buku->id) }}" class="btn btn-primary mr-1"><i class="fa-regular fa-pen-to-square"></i>Edit</a>
                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-danger" onClick="return confirm('Are you sure?')"><i class="fas fa-trash"></i>Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>{{ $data_buku->links('vendor.pagination.bootstrap-5') }}</div>
                        <div class="mt-3"><strong>Jumlah Buku: {{ $jumlahData }}</strong></div>
                        <div><strong>Jumlah Harga Buku: Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></div>
                        <div>{{ $data_buku->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
