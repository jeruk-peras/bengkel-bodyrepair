<?php

namespace App\Libraries;

class PasswordValidation
{


    /**
     * password validation
     * @param string $password
     * @return bool/string
     */

    public function password_strength(string $password)
    {
        $regex = '/^';
        $regex .= '(?=.*\d)'; // password memiliki setidaknya satu angka.
        $regex .= '(?=.*[a-z])'; //  password memiliki setidaknya satu huruf kecil.
        $regex .= '(?=.*[A-Z])'; // password memiliki setidaknya satu huruf besar.
        $regex .= '(?=.*[!@#$%])';  // Memastikan ada setidaknya satu karakter spesial dari kumpulan !@#$%.
        $regex .= '[0-9A-Za-z!@#$%]{8,12}'; // Memastikan panjang string antara 8 hingga 12 karakter, hanya terdiri dari karakter yang diizinkan.
        // $regex .= '.{8,12}'; // panjang password antara 8 hingga 12 karakter.
        $regex .= '$/';

        // #regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{8,12}$/
        if (!preg_match($regex, $password)) {
            $error = 'Minimal 8 Karakter kombinasi huruf kapital, huruf kecil, angka dan simbol.';
            return false;
        } else {
           return true;
        }

    }

    public function validpassword($password)
    {
        $message = '';

        // Aturan 1: Memastikan ada setidaknya satu angka
        if (!preg_match('/\d/', $password)) {
            $message .= 'Password harus memiliki setidaknya satu angka.\n';
        }

        // Aturan 2: Memastikan ada setidaknya satu huruf kecil
        if (!preg_match('/[a-z]/', $password)) {
            $message .= 'Password harus memiliki setidaknya satu huruf kecil.\n';
        }

        // Aturan 3: Memastikan ada setidaknya satu huruf besar
        if (!preg_match('/[A-Z]/', $password)) {
            $message .= 'Password harus memiliki setidaknya satu huruf besar.\n';
        }

        // Aturan 4: Memastikan ada setidaknya satu karakter spesial dari kumpulan !@#$%
        if (!preg_match('/[!@#$%]/', $password)) {
            $message .= 'Password harus memiliki setidaknya satu karakter spesial (!@#$%).\n';
        }

        // Aturan 5: Memastikan panjang password antara 8 hingga 12 karakter
        if (strlen($password) < 8 || strlen($password) > 12) {
            $message .= 'Password harus memiliki panjang antara 8 hingga 12 karakter.\n';
        }

        // Jika semua aturan terpenuhi
        if ($message === '') {
            $message = true;
        }

        return $message;
    }
}
