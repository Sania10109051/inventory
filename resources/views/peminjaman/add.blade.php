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
                                <label for="name" class="form-label">Peminjam</label>
                                <select name="id_user" id="peminjam_id" class="form-select">
                                    <option selected>Pilih...</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" id="tanggal_pinjam" name="tgl_pinjam">
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="id_barang" class="form-label">Nama Barang</label>
                                    <select name="id_barang" id="id_barang" class="form-select">
                                        <option selected>Pilih...</option>
                                        @foreach ($inventaris as $item)
                                        <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <div id="scannerBarang"></div>
                                </div>
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
            document.getElementById('id_barang').value = decodedText;

            // clear the scan area after performing the action above
            html5QRCodeScanner.clear();
        }
        html5QRCodeScanner.render(onScanSuccess);
    </script>
</x-layout>