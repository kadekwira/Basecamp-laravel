<?php

if (!function_exists('convertToDouble')) {
    function convertToDouble($currencyString) {
        // Hapus semua karakter non-digit kecuali koma dan titik
        $numberString = preg_replace('/[^\d,]/', '', $currencyString);
        // Ganti koma dengan titik
        $numberString = str_replace(',', '.', $numberString);
        // Ganti titik dengan kosong untuk format ribuan
        $numberString = str_replace('.', '', substr($numberString, 0, -3)) . substr($numberString, -3);
        // Konversi menjadi double
        return (double) $numberString;
    }
}
