<?php
    include_once("config.php");
    
    //Inisialisasi sesi
    session_start();
    
    //Mengecek apakah user telah login, jika tidak akan kembali ke halaman login
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: loginadmin.php");
        exit;
    }

    $listpaket = mysqli_query($link, "SELECT * FROM paket WHERE is_delete=0 ORDER BY id_paket");
    $listpelanggan = mysqli_query($link, "SELECT * FROM pelanggan WHERE is_delete=0 ORDER BY id_pelanggan");
    $listnota = mysqli_query($link, "SELECT pembayaran.id_transaksi, pelanggan.nama, pelanggan.no_hp, pelanggan.no_ktp, paket.nama_paket, paket.jenis_paket, pembayaran.jumlah, pembayaran.tanggal, paket.harga*pembayaran.jumlah AS total_harga FROM paket INNER JOIN pembayaran ON paket.id_paket=pembayaran.id_paket INNER JOIN pelanggan ON pelanggan.id_pelanggan=pembayaran.id_pelanggan WHERE pembayaran.is_delete = 0 ORDER BY nama");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Homepage Admin</title>
        <style>
            h3 {
                text-align: center;
            }
            table {
                margin-left: auto;
                margin-right: auto;
            }
            th {
                padding: 10px 10px 10px 10px;
                text-align: center;
            }
            tr  {
                text-align: center;
            }
            td {
                padding: 10px 10px 10px 10px;
            }
            p {
                text-align: center;
            }
            .Tabel {
                margin-bottom: 10px;
                margin-left: 20px;
                margin-right: 20px;
                border-style: solid;
            }
        </style>
    </head>
    <body>
        <div style="text-align: center">
            <h1>Data Keseluruhan SiLambat</h1>
        </div>
        
        <div class='Tabel'>
        <h3>Daftar Paket</h3>
        <table width='80%' border=1>
        <p>
            <a href="addPaket.php">Tambah Paket</a>
        </p> 
            <tr>
                <th>ID Paket</th> <th>Nama Paket</th> <th>Jenis Paket</th> <th>Harga</th> <th>Modifikasi</th>   
            </tr>

            <?php
                while($item = mysqli_fetch_array($listpaket)) {
                    echo "<tr>"; 
                    echo "<td>".$item['id_paket']."</td>"; 
                    echo "<td>".$item['nama_paket']."</td>"; 
                    echo "<td>".$item['jenis_paket']."</td>"; 
                    echo "<td>".$item['harga']."</td>"; 
                    echo "<td><a href='editPaket.php?id_paket=$item[id_paket]'>Edit</a> 
                    | 
                    <a href='softdeletePaket.php?id_paket=$item[id_paket]'>Soft Delete</a></td></tr>";
                }
            ?>
        </table><br>
        </div>

        <div class='Tabel'>
        <h3>Daftar Pelanggan</h3>
        <table width='80%' border=1>
        <p>
            <a href="addPelanggan.php">Tambah Pelanggan</a>
        </p> 
            <tr>
                <th>ID Pelanggan</th> <th>Nama Pelanggan</th> <th>No. HP</th> <th>No. KTP</th> <th>Modifikasi</th> 
            </tr>
        
            <?php
                while($item = mysqli_fetch_array($listpelanggan)) {
                    echo "<tr>"; 
                    echo "<td>".$item['id_pelanggan']."</td>"; 
                    echo "<td>".$item['nama']."</td>"; 
                    echo "<td>".$item['no_hp']."</td>"; 
                    echo "<td>".$item['no_ktp']."</td>";
                    echo "<td><a href='editPelanggan.php?id_pelanggan=$item[id_pelanggan]'>Edit</a> 
                    | 
                    <a href='softdeletePelanggan.php?id_pelanggan=$item[id_pelanggan]'>Soft Delete</a></td></tr>"; 
                }
            ?>
        </table><br>
        </div>
        
        <div class='Tabel'>
        <h3>Daftar Transaksi</h3>
        <table width='80%' border=1>
        <p>
            <a href="addPembayaran.php">Tambah Transaksi</a>
        </p>
            <tr>
                <th>Nama Pelanggan</th> <th>No. HP</th> <th>No. KTP</th> <th>Nama Paket</th> <th>Jenis Paket</th> <th>Jumlah</th> <th>Tanggal</th> <th>Total Harga</th> <th>Modifikasi</th>
            </tr>
            
            <?php
                while($item = mysqli_fetch_array($listnota)) {
                    echo "<tr>";
                    echo "<td>".$item['nama']."</td>";
                    echo "<td>".$item['no_hp']."</td>";
                    echo "<td>".$item['no_ktp']."</td>";
                    echo "<td>".$item['nama_paket']."</td>";
                    echo "<td>".$item['jenis_paket']."</td>";
                    echo "<td>".$item['jumlah']."</td>";
                    echo "<td>".$item['tanggal']."</td>";
                    echo "<td>".$item['total_harga']."</td>";
                    echo "<td><a href='editPembayaran.php?id_transaksi=$item[id_transaksi]'>Edit</a> 
                    | 
                    <a href='softdeletePembayaran.php?id_transaksi=$item[id_transaksi]'>Soft Delete</a></td></tr>";
                } 
            ?>
        </table><br>
        </div>
        
        <div style="text-align: center">
            <b><a href="viewSoftDelete.php">Recycle Bin</a></b>
        </div>

        <p>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out</a>
        </p>
    </body>
</html>