<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-right p-4">
                    <form method="GET" action="{{ route('produk.index') }}" class="mb-3 flex items-center gap-2">
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-full max-w-xs"
                            placeholder="Cari barang...">
                        <button type="submit" id="buttonSearch"
                            class="bg-green-400 px-4 py-2 rounded-xl hover:bg-green-500">Cari</button>
                    </form>
                </div>
                <div class="px-4 pb-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        @foreach ($produk as $p)
                            <div class="p-4 bg-white shadow-md rounded-lg w-full mt-4">
                                <div class="flex flex-col sm:flex-row items-center gap-4 px -4">
                                    <!-- Gambar di atas pada HP, kiri pada layar besar -->
                                    <img src="{{ $p->image ? asset('storage/' . $p->image) : asset('default.jpg') }}" alt="Gambar"
                                        class="w-40 h-40 rounded-lg object-cover">
                                    
                                    <!-- Teks di bawah gambar pada HP, di samping pada layar besar -->
                                    <div class="flex-1 text-center sm:text-left">
                                        <h2 class="text-xl font-bold">{{ $p->name }}</h2>
                                        <p class="text-lg font-semibold text-yellow-600">Rp. {{ number_format($p->harga_jual) }}</p>
                                        <p class="text-sm text-gray-500">Kategori : {{ $p->kategori->name }}</p>
                                        <p class="text-sm text-gray-500">Jumlah : {{ $p->jumlah }} {{ $p->satuan }}</p>
                                    </div>
                                </div>
                                <!-- Tombol di bawah pada HP, kanan pada layar besar -->
                                <div class="flex justify-center sm:justify-end p-4">
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full sm:w-auto">Aksi</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $produk->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="sourceModalEdit">
        <div class="fixed inset-0 bg-black opacity-50" onclick="sourceModalClose()"></div>
        <div class="fixed inset-0 flex items-center justify-center">
            <div class="w-full md:w-1/2 relative bg-white rounded-lg shadow mx-5 max-h-[90vh] overflow-y-auto">
                <div class="flex items-start justify-between p-4 border-b rounded-t sticky top-0 bg-white z-10">
                    <h3 class="text-xl font-semibold text-gray-900" id="title_source">
                        Update Produk
                    </h3>
                    <button type="button" onclick="sourceModalClose()"
                        class="text-black bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="p-4">
                    <form method="POST" id="formSourceModalEdit" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col space-y-6">

                            <!-- Gambar Produk -->
                            <div class="mb-5">
                                <label for="image_edit" class="block mb-2 text-sm font-medium text-gray-900">Gambar
                                    Produk</label>
                                <input type="file" id="image_edit" name="image_edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    accept="image/*" />
                            </div>

                            <!-- Nama Produk -->
                            <div class="mb-5">
                                <label for="name_edit" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                    Produk</label>
                                <input type="text" id="name_edit" name="name_edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required />
                            </div>

                            <!-- Kategori -->
                            <div class="mb-5">
                                <label for="category_id_edit"
                                    class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                                <select id="category_id_edit" name="category_id_edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jumlah -->
                            <div class="mb-5">
                                <label for="jumlah_edit"
                                    class="block mb-2 text-sm font-medium text-gray-900">Jumlah</label>
                                <input type="number" id="jumlah_edit" name="jumlah_edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required />
                            </div>

                            <!-- Kategori -->
                            <div class="mb-5">
                                <label for="satuan_edit"
                                    class="block mb-2 text-sm font-medium text-gray-900">Satuan</label>
                                <select id="satuan_edit" name="satuan_edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                                    <option value="">Pilih Satuan</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Pack">Pack</option>
                                    <option value="Dus">Dus</option>
                                    <option value="Botol">Botol</option>
                                    <option value="Cup">Cup</option>
                                </select>
                            </div>

                            <!-- Harga Beli -->
                            <div class="mb-5">
                                <label for="harga_beli_edit" class="block mb-2 text-sm font-medium text-gray-900">Harga
                                    Beli</label>
                                <input type="number" id="harga_beli_edit" name="harga_beli_edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required />
                            </div>

                            <!-- Harga Jual -->
                            <div class="mb-5">
                                <label for="harga_jual_edit"
                                    class="block mb-2 text-sm font-medium text-gray-900">Harga Jual</label>
                                <input type="number" id="harga_jual_edit" name="harga_jual_edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required />
                            </div>

                            <!-- Stok -->
                            <div class="mb-5">
                                <label for="stock_edit"
                                    class="block mb-2 text-sm font-medium text-gray-900">Stock</label>
                                <input type="number" id="stock_edit" name="stock_edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required />
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-5">
                                <label for="description_edit"
                                    class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                <textarea id="description_edit" name="description_edit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                            </div>

                        </div>
                        <div
                            class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b sticky bottom-0 bg-white z-10">
                            <button type="submit" id="formSourceButtonEdit"
                                class="bg-green-400 m-2 w-40 h-10 rounded-xl hover:bg-green-500">Simpan</button>
                            <button type="button" onclick="sourceModalClose()"
                                class="bg-red-500 m-2 w-40 h-10 rounded-xl text-white hover:shadow-lg hover:bg-red-600">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const functionAdd = () => {
            const formModal = document.getElementById('formSourceModal');
            const modal = document.getElementById('sourceModal');

            // Set form action URL
            let url = "{{ route('produk.store') }}";
            document.getElementById('title_source').innerText = "Add Produk";
            formModal.setAttribute('action', url);

            // Display the modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Ensure CSRF token is added once
            if (!formModal.querySelector('input[name="_token"]')) {
                let csrfToken = document.createElement('input');
                csrfToken.setAttribute('type', 'hidden');
                csrfToken.setAttribute('name', '_token');
                csrfToken.setAttribute('value', '{{ csrf_token() }}');
                formModal.appendChild(csrfToken);
            }
        }

        const editSourceModal = (button) => {
            const formModal = document.getElementById('formSourceModalEdit');
            const modalTarget = button.dataset.modalTarget;
            const id = button.dataset.id;
            const name = button.dataset.name;
            const kategori = button.dataset.kategori;
            const jumlah = button.dataset.jumlah;
            const satuan = button.dataset.satuan;
            const harga_beli = button.dataset.harga_beli;
            const harga_jual = button.dataset.harga_jual;
            const stock = button.dataset.stock;
            const description = button.dataset.description;
            let url = "{{ route('produk.update', ':id') }}".replace(':id', id);

            document.getElementById('formSourceModalEdit').setAttribute('action', url);

            //create for jumlah, satuan, harga_beli, harga_jual, stock

            document.getElementById('name_edit').value = name;
            document.getElementById('category_id_edit').value = kategori;
            document.getElementById('jumlah_edit').value = jumlah;
            document.getElementById('satuan_edit').value = satuan;
            document.getElementById('harga_beli_edit').value = harga_beli;
            document.getElementById('harga_jual_edit').value = harga_jual;
            document.getElementById('stock_edit').value = stock;
            document.getElementById('description_edit').value = description;

            document.getElementById('sourceModalEdit').classList.remove('hidden');
        }

        const sourceModalClose = () => {
            document.getElementById('sourceModalEdit').classList.add('hidden');
            document.getElementById('sourceModal').classList.add('hidden');
        }

        const kategoriDelete = async (id, name) => {
            let tanya = confirm(`Apakah anda yakin untuk menghapus produk ${name} ?`);
            if (tanya) {
                await axios.post(`/produk/${id}`, {
                        '_method': 'DELETE',
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    })
                    .then(function(response) {
                        // Handle success
                        location.reload();
                    })
                    .catch(function(error) {
                        // Handle error
                        alert('Error deleting record');
                        console.log(error);
                    });
            }
        }
    </script>
</x-app-layout>
