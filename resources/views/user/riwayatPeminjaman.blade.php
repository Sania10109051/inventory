<x-layout>

    <x-slot name="title">
        Data Pinjam
    </x-slot>

    <div class="pagetitle">
        <h1>Data Pinjam</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="route('dashboard')">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Data Pinjam</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section>
        <div class="container mx-auto px-4 sm:px-8">
            <div class="py-8">
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
                                        <td>{{ $item->tgl_kembali ?? '-' }}</td>
                                        <td>
                                            @if ($item->status == ['Pending', 'Dipinjam'])
                                            <span class="badge bg-warning">Dipinjam</span>
                                            @elseif ($item->status == 'Dikembalikan')
                                            <span class="badge bg-success">Dikembalikan</span>
                                            @else
                                            <span class="badge bg-danger">
                                                {{$item->status}}
                                            </span>
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