<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
// import
use App\Helpers\ApiFormatter;
use Exception;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search_nama;
        // ambil data dari key limit bagian params nya postman
        $limit = $request->limit;
        // cari data berdasarkan yang di search
        $pegawais = Pegawai::where('nama', 'LIKE', '%'.$search.'%')->limit($limit)->get();
        // $pegawais = Pegawai::all();
        if ($pegawais) {
            // kalau data berhasil diambil
            return ApiFormatter::createAPI(200, 'success', $pegawais);
        }else {
            // kalau data gagal diambil
            return ApiFormatter::createAPI(400, 'failde');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|min:3',
                'umur' => 'required',
                'tgl' => 'required',
            ]);
            // mengirim data ke table students lewat model dtudents
            $pegawai = Pegawai::create([
                'nama' => $request->nama,
                'umur' => $request->umur,
                'tgl' => $request->tgl,
            ]);
            // cari data baru yang berhaasil di simpen, cari berdasarkan id lewat data id dari $students yg disimpan diatas
            $hasilTambahData = Pegawai::where('id', $pegawai->id)->first();
            if ($hasilTambahData) {
                return ApiFormatter::createAPI(200, 'success', $pegawai);
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            // munculindeskripsi error yang bakalbakal tampil di property data jsonnya
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function createToken()
    {
        return csrf_token();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         // coba baris code didalam try
         try {
            // ambil data dari table students yang id nya samak kayak yang $id dari path routenya
            // where $ find fungsi mencari, bedanya : where nyari berdasarkan column apa aja boleh, kalo find uuma bisa cari berdasarkan id
            $pegawais = Pegawai::find($id);
            if ($pegawais) {
                // kalau data berhasil diambil, tampilkan data dari $pegawais nya dengan tanda status code 200
                return ApiFormatter::createAPI(200, 'success', $pegawais);
            }else {
                // kalau data gagal diambil/gak ada, yang dikembaliikan status code 400
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            // kalau pas try ada error, deskripsi errornya ditampilkan dengan status code 400
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // cek validasi imputan di body postman
            $request->validate([
                'nama' =>'required',
                'umur' =>'required|',
                'tgl' =>'required',
            ]);
            // ambil data yang akan diubah
            $pegawais = Pegawai::find($id);
            // update data yang telah diambil diatas
            $pegawais->update([
                'nama' => $request->nama,
                'umur' => $request->umur,
                'tgl' => $request->tgl
            ]);
            // cari data yang berhasil diubah tadi, cari berdasarka id dari $pegawais yang diambil data diawal
            $dataTerbaru = Pegawai::where('id', $pegawais->id)->first();
            if ($dataTerbaru) {
                // jika update berhasil, tampilkan data dari $updateStudent diatas (data yang sdh berhasil diubah)
                return ApiFormatter::createAPI(200, 'success', $dataTerbaru);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            // jika di baris code try ada trouble, error dimunculkan dengan sesc err nya dengan status code 400
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // ambil data yang mau dihapus
            $student = Pegawai::find($id);
            // hapus data yg diambil diatas
            $cekBerhasil = $student->delete();
            if ($cekBerhasil) {
                // kalau berhasil hapus, data yang dimunculkan text konfirm dengan status code 200
                return ApiFormatter::createAPI(200, 'success', 'Data deleted!!');
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            // kalau ada trouble di baris kode dalam try, error desc nya dimunculkan
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function trash()
    {
        try {
            // ambil data yang sudah dihapus sementara
            $pegawais = Pegawai::onlyTrashed()->get();
            if ($pegawais) {
                // kalau data berhaasil terambil, tampilkaan status 200 dengan data dari $pegawais
                return ApiFormatter::createAPI(200, 'success', $pegawais);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            // kalau ada error di try, catch akan menampilkan desc error nya
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            // ambil data yang akan di batal hapus, diambil berdasarkan id dari route nya
            $pegawais = Pegawai::onlyTrashed()->where('id', $id);
            // kembalikan data
            $pegawais->restore();
            // ambil kembali data yang sudah do restore
            $datakembali = Pegawai::where('id', $id)->first();
            if ($datakembali) {
                // jika seluruh proses nya dapat dijalankan, data yg sudah dikembalika dan diambil dari tampilkan pada response 200
                return ApiFormatter::createAPI(200, 'success', $datakembali);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function permanentDelete($id)
    {
        try {
            // ambil data yang dihapus
            $pegawais = Pegawai::onlyTrashed()->where('id', $id);
            // menghapsu permanent data yaang diambil
            $proses = $pegawais->forceDelete();
           return ApiFormatter::createAPI(200, 'success', 'berhasil hapus data permanent!');
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }
}
