<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header, .footer {
            background: #d3d3d3;
            text-align: center;
            padding: 10px;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }
        .footer {
            border-radius: 0 0 8px 8px;
            font-size: 14px;
            margin-top: 10px;
        }
        p {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }
        b {
            color: #007BFF;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Laporan Perkembangan Siswa</div>
        <p>Assalamualaikum Wr. Wb.</p>
        <p>Dengan hormat, berikut kami lampirkan laporan perkembangan ananda <b>{{ $siswa->nama_lengkap }}</b> untuk bulan <b>{{ $bulan }}</b>.</p>
        <p>Terima kasih, Wassalamualaikum Wr. Wb.</p>
        <div class="footer">&copy; 2025  | Semua Hak Dilindungi</div>
    </div>
</body>
</html>
