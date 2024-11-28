<x-layout>

    <x-slot name="title">
        Data Pinjam
    </x-slot>

    <x-pagetittle>
        Data Pinjam
    </x-pagetittle>

    <section>
        <div class="container mx-auto px-4 sm:px-8">
            <div class="py-8">

                <div class="d-flex justify-content-end mb-3">
                    <div class="my-2 flex sm:flex-row flex-col me-3">
                        <div class="block relative">
                            <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                                <i class="bi bi-search"></i>
                            </span>
                            <input placeholder="Search" class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                        </div>
                    </div>
                </div>



                <x-alert></x-alert>

                <div class="my-2 flex sm:flex-row flex-col">
                    <div class="block relative">
                        <div class="table-responsive">
                            <table class="table table-data text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Kode Peminjaman</th>
                                        <th scope="col">Nama Peminjam</th>
                                        <th scope="col">Tanggal Pinjam</th>
                                        <th scope="col">Tenggat Pengembalian</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peminjaman as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id_peminjaman }}</th>
                                        <td>
                                            {{
                                                Auth::user()->name
                                            }}
                                        </td>
                                        <td>{{ $item->tgl_pinjam }}</td>
                                        <td>{{ $item->tgl_kembali ?? 'Belum Dikembalikan' }}</td>
                                        <td>
                                            @if ($item->status == 'Dipinjam')
                                            <span class="badge bg-warning">Dipinjam</span>
                                            @elseif ($item->status == 'Dikembalikan')
                                            <span class="badge bg-success">Dikembalikan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('user.detail_peminjaman', $item->id_peminjaman) }}">
                                                <button type="button" class="btn btn-info btn-sm" title="Detail">
                                                    <i class="ri-eye-fill"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>