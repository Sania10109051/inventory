<x-layout>
    <x-slot name="title">
        Tambah Barang
    </x-slot>

    <x-pagetittle>Tambah Barang</x-pagetittle>

    <x-section>
       
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
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                    </div>
                    <div class="col-md-6">
                        <label for="foto_barang" class="form-label">Foto Barang</label>
                        <input type="file" class="form-control" id="foto_barang" name="foto_barang">
                    </div>
                    <div class="col-md-6">
                        <label for="tgl_pembelian" class="form-label">Tanggal Pembelian</label>
                        <input type="date" class="form-control" id="tgl_pembelian" name="tgl_pembelian">
                    </div>
                    <div class="col-md-6">
                        <label for="harga_barang" class="form-label">Harga Barang</label>
                        <input type="number" class="form-control" id="harga_barang" name="harga_barang">
                    </div>

                    <div class="col-md-6">
                        <label for="id_kategori" class="form-label">Kategori</label>
                        <select id="id_kategori" class="form-select" name="id_kategori">
                            <option selected>Pilih...</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                        <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang">
                    </div>

                    <div class="col-md-12">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi_barang" rows="3"></textarea>
                    </div>
                        
                    <div class="d-flex justify-content-start">
                        <!-- Tombol Simpan dengan Ikon Save -->
                        <button type="submit" class="btn btn-primary my-2 btn-icon-text" onclick="confirmModal()">
                            <i class="ri-save-2-line"></i> Simpan
                        </button>
                    
                        <!-- Tombol Kembali dengan jarak antara tombol Simpan dan Kembali -->
                        <a href="/inventaris">
                            <button type="button" class="btn btn-secondary my-2 btn-icon-text ms-2">
                                <i class="ri-arrow-go-back-fill"></i> Kembali
                            </button>
                        </a>
                    </div>
                    
                                                          
                </form><!-- End Multi Columns Form -->
            </div>
        </div>
        <x-confirm-modal></x-confirm-modal>
    </x-section>
</x-layout>