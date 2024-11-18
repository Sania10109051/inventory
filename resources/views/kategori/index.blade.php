<x-layout  title="List Kategori">
    <x-section>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('kategori.add') }}">
                <button type="button" class="btn btn-primary my-2 btn-icon-text">
                    <i class="ri-add-line"></i> Tambah Kategori
                </button>
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">List Kategori</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Kategori</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $item->nama_kategori }}</td>
                                <td>
                                    <a href="{{ route('kategori.edit', $item->id_kategori) }}">
                                        <button type="button" class="btn btn-warning btn-sm">Edit</button>
                                    </a>
                                    <form action="{{ route('kategori.delete', $item->id_kategori) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="confirmModal(event)">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <x-confirm-modal></x-confirm-modal>
    </x-section>
</x-layout>