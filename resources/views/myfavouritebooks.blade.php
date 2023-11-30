<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buku Favoritku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="dark:bg-gray-800 overflow-hidden rounded-lg shadow-md m-5">
                <section id="favourite-books" class="py-4 text-center bg-light">
                    <div class="container mx-auto">
                        <h2 class="text-3xl font-bold mb-4">Daftar Buku Favorit</h2>
                        <hr class="my-2">
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($favouriteBooks as $book)
                                <div class="p-4 border rounded-md">
                                    <p class="font-bold">{{ $book->judul }}</p>
                                    <p>{{ $book->penulis }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

</x-app-layout>