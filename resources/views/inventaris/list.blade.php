<x-layout>
    <x-slot name="title">
        Barang Inventaris
    </x-slot>

    <x-pagetittle>
        Barang Inventaris
    </x-pagetittle>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('inventaris.create') }}">
            <button type="button" class="btn btn-primary my-2 btn-icon-text">
                <i class="ri-add-fill"></i> Tambah
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
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Jumlah Barang</th>
                                        <th scope="col">Status Barang</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventaris as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->status_barang }}</td>
                                        <td>
                                            <a href="{{ route('inventaris.show', $item->id) }}">
                                                <button type="button" class="btn btn-info btn-sm" title="Detail">
                                                    <i class="ri-eye-fill"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('inventaris.edit', $item->id) }}">
                                                <button type="button" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="ri-pencil-line"></i>
                                                </button>
                                            </a>
                                            <form id="delete-form-{{ $item->id }}" action="{{ route('inventaris.delete', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDelete('{{ $item->id }}')">
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