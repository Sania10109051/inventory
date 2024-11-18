<x-layout>
    <x-slot name="title">
        Edit Barang Inventaris
    </x-slot>

    <x-pagetittle>
        Edit Barang Inventaris
    </x-pagetittle>

    <div class="pagetitle" style="display: flex; justify-content: center; align-items: center;">
        <h1 style="font-size: 2.5rem;">Edit Barang Inventaris</h1>
    </div><!-- End Page Title -->

    <div class="d-flex justify-content-end mb-3">
        <a href="/inventaris">
            <button type="button" class="btn btn-primary my-2 btn-icon-text">
                <i class="ri-arrow-go-back-fill"></i> Kembali
            </button>
        </a>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <x-alert></x-alert>
                        <!-- Multi Columns Form -->
                        <form class="row g-3 pt-4" method="post" action="{{ route('inventaris.update', $inventaris->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label for="inputEmail5" class="form-label">Nama Barang</label>
                                <input type="text" name="nama" class="form-control" id="inputEmail5" value="{{ $inventaris->name }}">
                            </div>
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">Kategori Barang</label>
                                <select name="kategori" id="inputState" class="form-select">
                                    <option value="0" {{ $inventaris->kategori == 0 ? 'selected' : '' }}>Alat Tulis Kantor</option>
                                    <option value="1" {{ $inventaris->kategori == 1 ? 'selected' : '' }}>Alat Elektronik</option>
                                    <option value="2" {{ $inventaris->kategori == 2 ? 'selected' : '' }}>Alat Kebersihan</option>
                                    <option value="3" {{ $inventaris->kategori == 3 ? 'selected' : '' }}>Alat Keamanan</option>


                                </select>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Deskripsi" name="deskripsi" id="floatingTextarea" style="height: 100px;">{{ $inventaris->description }}</textarea>
                                    <label for="floatingTextarea">Deskripsi Barang</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ Storage::url('inventaris/' . $inventaris->gambar)}}" alt="Gambar" style="width: 200px;">
                                </div>

                                <div class="col-6">
                                    <label for="formFile" class="form-label">Gambar Barang</label>
                                    <input class="form-control" type="file" id="formFile" name="gambar">
                                </div>
                                <div class="col-6">
                                    <label for="inputEmail5" class="form-label">Ketersediaan</label>
                                    <select name="ketersediaan" id="inputState" class="form-select">
                                        @if ($inventaris->status == 1)
                                        <option value="1" selected>Tersedia</option>
                                        <option value="0">Tidak Tersedia</option>
                                        @else
                                        <option value="1">Tersedia</option>
                                        <option value="0" selected>Tidak Tersedia</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </form><!-- End Multi Columns Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layout>