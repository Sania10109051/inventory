<x-layout title="Edit Kategori" >

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('kategori.index') }}">
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
                        <b>Edit Kategori</b>
                    </div>
                    <div class="card-body mt-2">
                        <form method="post" action="{{ route('kategori.update', $kategori->id_kategori) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" id="name" name="nama_kategori" value="{{ $kategori->nama_kategori }}">
                            </div>
                            <button type="submit" onclick="confirmModal()" class="btn btn-primary">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirm-modal></x-confirm-modal>

</x-layout>