<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List Buku') }}
        </h2>
    </x-slot>
    <x-slot name="slot">
        <div class="container" style="margin-top: 16px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center" style="background-color: #08b4acf1; color: white"><h2>Daftar Buku</h2></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
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
                                    <th>Rating</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_buku as $buku)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td><div>
                                        <img class="h-full w-full object-cover object-center"
                                        style="max-width: 240px; max-height: 320px;" 
                                        src="{{asset($buku->filepath)}}"</div></td>
                                        <td>{{ $buku->judul }}</td>
                                        <td>
                                            @php
                                                $jumlahRating = $buku->rating_1 + $buku->rating_2 + $buku->rating_3 + $buku->rating_4 + $buku->rating_5;
                                                $avgRating = ($jumlahRating > 0) ? ($buku->rating_1 * 1 + $buku->rating_2 * 2 + $buku->rating_3 * 3 + $buku->rating_4 * 4 + $buku->rating_5 * 5) / $jumlahRating : 0;
                                            @endphp
                        
                                            @if ($avgRating > 0)
                                                <p class="text-green-500">{{ number_format($avgRating, 2, '.', '') }}</p>
                                            @else
                                                <p class="text-red-500">Rating is not available.</p>
                                            @endif
                                        </td>
                                        <td><div class="btn-group" role="group" style="overflow-x: auto;">
                                            <a href="{{ route('galeri.buku', $buku->buku_seo) }}" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i>&nbsp;Lihat Detail</a>
                                        </div>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>{{ $data_buku->links('vendor.pagination.bootstrap-5') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>