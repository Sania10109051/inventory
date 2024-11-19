<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\KategoriBarang;

class InventarisController extends Controller
{
    protected $inventaris;

    public function index()
    {
        $kategori = KategoriBarang::all();

        return view('inventaris.index', compact('inventaris', 'kategori'));
    }

    public function barangByKategori($id)
    {
        $inventaris = Inventaris::where('id_kategori', $id)->get();
        $kategori = KategoriBarang::all();

        return view('inventaris.list', compact('inventaris', 'kategori'));
    }

    public function show($id)
    {
        $inventaris = Inventaris::find($id);
        $kategori = KategoriBarang::all();

        return view('inventaris.show', compact('inventaris', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriBarang::all();
        return view('inventaris.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'foto_barang' => 'required|image',
            'id_kategori' => 'required',
            'harga_barang' => 'required',
            'tgl_pembelian' => 'required',
            'deskripsi_barang' => 'required',
        ], [
            'nama_barang.required' => 'Nama barang harus diisi.',
            'jumlah_barang.required' => 'Jumlah barang harus diisi.',
            'foto_barang.required' => 'Gambar barang harus diisi.',
            'foto_barang.image' => 'File yang diupload harus berupa gambar.',
            'id_kategori.required' => 'Kategori barang harus diisi.',
            'harga_barang.required' => 'Harga satuan barang harus diisi.',
            'tgl_pembelian.required' => 'Tanggal pembelian barang harus diisi.',
            'deskripsi_barang.required' => 'Deskripsi barang harus diisi.',
        ]);



        $gambar = $request->file('foto_barang')->storePublicly('inventaris', 'public');
        if (!$gambar) {
            return redirect()->back()
                ->with('error', 'Gambar barang gagal diupload.');
        }

        $namaGambar = basename($gambar);

        $data = [
            'nama_barang' => $request->nama_barang,
            'status_barang' => 'Tersedia',
            'kondisi' => 'Baik',
            'foto_barang' => $namaGambar,
            'harga_barang' => $request->harga_barang,
            'tgl_pembelian' => $request->tgl_pembelian,
            'id_kategori' => $request->id_kategori,
            'deskripsi_barang' => $request->deskripsi_barang,
        ];

        if ($request->jumlah_barang > 1) {
            for ($i = 0; $i < $request->jumlah_barang; $i++) {
                $data['id_barang'] = rand(1000, 9999);
                $inv = Inventaris::create($data);
                $qrCodePath = 'qrcodes/' . $inv->id_barang . '.png';
                $fullPath = storage_path('app/public/' . $qrCodePath);

                if (!file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0755, true);
                }

                QrCode::format('png')->size(200)->generate($inv->id_barang, $fullPath);

                $fileQr = basename($qrCodePath);

                $inv->update([
                    'qr_code' => $fileQr,
                ]);
            }
        } else {
            $inv = Inventaris::create($data);

            $qrCodePath = 'qrcodes/' . $inv->id_barang . '.png';
            $fullPath = storage_path('app/public/' . $qrCodePath);

            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            QrCode::format('png')->size(200)->generate($inv->id_barang, $fullPath);

            $fileQr = basename($qrCodePath);

            $inv->update([
                'qr_code' => $fileQr,
            ]);
        }
        return redirect()->route('inventaris.list')
            ->with('success', 'Barang Inventaris Berhasil Ditambahkan Dengan QRCode.');
    }

    public function qrCreate($id)
    {
        $inv = Inventaris::find($id);
        $namaBarang = $inv->nama_barang;
        $qrCodePath = 'qrcodes/' . $inv->id_barang . '.png';
        $fullPath = storage_path('app/public/' . $qrCodePath);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        QrCode::format('png')->size(200)->generate($inv->id_barang, $fullPath);

        $fileQr = basename($qrCodePath);

        $inv->update([
            'qr_code' => $fileQr,
        ]);

        return redirect()->route('inventaris.list')
            ->with('success', 'QRCode Untuk ' . $namaBarang . ' Berhasil Dibuat.');
    }

    public function edit($id)
    {
        $inventaris = Inventaris::find($id);
        $kategori = KategoriBarang::all();

        return view('inventaris.edit', compact('inventaris', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $inventaris = Inventaris::find($id);

        if (!$inventaris) {
            return redirect()->route('inventaris.list')
                ->with('error', 'Barang Inventaris Tidak Ditemukan.');
        }

        $request->validate([
            'nama_barang' => 'required',
            'foto_barang' => 'image',
            'id_kategori' => 'required',
            'harga_barang' => 'required',
            'tgl_pembelian' => 'required',
            'deskripsi_barang' => 'required',
        ], [
            'nama_barang.required' => 'Nama barang harus diisi.',
            'foto_barang.image' => 'File yang diupload harus berupa gambar.',
            'id_kategori.required' => 'Kategori barang harus diisi.',
            'harga_barang.required' => 'Harga satuan barang harus diisi.',
            'tgl_pembelian.required' => 'Tanggal pembelian barang harus diisi.',
            'deskripsi_barang.required' => 'Deskripsi barang harus diisi.',
        ]);

        $kondisiBarang = $request->kondisi;
        $statusBarang = $request->status_barang;

        if ($kondisiBarang == 'Rusak') {
            $statusBarang = 'Tidak Tersedia';
        }

        $data = [
            'nama_barang' => $request->nama_barang,
            'status_barang' => $statusBarang,
            'kondisi' => $request->kondisi,
            'harga_barang' => $request->harga_barang,
            'tgl_pembelian' => $request->tgl_pembelian,
            'id_kategori' => $request->id_kategori,
            'deskripsi_barang' => $request->deskripsi_barang,
        ];

        if ($request->foto_barang) {
            $gambar = $request->file('foto_barang')->storePublicly('inventaris', 'public');
            if (!$gambar) {
                return redirect()->back()
                    ->with('error', 'Gambar barang gagal diupload.');
            }

            $namaGambar = basename($gambar);

            if ($inventaris->gambar) {
                $path = storage_path('app/public/inventaris/' . $inventaris->gambar);

                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $data['foto_barang'] = $namaGambar;
        }

        $inventaris->update($data);

        return redirect()->route('inventaris.list', $request->id_kategori)
            ->with('success', 'Barang Inventaris Berhasil Diubah.');
    }

    public function destroy($id)
    {
        $inventaris = Inventaris::find($id);

        if (!$inventaris) {
            return redirect()->route('inventaris.list')
                ->with('error', 'Barang Inventaris Tidak Ditemukan.');
        }

        if ($inventaris->gambar) {
            $path = storage_path('app/public/inventaris/' . $inventaris->gambar);

            if (file_exists($path)) {
                unlink($path);
            }
        }

        $inventaris->delete();

        return redirect()->route('inventaris.list')
            ->with('success', 'Barang Inventaris Berhasil Dihapus.');
    }

    // Monitoring Barang

    public function monitoring()
    {
        $inventaris = Inventaris::all();
        $kategori = KategoriBarang::all();

        return view('monitoring.index', compact('inventaris', 'kategori'));
    }


}
