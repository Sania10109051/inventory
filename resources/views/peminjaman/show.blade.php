<x-layout>
    <x-slot name="title">
        Data Peminjaman
    </x-slot>

    <x-pagetittle>
        Data Peminjaman
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
                        <b>Data Peminjaman</b>
                    </div>
                    <div class="card-body mt-2">
                        <x-alert></x-alert>
                        <table class="table table-borderless">
                            <tr>
                                <td>Nama Peminjam</td>
                                <td>:</td>
                                <td>
                                    {{ $peminjaman->nama_peminjam }}
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Pinjam</td>
                                <td>:</td>
                                <td>
                                    {{ $peminjaman->tanggal_pinjam }}
                                </td>
                            </tr>
                            <tr>
                                <td>Tenggat Pengembalian</td>
                                <td>:</td>
                                <td>
                                    {{ $peminjaman->tanggal_kembali }}
                                </td>
                            </tr>
                            <tr>
                                <td>Barang</td>
                                <td>:</td>
                                <td>
                                    {{
                                            $barang->name
                                        }}
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>
                                    @if ($peminjaman->status == 'Dipinjam')
                                    <span class="badge bg-warning">Meminjam</span>
                                    @elseif ($peminjaman->status == 'Dikembalikan')
                                    <span class="badge bg-success">Dikembalikan</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Dikembalikan</td>
                                <td>:</td>
                                <td>
                                    {{ $peminjaman->tanggal_dikembalikan ?? 'Belum Dikembalikan' }}
                                </td>
                            </tr>
                            <tr>
                                <td>Surat Bukti Peminjaman</td>
                                <td>:</td>
                                <td>
                                    <a href="{{route('peminjaman.buktiPinjam', $peminjaman->id)}}" target="_blank">
                                        <button class="btn btn-sm btn-info text-light">
                                            <i class="ri-file-download-line"></i> Download Bukti Peminjaman
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <div class="d-flex justify-content-end ">
                            <a href="{{ route('peminjaman.edit', $peminjaman->id) }}">
                                <button class="btn btn-warning">
                                    <i class="ri-pencil-line"></i> Edit
                                </button>
                            </a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>