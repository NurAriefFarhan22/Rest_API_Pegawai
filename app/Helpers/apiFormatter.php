<?php
// file ini mengatur proses pengembalian API
// namespace : mengatur posisi file ada di folder nama
// untuk mengatur posisi file ada di folder nama
// fungsi file ini untuk mengatur hasil api yang akan ditampilkan -->

namespace App\Helpers;

class ApiFormatter{
    //variable yang akan dihasilka ketika API digunakan
    protected static $response = [
        'code' => NULL,
        'message' => NULL,
        'data' => NULL,
    ];

    public static function createAPI($code = NULL, $message = NULL, $data = NULL)
    {
        // mengisi data ke variable response yang diatas
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;
        // mengembalika hasil pengisian data $response dengan format json
        return response()->json(self::$response, self::$response['code']);
    }
}
?>