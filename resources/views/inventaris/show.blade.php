<x-layout>

    <x-slot name="title">
        Detail Barang
    </x-slot>

    <x-pagetittle>Detail Barang</x-pagetittle>

    <div class="d-flex justify-content-end mb-3">
        <a href="/inventaris">
            <button type="button" class="btn btn-primary my-2 btn-icon-text">
                <i class="ri-arrow-go-back-fill"></i> Kembali
            </button>
        </a>
    </div>
    <div class="card">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6">
                    <h3>Gambar Barang</h3>
                    <div class="frame">
                        <img src="{{ Storage::url('inventaris/' . $inventaris->gambar)}}" alt="Gambar" width="400px">
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Detail Barang</h3>
                    <table class="table table-bordered">
                        <tr>
                            <th>Kode Barang</th>
                            <td>{{ $inventaris->id }}</td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $inventaris->name }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>
                                {{ $inventaris->kategori }}
                            </td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $inventaris->description }}</td>
                        </tr>
                    </table>

                    <h3>QR Code</h3>
                    <div class="frame">
                        @if ($inventaris->qr)
                        <img src="{{ Storage::url('qrcodes/' . $inventaris->qr) }}" alt="QR Code" width="200px">
                        <br>
                        <a href="{{ Storage::url('qrcodes/' . $inventaris->qr) }}" download="{{ $inventaris->name }}.png">
                            <button class="btn btn-info mt-2 text-white">
                                <i class="ri-download-2-fill"></i> Download QR Code
                            </button>
                        </a>
                        @else
                        <p>QR Code belum dibuat</p>
                        <a href="{{ route('inventaris.qr', $inventaris->id) }}">
                            <button class="btn btn-primary mt-2 text-white">
                                <i class="ri-barcode-box-fill"></i> Generate QR Code
                            </button>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>