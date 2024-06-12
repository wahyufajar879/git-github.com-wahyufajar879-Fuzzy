<?php
// Jumlah data per halaman
$per_page = 10;

// Halaman saat ini
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Escape the search query to prevent SQL injection
$q = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';

// Hitung offset
$offset = ($current_page - 1) * $per_page;

// Query untuk mendapatkan jumlah total data
$total_rows = $db->get_var("SELECT COUNT(*) FROM tb_alternatif 
    WHERE kode_alternatif LIKE '%$q%' 
        OR nama_alternatif LIKE '%$q%'");

// Hitung total halaman
$total_pages = ceil($total_rows / $per_page);

// Query untuk mengambil data dengan batasan LIMIT
$rows = $db->get_results("SELECT * FROM tb_alternatif 
    WHERE kode_alternatif LIKE '%$q%' 
        OR nama_alternatif LIKE '%$q%'
    ORDER BY kode_alternatif
    LIMIT $offset, $per_page");

$no = ($current_page - 1) * $per_page;

?>
<head>
    <style>
        .pagination {
            margin: 10px 0;
            padding: 0;
            list-style: none;
            text-align: center;
        }
        
        .pagination li {
            display: inline-block;
            margin-right: 0px;
        }
        
        .pagination li a {
            color: #007bff;
            text-decoration: none;
            padding: 8px 12px;
            border: 1px solid #007bff;
            border-radius: 5px;
        }
        
        .pagination li.active a {
            background-color: #007bff;
            color: #fff;
        }
        
        .pagination li a:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>

<div class="page-header">
    <h1>Alternatif</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline" method="GET">
            <input type="hidden" name="m" value="alternatif" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>" />
            </div>
            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Cari</button>
            <a class="btn btn-success" href="?m=alternatif"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
            <a class="btn btn-primary" href="?m=alternatif_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
        </form>
    </div>
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Alternatif</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php foreach ($rows as $row): ?>
            <!-- Tampilkan data di sini -->
            <tr>
                <td><?= ++$no ?></td>
                <td><?= $row->kode_alternatif ?></td>
                <td><?= $row->nama_alternatif ?></td>
                <td><?= $row->keterangan ?></td>
                <td>
                    <a class="btn btn-xs btn-warning" href="?m=alternatif_ubah&ID=<?= $row->kode_alternatif ?>"><span class="glyphicon glyphicon-edit"></span></a>
                    <a class="btn btn-xs btn-danger" href="aksi.php?act=alternatif_hapus&ID=<?= $row->kode_alternatif ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div class="text-center">
    <ul class="pagination">
        <?php if ($current_page > 1) : ?>
            <li>
                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $current_page - 1])) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <li <?= $i == $current_page ? 'class="active"' : '' ?>>
                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>
        
        <?php if ($current_page < $total_pages) : ?>
            <li>
                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $current_page + 1])) ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>
