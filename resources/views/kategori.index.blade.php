<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Kategori Buku') }}
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
                    <div class="card-header text-center" style="background-color: #08b4acf1; color: white"><h2>Daftar Kategori Buku</h2></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a style="left: right; margin-bottom: 16px" href="{{ route('kategori.create') }}">
                                <button class="btn btn-success"><i class="fa-solid fa-plus"></i>&nbsp;Tambah Kategori</button>
                            </a>
                        </div>
                        <table class="table table-striped table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategoriBuku as $kategori)
                                    <tr>
                                        <td>{{ $kategori->id }}</td>
                                        <td>{{ $kategori->nama_kategori }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-primary"><i
                                                        class="fa-regular fa-pen-to-square"></i>&nbsp;Edit</a>
                                                &nbsp;
                                                <form action="{{ route('kategori.hapus', $kategori->id) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-danger" onClick="return confirm('Are you sure?')"><i
                                                            class="fas fa-trash"></i>&nbsp;Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
