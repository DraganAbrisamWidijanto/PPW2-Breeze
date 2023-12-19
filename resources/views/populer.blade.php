<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buku Populer') }}
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
                    <div class="card-header text-center" style="background-color: #08b4acf1; color: white"><h2>Buku Populer</h2></div>
                    <div class="card-body">
                        <ul>
                            @foreach($bukuPopuler as $buku)
                                <li>
                                    <strong>{{ $buku->judul }}</strong><br>
                                    <img class="h-full w-full object-cover object-center"
                                         style="max-width: 240px; max-height: 320px;"
                                         src="{{ asset($buku->filepath) }}">
                                    <br>
                                    Penulis: {{ $buku->penulis }}<br>
                                    Harga: {{ "Rp ".number_format($buku->harga, 2, ',', '.') }}<br>
                                    Rating: {{ ($buku->avgRating > 0) ? number_format($buku->avgRating, 2, '.', '') : 'Belum ada rating' }}<br>
                                    Tgl. Terbit: {{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d/m/Y') }}
                                </li>
                                <hr>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
