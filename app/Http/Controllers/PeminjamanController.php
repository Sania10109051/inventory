<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman as ModelPeminjaman;
use App\Models\Inventaris;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = ModelPeminjaman::all();

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function show($id)
    {
        $peminjaman = ModelPeminjaman::find($id);
        $barang = Inventaris::where('id', $peminjaman->id_barang)->first();

        return view('peminjaman.show', compact('peminjaman', 'barang'));
    }

    public function create()
    {
        $inventaris = Inventaris::where('status', 1)->get();

        return view('peminjaman.add', compact('inventaris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'nama_peminjam' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required',
        ], [
            'id_barang.required' => 'Barang harus dipilih.',
            'nama_peminjam.required' => 'Nama peminjam harus diisi.',
            'tanggal_pinjam.required' => 'Tanggal pinjam harus diisi.',
            'tanggal_kembali.required' => 'Tanggal kembali harus diisi.',
        ]);

        $id_barang = $request->id_barang;
        $barang = Inventaris::find($id_barang);
        $barang->status = 0;
        
        $data = [
            'id_barang' => $id_barang,
            'nama_peminjam' => $request->nama_peminjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'Dipinjam',
        ];


        ModelPeminjaman::create($data);
        

        if (!$barang->save()) {
            return redirect()->back()
                ->with('error', 'Data peminjaman gagal ditambahkan.');
        }
        
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

        if (!$peminjaman) {
            return redirect()->back()
                ->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $barang = Inventaris::where('id', $peminjaman->id_barang)->first();

        $qrCodePath = 'qrPeminjaman/' . $peminjaman->id . '.png';
        $fullPath = storage_path('app/public/' . $qrCodePath);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        QrCode::format('png')->size(200)->generate($peminjaman->id, $fullPath);



        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        $section->addText('BUKTI PEMINJAMAN BARANG', ['name' => 'Arial', 'size' => 16, 'bold' => true], ['align' => 'center']);
        $section->addTextBreak(1);

        $table = $section->addTable();

        $tableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80);
        $phpWord->addTableStyle('Peminjaman Table', $tableStyle);
        $table = $section->addTable('Peminjaman Table');

        $table->addRow();
        $table->addCell(4000, ['valign' => 'center'])->addText('Nama Peminjam', ['bold' => true]);
        $table->addCell(8000, ['valign' => 'center'])->addText($peminjaman->nama_peminjam);

        $table->addRow();
        $table->addCell(4000, ['valign' => 'center'])->addText('Nama Barang', ['bold' => true]);
        $table->addCell(8000, ['valign' => 'center'])->addText($barang->name);

        $table->addRow();
        $table->addCell(4000, ['valign' => 'center'])->addText('Kategori Barang', ['bold' => true]);
        $table->addCell(8000, ['valign' => 'center'])->addText($barang->kategori);

        $table->addRow();
        $table->addCell(4000, ['valign' => 'center'])->addText('Deskripsi Barang', ['bold' => true]);
        $table->addCell(8000, ['valign' => 'center'])->addText($barang->description);

        $table->addRow();
        $table->addCell(4000, ['valign' => 'center'])->addText('Tanggal Pinjam', ['bold' => true]);
        $table->addCell(8000, ['valign' => 'center'])->addText($peminjaman->tanggal_pinjam);

        $table->addRow();
        $table->addCell(4000, ['valign' => 'center'])->addText('Tanggal Kembali', ['bold' => true]);
        $table->addCell(8000, ['valign' => 'center'])->addText($peminjaman->tanggal_kembali);

        $table->addRow();
        $table->addCell(4000, ['valign' => 'center'])->addText('Status', ['bold' => true]);
        $table->addCell(8000, ['valign' => 'center'])->addText($peminjaman->status);

        $section->addTextBreak(1);

        $section->addText('QR Code Peminjaman', ['name' => 'Arial', 'size' => 14, 'bold' => true], ['align' => 'center']);
        $section->addTextBreak(1);
        $section->addImage(public_path('storage/' . $qrCodePath), ['width' => 200, 'height' => 200, 'align' => 'center']);

        $filename = 'BuktiPeminjaman_' . $peminjaman->id . '.docx';
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
        }

        else {
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
