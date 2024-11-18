@extends('partials.admin.main')
@section('content')

<main class="main" id="main">
    
    <section class="section">
    <div class="row">
        <div class="col-lg-6"> <!-- Mengubah ukuran kolom menjadi sedang -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Tambah User</h5> <!-- Judul Form yang diubah -->

                        <form action="/admin/kelola_user/store" method="POST" class="row g-3">
                            @csrf
                            <div class="col-12 mb-3"> <!-- Tambahkan mb-3 untuk jarak -->
                                <label for="id_pegawai" class="form-label fw-bold">Id Pegawai</label> <!-- Bold -->
                                <input type="text" class="form-control" id="id_pegawai" name="id_pegawai" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="nama" class="form-label fw-bold">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="jabatan" class="form-label fw-bold">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="level_akses" class="form-label fw-bold">Level Akses</label>
                                <select class="form-control" id="level_akses" name="level_akses">
                                    <option value="User">User</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="/admin/kelola_user" class="btn btn-secondary">Batal</a>
                            </div>
                        </form> <!-- Vertical Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
