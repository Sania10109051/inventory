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
            <button type="button" class="btn btn-primary my-2 btn-icon-text">
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
                    <div class="card-body mt-2">
                        <x-alert></x-alert>
                        <form method="post" action="{{ route('peminjaman.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                                <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali">
                            </div>
                            <div class="mb-3">
                                <label for="barang_id" class="form-label">Barang</label>
                                <select class="form-select" id="barang_id" name="barang_id" disabled>
                                    <option default value="">Scan Qr barang</option>
                                    @foreach ($inventaris as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="id_barang" id="id_barang">
                                        
                                <div id="scannerBarang" class="reader"></div>
                            </div>
                            <button type="submit" class="btn btn-primary {{ $inventaris->count() == 0 ? 'disabled' : '' }}">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('html5-qrcode/html5-qrcode.min.js') }}"></script>
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
        function onScanSuccess(decodedText, decodedResult) {
            // set the value of the hidden input field with the scanned text
            document.getElementById('barang_id').value = decodedText;
            document.getElementById('id_barang').value = decodedText;

            // clear the scan area after performing the action above
            html5QRCodeScanner.clear();
        }
        html5QRCodeScanner.render(onScanSuccess);
    </script>
</x-layout>