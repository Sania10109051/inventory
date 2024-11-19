<x-layout>
    <x-slot name="title">
        Edit Peminjaman
    </x-slot>

    <x-pagetittle>
        Edit Peminjaman
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
                        <b>Edit Peminjaman</b>
                    </div>
                    <div class="card-body mt-2">
                        <x-alert></x-alert>
                        <form method="POST" id="formEdit" action="{{ route('peminjaman.update', $peminjaman->id_peminjaman) }}">
                            @csrf
                            @method('POST')
                            <table class="table table-borderless">
                                <tr>
                                    <td>Nama Peminjam</td>
                                    <td>:</td>
                                    <td>
                                        {{ $peminjaman->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pinjam</td>
                                    <td>:</td>
                                    <td>
                                        {{ $peminjaman->tgl_pinjam }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Kembali</td>
                                    <td>:</td>
                                    <td>
                                        {{ $peminjaman->tgl_kembali }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Barang</td>
                                    <td>:</td>
                                    <td>
                                        {{
                                            $barang->nama_barang
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>
                                        <select class="form-select" name="status">
                                            <option value="Dipinjam" {{ $peminjaman->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                            <option value="Dikembalikan" {{ $peminjaman->status == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kondisi Barang</td>
                                    <td>:</td>
                                    <td>
                                        <select class="form-select" name="kondisi">
                                            <option value="Baik" {{ $peminjaman->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="Rusak" {{ $peminjaman->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                            <option value="Hilang" {{ $peminjaman->kondisi == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                                        </select>
                                    </td>
                                </tr>
                                </tr>
                            </table>
                            <button type="submit" class="btn btn-primary" onclick="return confirmSave()">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmSave() {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('#formEdit').submit();
                }
            });
            return false;
        }
    </script>
</x-layout>