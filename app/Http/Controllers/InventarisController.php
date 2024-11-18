<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InventarisController extends Controller
{
    protected $inventaris;
    
    public function index()
    {
        $inventaris = Inventaris::all();
        
        return view('inventaris.list', compact('inventaris'));
    }

    public function show($id)
    {
        $inventaris = Inventaris::find($id);

        return view('inventaris.show', compact('inventaris'));
    }

    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image',
        ], [
            'nama.required' => 'Nama barang harus diisi.',
            'kategori.required' => 'Kategori barang harus diisi.',
            'deskripsi.required' => 'Deskripsi barang harus diisi.',
            'gambar.required' => 'Gambar barang harus diupload.',
            'gambar.image' => 'File yang diupload harus berupa gambar.',
        ]);

        

        $gambar = $request->file('gambar')->storePublicly('inventaris', 'public');
        if (!$gambar) {
            return redirect()->back()
                ->with('error', 'Gambar barang gagal diupload.');
        }

        $namaGambar = basename($gambar);


        $data = [
            'id' => uniqid(6),
            'name' => $request->nama,
            'kategori' => $request->kategori,
            'description' => $request->deskripsi,
            'gambar' => $namaGambar,
        ];

        $inv = Inventaris::create($data);
        

        $qrCodePath = 'qrcodes/' . $inv->id . '.png';
        $fullPath = storage_path('app/public/' . $qrCodePath);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        QrCode::format('png')->size(200)->generate($inv->id, $fullPath);

        $fileQr = basename($qrCodePath);

        $inv->update([
            'qr' => $fileQr,
        ]);


        return redirect()->route('inventaris.list')
            ->with('success', 'Barang Inventaris Berhasil Ditambahkan Dengan QRCode.');
    }

    public function qrCreate($id)
    {
        $inv = Inventaris::find($id);
        $namaBarang = $inv->name;
        $qrCodePath = 'qrcodes/' . $inv->id . '.png';
        $fullPath = storage_path('app/public/' . $qrCodePath);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        QrCode::format('png')->size(200)->generate($inv->id, $fullPath);

        $fileQr = basename($qrCodePath);

        $inv->update([
            'qr' => $fileQr,
        ]);

        return redirect()->route('inventaris.list')
            ->with('success', 'QRCode Untuk ' . $namaBarang . ' Berhasil Dibuat.');

    }

    public function edit($id)
    {
        $inventaris = Inventaris::find($id);

        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'image',
        ], [
            'nama.required' => 'Nama barang harus diisi.',
            'kategori.required' => 'Kategori barang harus diisi.',
            'deskripsi.required' => 'Deskripsi barang harus diisi.',
            'gambar.image' => 'File yang diupload harus berupa gambar.',
        ]);

        $inventaris = Inventaris::find($id);

        $data = [
            'name' => $request->nama,
            'kategori' => $request->kategori,
            'description' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            if ($inventaris->gambar) {
                $path = storage_path('app/public/inventaris/' . $inventaris->gambar);

                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $gambar = $gambar->storePublicly('inventaris', 'public');

            if (!$gambar) {
                return redirect()->back()
                    ->with('error', 'Gambar barang gagal diupload.');
            }

            $namaGambar = basename($gambar);

            $data['gambar'] = $namaGambar;
        }

        $inventaris->update($data);

        return redirect()->route('inventaris.list')
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


}
