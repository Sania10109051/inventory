<x-layout>
    <x-slot name="title">
        Barang Inventaris
    </x-slot>


    <x-pagetittle>
       Data Barang
    </x-pagetittle>

    {{-- <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('inventaris.create') }}">
            <button type="button" class="btn btn-primary my-2 btn-icon-text">
                <i class="ri-add-fill"></i> Tambah
            </button>
        </a>
    </div> --}}

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <x-alert></x-alert>
                        <div class="row p-4">
                            {{-- <h3 class="row justify-content-center p-2" >Kategori Barang</h3> --}}
                            @foreach ($kategori as $list)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $list->nama_kategori }}</h5>
                                        <p class="card-text">Jumlah Barang : 
                                            @php
                                                $idKategori = $list->id_kategori;
                                                $jumlahBarang = \App\Models\Inventaris::where('id_kategori', $idKategori)->count();
                                                echo $jumlahBarang;
                                            @endphp
                                        </p>
                                        <a href="{{ route('inventaris.list', $list->id_kategori) }}" class="btn btn-primary">Lihat Barang</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-layout>