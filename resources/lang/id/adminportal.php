<?php

return [
     'auth' => [
          'login' => [
               'title' => 'Masuk',
               'description' => 'Masukkan email dan kata sandi Anda di bawah untuk masuk ke akun Anda',
               'failed' => 'Email atau kata sandi tidak valid. Silakan coba lagi.',
          ],
          'sigup' => [
               'title' => 'Daftar',
               'description' => 'Masukkan email dan kata sandi Anda untuk membuat akun.',
          ],
          'verification' => [
               'title' => 'Verifikasi Email Anda',
               'description' => "Sebelum melanjutkan, dapatkah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda? Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan email lainnya."
          ],
          'forgot_password' => [
               'title' => 'Lupa Kata Sandi',
               'continue' => 'Lanjutkan',
               'description' => 'Masukkan email terdaftar Anda dan kami akan mengirimkan tautan untuk mereset kata sandi Anda.',
               'mailed_link' => 'Kami telah mengirimkan tautan reset kata sandi Anda.'
          ],
          'reset_password' => [
               'title' => 'Reset Kata Sandi',
               'description' => "Masukkan kata sandi baru Anda di bawah untuk mereset akses akun Anda. Pastikan untuk memilih kata sandi yang kuat dan belum pernah Anda gunakan sebelumnya."
          ]
     ],

     'form' => [
          'email' => 'Alamat Email',
          'current_password' => 'Kata Sandi Saat Ini',
          'new_password' => 'Kata Sandi Baru',
          'password' => 'Kata Sandi',
          'password_confirmation' => 'Konfirmasi Kata Sandi',
          'name' => 'Nama'
     ],

     'label' => [
          'dont_have_an_account' => "Belum punya akun?",
          'have_an_account' => "Sudah punya akun?",
          'resend_verification_email' => "Kirim Ulang Email Verifikasi",
          'login_with_another_acount' => 'Coba dengan akun lain?',
          "logout" => "Keluar",
          'link_verification_expired' => 'Tautan verifikasi Anda telah kedaluwarsa. Silakan minta yang baru.',
     ],

     'expose' => [
          'create_data_module' => 'Buat :module Baru',
          'create_data_module_description' => "Buat :module baru di sini. Klik simpan setelah Anda selesai.",
          'edit_module' => 'Edit :module',
          'edit_data_module_description' => "Perbarui :module Anda di sini. Klik simpan setelah Anda selesai."
     ],

     'alert' => [
          'data_created' => 'Data Anda telah berhasil dibuat!',
          'data_updated' => 'Data Anda telah berhasil diperbarui!',
          'data_deleted' => 'Data Anda telah berhasil dihapus!',
          'bulk_action_success' => 'Data yang Anda pilih telah berhasil ":action"!',
          'profile_updated' => 'Profil Anda telah berhasil diperbarui!',
          'password_updated' => 'Kata sandi Anda telah berhasil diperbarui!',
          'import_success' => 'Data Anda telah berhasil diimpor!',
          'confirmation' => [
               'logout_title' => 'Keluar!',
               'logout_description' => 'Apakah Anda yakin ingin meninggalkan halaman ini?',
               'delete_title' => 'Apakah Anda yakin ingin menghapus data ini?',
               'delete_description' => 'Tindakan ini akan menghapus data secara permanen dari sistem. Ini tidak dapat dibatalkan.'
          ]
     ],
     'export' => 'Ekspor',
     'import' => 'Impor',
     'create' => 'Buat',
     'filter' => 'Filter',
     'reset' => 'Reset',
     'apply' => 'Terapkan',
     'bulk_actions' => 'Tindakan Massal',
     'action' => 'Tindakan',
     'cancel' => 'Batal',
     'save' => 'Simpan Perubahan',
     'continue' => 'Lanjutkan'
];
