<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-right p-4">
                    <form method="GET" action="{{ route('transaksi.index') }}" class="mb-3 flex items-center gap-2">
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
                                <div class="flex flex-col sm:flex-row items-center gap-4 px-4">
                                    <!-- Gambar di atas pada HP, kiri pada layar besar -->
                                    <img src="{{ $p->image ? asset('storage/' . $p->image) : asset('default.jpg') }}"
                                        alt="Gambar" class="w-40 h-40 rounded-lg object-cover">

                                    <!-- Teks di bawah gambar pada HP, di samping pada layar besar -->
                                    <div class="flex-1 text-center sm:text-left">
                                        <h2 class="text-xl font-bold">{{ $p->name }}</h2>
                                        <p class="text-lg font-semibold text-yellow-600">Rp.
                                            {{ number_format($p->harga_jual) }}</p>
                                        <p class="text-sm text-gray-500">Kategori : {{ $p->kategori->name }}</p>
                                        <p class="text-sm text-gray-500">Jumlah : {{ $p->jumlah }}
                                            {{ $p->satuan }}</p>
                                    </div>
                                </div>
                                <!-- Tombol di bawah pada HP, kanan pada layar besar -->
                                <div class="flex justify-center sm:justify-end p-4">
                                    <button type="button"
                                        onclick="addCart('{{ $p->id }}', '{{ $p->name }}', '{{ $p->harga_jual }}')"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full sm:w-auto">Tambah</button>
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

    <div class="fixed inset-0 items-center justify-center z-50 hidden" id="sourceModal">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div class="fixed inset-0 flex items-center justify-center">
            <div class="w-full md:w-1/2 relative bg-white rounded-lg shadow mx-5 px-4">
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900" id="title_source">Tambah Transaksi</h3>
                    <button type="button" onclick="sourceModalClose(this)" data-modal-target="sourceModal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                        data-modal-hide="defaultModal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form method="POST" id="formSourceModal">
                    @csrf
                    <div class="mb-4">
                        <div id="ProdukContainer"></div>
                        <div class="mt-4 border-t pt-2"></div>
                        <p class="text-lg font-bold">Total Pembayaran: <span id="totalPayment">Rp. 0</span></p>
                    </div>
                    <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                        <button type="submit" id="formSourceButton"
                            class="bg-green-400 m-2 w-40 h-10 rounded-xl hover:bg-green-500">Simpan</button>
                        <button type="button" data-modal-target="sourceModal" onclick="sourceModalClose(this)"
                            class="bg-red-500 m-2 w-40 h-10 rounded-xl text-white hover:shadow-lg hover:bg-red-600">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer Fixed -->
    <footer class="fixed bottom-0 left-0 w-full bg-gray-900 text-white py-3 shadow-md" onclick="return functionAdd()">
        <div class="w-full mx-auto">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-4">
                <div class="w-20 max-w-xs">
                    <label for="total" class="block mb-1 text-sm font-medium text-white">Total</label>
                </div>
                <input type="text" id="total" name="total"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Total" readonly />
            </div>
    </footer>

    <script>
        const functionAdd = () => {
            const formModal = document.getElementById('formSourceModal');
            const modal = document.getElementById('sourceModal');

            // Set form action URL
            let url = "{{ route('transaksi.store') }}";
            document.getElementById('title_source').innerText = "Transaksi";
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

        const sourceModalClose = (element) => {
            const modal = document.getElementById(element.getAttribute('data-modal-target'));
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        const closeModal = () => {
            const modal = document.getElementById('modal');
            modal.classList.add('hidden');
        }

        const addCart = (id, name, price) => {
            const container = document.getElementById('ProdukContainer');
            const productDiv = document.createElement('div');
            productDiv.classList.add('flex', 'gap-2', 'items-center', 'border-b', 'py-2');
            productDiv.innerHTML = `
                <span class="w-2/6">${name}</span>
                <input type="number" class="w-1/6 p-2 border rounded" value="1" min="1" oninput="calculateTotal(this, ${price})">
                <input type="text" class="w-2/6 p-2 border rounded bg-gray-100" value="Rp. ${price}" readonly>
                <button type="button" onclick="removeProduct(this)" class="w-1/6 bg-red-500 text-white py-1 rounded hover:bg-red-600">Hapus</button>
            `;
            container.appendChild(productDiv);
            updateSubtotal();
        }

        const removeProduct = (button) => {
            button.parentElement.remove();
            updateSubtotal();
        }

        const calculateTotal = (input, price) => {
            let quantity = parseInt(input.value) || 1;
            let totalField = input.nextElementSibling;
            let total = price * quantity;
            totalField.value = `Rp. ${total}`;
            updateSubtotal();
        }

        const updateSubtotal = () => {
            let totalFields = document.querySelectorAll('#ProdukContainer input[readonly]');
            let subtotal = 0;
            totalFields.forEach(field => {
                subtotal += parseInt(field.value.replace(/[^0-9]/g, '')) || 0;
            });
            document.getElementById('totalPayment').innerText = `Rp. ${subtotal}`;
            document.getElementById('total').value = `Rp. ${subtotal}`;
        }
    </script>
</x-app-layout>
