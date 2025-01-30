<x-app-layout>
    <x-slot name="header">
        <form method="GET" action="{{ route('transaksi.index') }}" class="mb-3">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari barang...">
        </form>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    @foreach ($produk as $p)
                    <div class="col-md-4">
                        <div class="card p-3 mb-3">
                            <div class="d-flex align-items-center">
                                <!-- Gambar Produk -->
                                <img src="{{ asset('storage/' . $p->image) }}" alt="Produk" class="rounded" width="70" height="70">
            
                                <div class="ms-3">
                                    <!-- Nama Produk -->
                                    <h5 class="mb-0">{{ $p->name }}</h5>
                                    <small class="text-muted">{{ $kategori->name }}</small>
                                </div>
            
                                <!-- Harga -->
                                <div class="ms-auto">
                                    <span class="badge bg-primary fs-6">Rp. {{ number_format($p->harga_jual, 0, ',', '.') }}</span>
                                </div>
            
                                <!-- Tombol Tambah -->
                                <div class="ms-3">
                                    {{-- <form method="POST" action="{{ route('transaksi.add', $p->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-warning rounded-circle">+</button>
                                    </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
