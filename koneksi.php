<?php
$koneksi = mysqli_connect("localhost", "root", "", "pertemuan9-webpro2");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
