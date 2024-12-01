<x-layout>
    <x-slot name="title">
        Barang Inventaris
    </x-slot>
    

    <x-pagetittle>
        Barang Inventaris
    </x-pagetittle>

    <div class="d-flex justify-content-end gap-2 mb-3">
        <!-- Tombol Tambah -->
        <a href="{{ route('inventaris.create') }}">
            <button type="button" class="btn btn-primary my-2 btn-icon-text">
                <i class="ri-add-fill"></i> Tambah
            </button>
        </a>
    
        <!-- Tombol Kembali -->
        <a href="/inventaris">
            <button type="button" class="btn btn-secondary my-2 btn-icon-text">
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
                        <!-- Default Table -->
                        <div class="table-responsive p-3">
                            <table class="table table-data cell-border text-center hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Harga Barang</th>
                                        <th scope="col">Kategori Barang</th>
                                        <th scope="col">Tanggal Pembelian Barang</th>
                                        <th scope="col">Status Barang</th>
                                        <th scope="col">Kondisi Barang</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventaris as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id_barang }}</th>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>
                                            @if ($item->harga_barang == null)
                                            <span class="badge bg-danger">Belum diisi</span>
                                            @else
                                            Rp. {{ number_format($item->harga_barang, 0, ',', '.') }}
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($kategori as $ktg)
                                            @if ($ktg->id_kategori == $item->id_kategori)
                                            {{ $ktg->nama_kategori }}
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $item->tgl_pembelian }}</td>
                                        <td>
                                            @if ($item->status_barang == 'Tersedia')
                                            <span class="badge bg-success">Tersedia</span>
                                            @elseif ($item->status_barang == 'Dipinjam')
                                            <span class="badge bg-info">Dipinjam</span>
                                            @elseif ($item->status_barang == 'Tidak Tersedia')
                                            <span class="badge bg-danger">Tidak Tersedia</span>
                                            @else
                                            <span class="badge bg-warning">
                                                {{ $item->status_barang }}
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->kondisi == 'Baik')
                                            <span class="badge bg-success">Baik</span>
                                            @elseif ($item->kondisi == 'Rusak' || $item->kondisi == 'Hilang')
                                            <span class="badge bg-danger">{{ $item->kondisi }}</span>
                                            @else
                                            <span class="badge bg-warning">{{ $item->kondisi }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('inventaris.show', $item->id_barang) }}">
                                                <button type="button" class="btn btn-info btn-sm" title="Detail">
                                                    <i class="ri-eye-fill"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('inventaris.edit', $item->id_barang) }}">
                                                <button type="button" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="ri-pencil-line"></i>
                                                </button>
                                            </a>
                                            <form id="delete-form-{{ $item->id_barang }}" action="{{ route('inventaris.delete', $item->id_barang) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDelete('{{ $item->id_barang }}')">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <!-- Tambahkan baris lainnya sesuai kebutuhan -->
                                </tbody>
                            </table>
                        </div>
                        <!-- End Default Table Example -->
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
    
</x-layout>