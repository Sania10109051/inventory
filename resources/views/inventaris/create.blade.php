<x-layout>
    <x-slot name="title">
        Tambah Barang
    </x-slot>

    <x-pagetittle>Tambah Barang</x-pagetittle>

    <x-section>
        <div class="d-flex justify-content-end mb-3">
            <a href="/inventaris">
                <button type="button" class="btn btn-primary my-2 btn-icon-text">
                    <i class="ri-arrow-go-back-fill"></i> Kembali
                </button>
            </a>
        </div>
        <div class="m-4">
            <x-alert></x-alert>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Form Tambah Barang</h5>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="post" action="{{ route('inventaris.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="kategori_id" class="form-label" value="{{ old('kategori_id') }}">Kategori</label>
                        <select id="kategori_id" class="form-select" name="kategori_id">
                            <option selected>Pilih Kategori</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="kondisi" class="form-label">Kondisi</label>
                        <select id="kondisi" class="form-select" name="kondisi">
                            <option selected>Pilih Kondisi</option>
                            <option value="Baik">Baik</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" onclick="confirmModal()" >Tambah</button>
                    </div>
                </form><!-- End Multi Columns Form -->
            </div>
        </div>
        <x-confirm-modal></x-confirm-modal>
    </x-section>
</x-layout>