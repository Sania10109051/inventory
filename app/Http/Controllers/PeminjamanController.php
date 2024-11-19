<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman as ModelPeminjaman;
use App\Models\Inventaris;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use App\Models\DetailPeminjaman;

class PeminjamanController extends Controller
{

    public function index()
    {
        $peminjaman = ModelPeminjaman::all();
        $users = User::all();

        return view('peminjaman.index', compact('peminjaman', 'users'));
    }

    public function show($id)
    {
        $peminjaman = ModelPeminjaman::find($id);
        $detailPeminjaman = DetailPeminjaman::where('id_peminjaman', $id)->get();
        $barang = Inventaris::whereIn('id_barang', $detailPeminjaman->pluck('id_barang'))->get();
        $users = User::where('id', $peminjaman->id_user)->first();

        if (!$peminjaman) {
            return redirect()->back()
                ->with('error', 'Data peminjaman tidak ditemukan.');
        }

        return view('peminjaman.show', compact('peminjaman', 'barang', 'users'));
    }

    public function create()
    {
        $inventaris = Inventaris::where('status_barang', 'Tersedia')->get();
        $users = User::all();

        return view('peminjaman.add', compact('inventaris', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'id_barang' => 'required|array',
            'id_barang.*' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_tenggat' => 'required',
            'keterangan' => 'required',
        ], [
            'id_user.required' => 'ID User harus diisi.',
            'id_barang.required' => 'ID Barang harus diisi.',
            'id_barang.*.required' => 'ID Barang harus diisi.',
            'tgl_pinjam.required' => 'Tanggal pinjam harus diisi.',
            'tgl_tenggat.required' => 'Tanggal tenggat harus diisi.',
            'keterangan.required' => 'Keterangan harus diisi.',
        ]);

        $id_user = $request->id_user;
        $tgl_pinjam = $request->tgl_pinjam;
        $tgl_tenggat = $request->tgl_tenggat;
        $id_barang_list = $request->id_barang;

        $data = [
            'id_user' => $id_user,
            'tgl_pinjam' => $tgl_pinjam,
            'tgl_tenggat' => $tgl_tenggat,
            'status' => 'Dipinjam',
            'keterangan' => $request->keterangan,
        ];

        $peminjaman = ModelPeminjaman::create($data);

        foreach ($id_barang_list as $id_barang) {
            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_barang' => $id_barang,
            ]);
        }

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function scanReturn(Request $request)
    {
        $id_barang = $request->id_barang;

        return redirect()->route('peminjaman.show', $id_barang);
    }


    public function buktiPinjam($id)
    {
        $peminjaman = ModelPeminjaman::find($id);
        $detailPeminjaman = DetailPeminjaman::where('id_peminjaman', $peminjaman->id_peminjaman)->get();
        $barang = Inventaris::whereIn('id_barang', $detailPeminjaman->pluck('id_barang'))->get();
        // $barang = Inventaris::where('id_barang', $peminjaman->id_barang)->first();
        $nama_peminjam = User::where('id', $peminjaman->id_user)->first()->name;


        if (!$peminjaman) {
            return redirect()->back()
                ->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $qrCodePath = 'qrPeminjaman/' . $peminjaman->id_peminjaman . '.png';
        $fullPath = storage_path('app/public/' . $qrCodePath);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        QrCode::format('png')->size(200)->generate($peminjaman->id_peminjaman, $fullPath);



        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        // Tambahkan judul dokumen
        $section->addText(
            'INVOICE PEMINJAMAN BARANG INVENTARIS',
            ['name' => 'Arial', 'size' => 16, 'bold' => true],
            ['align' => 'center']
        );

        // Tambahkan jarak setelah judul
        $section->addTextBreak(1);

        // Tambahkan detail peminjaman
        $section->addText("Detail Peminjaman:", ['name' => 'Arial', 'size' => 10, 'bold' => true]);

        $tableStyle = ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80];
        $phpWord->addTableStyle('DetailPeminjamanTable', $tableStyle);

        $table = $section->addTable('DetailPeminjamanTable');
        $table->addRow();
        $table->addCell(3000)->addText('Nama Peminjam', ['bold' => true]);
        $table->addCell(6000)->addText($nama_peminjam);

        $table = $section->addTable('DetailPeminjamanTable');
        $table->addRow();
        $table->addCell(3000)->addText('Tanggal Pinjam', ['bold' => true]);
        $table->addCell(6000)->addText($peminjaman->tgl_pinjam);

        $table->addRow();
        $table->addCell(3000)->addText('Tanggal Kembali', ['bold' => true]);
        $table->addCell(6000)->addText($peminjaman->tgl_tenggat);

        $table->addRow();
        $table->addCell(3000)->addText('Keperluan', ['bold' => true]);
        $table->addCell(6000)->addText($peminjaman->keterangan);

        $table->addRow();
        $table->addCell(3000)->addText('Status', ['bold' => true]);
        $table->addCell(6000)->addText($peminjaman->status);

        // Tambahkan tabel barang
        $section->addText("Detail Barang:", ['name' => 'Arial', 'size' => 10, 'bold' => true]);
        $tableStyle = ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80];
        $phpWord->addTableStyle('BarangTable', $tableStyle);

        $table = $section->addTable('BarangTable');
        $table->addRow();
        $table->addCell(2000)->addText('ID Barang', ['bold' => true]);
        $table->addCell(6000)->addText('Nama Barang', ['bold' => true]);
        $table->addCell(3000)->addText('Keterangan', ['bold' => true]);

        foreach ($barang as $item) {
            $table->addRow();
            $table->addCell(2000)->addText($item->id_barang);
            $table->addCell(6000)->addText($item->nama_barang);
            $table->addCell(3000)->addText($item->deskripsi_barang);
        }

        // $table->addRow();
        // $table->addCell(2000)->addText($barang->id_barang);
        // $table->addCell(6000)->addText($barang->nama_barang);
        // $table->addCell(3000)->addText($barang->deskripsi_barang);

        // Tambahkan QR Code
        $section->addTextBreak(1);
        $section->addText(
            'QR Code Verifikasi',
            ['name' => 'Arial', 'size' => 14, 'bold' => true],
            ['align' => 'center']
        );
        $section->addImage(
            $fullPath,
            [
                'width' => 75,
                'height' => 75,
                'align' => 'center'
            ]
        );

        // Tambahkan catatan
        $section->addTextBreak(1);
        $section->addText('Catatan:', ['name' => 'Arial', 'size' => 10, 'bold' => true]);
        $section->addText(
            '1. Barang yang dipinjam harus dikembalikan sesuai dengan tanggal yang disepakati.',
            ['name' => 'Arial', 'size' => 10]
        );
        $section->addText(
            '2. Jika barang rusak atau hilang, peminjam bertanggung jawab atas biaya penggantian.',
            ['name' => 'Arial', 'size' => 10]
        );

        // Tambahkan ruang tanda tangan
        $section->addTextBreak(1);

        $table = $section->addTable();
        $table->addRow();

        // Penanggung Jawab
        $cell1 = $table->addCell(6000);
        $cell1->addText("PJ Inventaris,", ['name' => 'Arial', 'size' => 10]);
        $cell1->addTextBreak(3); // Space for signature
        $cell1->addText("__________________", ['name' => 'Arial', 'size' => 10]);

        $cell2 = $table->addCell(4000);
        $cell2->addTextBreak(3); // Space for signature

        // Peminjam
        $cell3 = $table->addCell(4000);
        $cell3->addText("Peminjam,", ['name' => 'Arial', 'size' => 10]);
        $cell3->addTextBreak(3); // Space for signature
        $cell3->addText("__________________", ['name' => 'Arial', 'size' => 10]);


        $filename = 'InvoicePeminjaman_' . $peminjaman->id_peminjaman . '.docx';
        $path = storage_path('app/public/bukti_peminjaman/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($path);

        return response()->download($path);
    }



    public function edit($id)
    {
        $peminjaman = ModelPeminjaman::find($id);
        $detailPeminjaman = DetailPeminjaman::where('id_peminjaman', $peminjaman->id_peminjaman)->get();
        $barang = Inventaris::whereIn('id_barang', $detailPeminjaman->pluck('id_barang'))->get();
        $users = User::where('id', $peminjaman->id_user)->first();

        return view('peminjaman.edit', compact('peminjaman', 'barang', 'users'));
    }

    public function update(Request $request, $id)
    {

        $peminjaman = ModelPeminjaman::find($id);
        if (!$peminjaman) {
            return redirect()->back()
                ->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $status = $request->status;
        $kondisi = $request->kondisi;
        if ($status == 'Dikembalikan') {
            $peminjaman->status = $status;
            $peminjaman->tgl_kembali = date('Y-m-d');
            $peminjaman->save();

            $barang = Inventaris::where('id_barang', $peminjaman->id_barang)->first();
            $barang->status_barang = 'Tersedia';
            $barang->kondisi = $kondisi;

            if (!$barang->save()) {
                return redirect()->back()
                    ->with('error', 'Data peminjaman gagal diubah.');
            }

            return redirect()->route('peminjaman.index')
                ->with('success', 'Data peminjaman berhasil diubah.');
        } else {
            return redirect()->back()
                ->with('error', 'Status peminjaman tidak valid.');
        }
    }

    public function logPeminjaman()
    {
        $status = 'Dipinjam';
        $peminjaman = ModelPeminjaman::where('status', $status)->get();

        return view('peminjaman.index', compact('peminjaman'));
    }
}
