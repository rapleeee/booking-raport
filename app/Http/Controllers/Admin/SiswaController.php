<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('kelas')->orderBy('nama');
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        $siswa = $query->paginate(50)->withQueryString();
        $kelas = Kelas::orderBy('nama')->get();
        return view('admin.siswa.index', compact('siswa', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        Siswa::create($request->all());
        return back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return back()->with('success', 'Siswa berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SiswaTemplateExport, 'template_import_siswa.xlsx');
    }

    public function importPreview(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');
        
        $array = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\SiswaPreviewImport, $file);
        $rows = $array[0] ?? [];

        $previewData = [];
        foreach ($rows as $row) {
            // Excel mapping using headers: nama_siswa, nama_kelas (automatically slugged by WithHeadingRow)
            $namaSiswa = $row['nama_siswa'] ?? null;
            $namaKelas = $row['nama_kelas'] ?? null;

            if ($namaSiswa && $namaKelas) {
                $namaSiswa = trim($namaSiswa);
                $namaKelas = trim($namaKelas);

                // Check if class exists
                $kelas = Kelas::where('nama', $namaKelas)->first();

                $previewData[] = [
                    'nama_siswa' => $namaSiswa,
                    'nama_kelas' => $namaKelas,
                    'kelas_id'   => $kelas ? $kelas->id : null,
                    'status'     => $kelas ? 'Siap Import' : 'Error: Kelas tidak ditemukan',
                    'can_import' => $kelas ? true : false,
                ];
            }
        }

        // Save preview data to session to be processed
        session(['import_siswa_data' => $previewData]);

        return view('admin.siswa.import-preview', compact('previewData'));
    }

    public function importProcess(Request $request)
    {
        $previewData = session('import_siswa_data');
        if (!$previewData) {
            return redirect()->route('admin.siswa.index')->withErrors('Sesi import telah kadaluarsa. Silakan upload ulang file.');
        }

        $imported = 0;
        foreach ($previewData as $data) {
            if ($data['can_import']) {
                Siswa::create([
                    'nama' => $data['nama_siswa'],
                    'kelas_id' => $data['kelas_id']
                ]);
                $imported++;
            }
        }

        session()->forget('import_siswa_data');

        return redirect()->route('admin.siswa.index')->with('success', "Berhasil import $imported data siswa.");
    }
}
