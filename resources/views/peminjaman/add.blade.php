<x-layout>
    <x-slot name="title">
        Tambah Peminjaman
    </x-slot>

    <x-pagetittle>
        Tambahkan Peminjaman
    </x-pagetittle>

    <x-alert></x-alert>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('peminjaman.index') }}">
            <button type="button" class="btn btn-secondary my-2 btn-icon-text">
                <i class="ri-arrow-go-back-line"></i> Kembali
            </button>
        </a>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <b>Tambah Peminjaman</b>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card-body mt-2">
                        <x-alert></x-alert>
                        <form method="post" action="{{ route('peminjaman.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Peminjam</label>
                                <select name="id_user" id="peminjam_id" class="form-select">
                                    <option selected>Pilih...</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="tgl_pinjam" class="form-label">Tanggal Pinjam</label>
                                    <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="tgl_kembali" class="form-label">Tenggat Pengembalian</label>
                                    <input type="date" name="tgl_tenggat" id="tgl_kembali" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                            </div>
                            <div class="row" id="barang-container">
                                <h4>List Barang Yang Akan Dipinjam</h4>
                                <!-- Barang items will be added here dynamically -->
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="scanModalLabel">Scan Barang</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="scannerBarang"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="scan-barang" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#scanModal">Scan Barang</button>
                            <br>
                            <button type="submit" class="btn btn-primary {{ $inventaris->count() == 0 ? 'disabled' : '' }}">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('html5-qrcode/html5-qrcode.min.js') }}"></script>
    <div id="data-inventaris" data-inventaris="{{ json_encode($inventaris) }}"></div>
    <script>
        // initialize html5QRCodeScanner
        let html5QRCodeScanner = new Html5QrcodeScanner(
            "scannerBarang", {
                fps: 10,
                qrbox: {
                    width: 500,
                    height: 500,
                },
            }
        );
        const dataContainer = document.getElementById('data-inventaris');
        const barangList = JSON.parse(dataContainer.dataset.inventaris);


        function getBarangName(id) {
            let barang = barangList.find(item => item.id_barang == id);
            return barang ? barang.nama_barang : "Barang tidak ditemukan/Tidak Tersedia";
        }


        function onScanSuccess(decodedText, decodedResult) {
            if (barang = barangList.find(item => item.id_barang == decodedText)) {
                let barangContainer = document.getElementById('barang-container');
                let barangItem = document.createElement('div');
                barangItem.classList.add('barang-item', 'mb-2');
                barangItem.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <span>${getBarangName(decodedText)}</span>
                        <button type="button" class="btn btn-danger remove-barang">Hapus</button>
                        <input type="hidden" name="id_barang[]" value="${decodedText}">
                    </div>
                `;
                barangContainer.appendChild(barangItem);
                // close the modal
                let modal = bootstrap.Modal.getInstance(document.getElementById('scanModal'));
                modal.hide();
            } else {
                alert('Barang tidak ditemukan/Tidak Tersedia');
                html5QRCodeScanner.clear();
                html5QRCodeScanner.render(onScanSuccess);

            }
        }
        html5QRCodeScanner.render(onScanSuccess);

        document.getElementById('barang-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-barang')) {
                e.target.closest('.barang-item').remove();
            }
        });

        document.getElementById('scan-barang').addEventListener('click', function() {
            html5QRCodeScanner.clear();
            html5QRCodeScanner.render(onScanSuccess);
        });
    </script>

</x-layout>