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
        $barang = Inventaris::where('id_barang', $peminjaman->id_barang)->first();
        $peminjaman['name'] = User::where('id', $peminjaman->id_user)->first()->name;

        return view('peminjaman.show', compact('peminjaman', 'barang'));
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
            'id_barang' => 'required',
            'tgl_pinjam' => 'required',
        ], [
            'id_user.required' => 'ID User harus diisi.',
            'id_barang.required' => 'ID Barang harus diisi.',
            'tgl_pinjam.required' => 'Tanggal pinjam harus diisi.',
        ]);

        $data = [
            'id_user' => $request->id_user,
            'id_barang' => $request->id_barang,
            'tgl_pinjam' => $request->tgl_pinjam,
            'status' => 'Dipinjam',
        ];

        ModelPeminjaman::create($data);

        $this->buktiPinjam($data['id_barang']);

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
        // $detailPeminjaman = DetailPeminjaman::where('id_peminjaman', $peminjaman->id_peminjaman)->get();
        // $barang = Inventaris::where('id_barang', $detailPeminjaman->id_barang)->first();
        $barang = Inventaris::where('id_barang', $peminjaman->id_barang)->first();
        $nama_peminjam = User::where('id', $peminjaman->id_user)->first()->name;


        if (!$peminjaman) {
            return redirect()->back()
                ->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $barang = Inventaris::where('id_barang', $peminjaman->id_barang)->first();

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

        // Tambahkan detail peminjam
        $section->addText("Detail Peminjam:", ['name' => 'Arial', 'size' => 10, 'bold' => true]);
        $section->addText("Nama : $nama_peminjam", ['name' => 'Arial', 'size' => 10]);

        // Tambahkan detail peminjaman
        $section->addText("Detail Peminjaman:", ['name' => 'Arial', 'size' => 10, 'bold' => true]);
        $section->addText("Tanggal Pinjam : " . $peminjaman->tgl_pinjam, ['name' => 'Arial', 'size' => 10]);
        $section->addText("Tanggal Kembali : " . $peminjaman->tgl_kembali, ['name' => 'Arial', 'size' => 10]);
        $section->addText("Keperluan : " . $peminjaman->keterangan, ['name' => 'Arial', 'size' => 10]);
        $section->addText("Status : " . $peminjaman->status, ['name' => 'Arial', 'size' => 10]);

        // Tambahkan tabel barang
        $section->addText("Detail Barang:", ['name' => 'Arial', 'size' => 10, 'bold' => true]);
        $tableStyle = ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80];
        $phpWord->addTableStyle('BarangTable', $tableStyle);

        $table = $section->addTable('BarangTable');
        $table->addRow();
        $table->addCell(2000)->addText('ID Barang', ['bold' => true]);
        $table->addCell(6000)->addText('Nama Barang', ['bold' => true]);
        $table->addCell(3000)->addText('Keterangan', ['bold' => true]);

        // foreach ($barang as $index => $item) {
        //     $table->addRow();
        //     $table->addCell(2000)->addText($index + 1);
        //     $table->addCell(6000)->addText($item['id_barang']);
        //     $table->addCell(6000)->addText($item['nama_barang']);
        //     $table->addCell(3000)->addText($item['deskripsi_barang']);
        // }

        $table->addRow();
        $table->addCell(2000)->addText($barang->id_barang);
        $table->addCell(6000)->addText($barang->nama_barang);
        $table->addCell(3000)->addText($barang->deskripsi_barang);

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
        $barang = Inventaris::where('id', $peminjaman->id_barang)->first();

        return view('peminjaman.edit', compact('peminjaman', 'barang'));
    }

    public function update(Request $request, $id)
    {

        $peminjaman = ModelPeminjaman::find($id);

        $status = $request->status;

        if ($status == 'Dikembalikan') {
            $id_barang = $peminjaman->id_barang;
            $barang = Inventaris::find($id_barang);
            $barang->status = 1;
            $dikembalikan = now();

            $data = [
                'status' => $status,
                'tanggal_dikembalikan' => $dikembalikan,
            ];

            $peminjaman->update($data);


            if (!$barang->save()) {
                return redirect()->back()
                    ->with('error', 'Data peminjaman gagal diubah.');
            }

            return redirect()->route('peminjaman.index')
                ->with('success', 'Data peminjaman berhasil diubah.');
        } else {
            return redirect()->back()
                ->with('error', 'Status peminjaman tidak valid');
        }
    }

    public function logPeminjaman()
    {
        $status = 'Dipinjam';
        $peminjaman = ModelPeminjaman::where('status', $status)->get();

        return view('peminjaman.index', compact('peminjaman'));
    }
}
