<div class="page-header">
    <h1>Perhitungan Nilai Alternatif</h1>
</div>
<?php

$fuzzy = new Fuzzy(get_aturan(), get_relasi());
$fuzzy->calculate();

// Jumlah data per halaman
$per_page = 10;

// Halaman saat ini
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Ambil semua data
$all_data = $fuzzy->get_data();

// Hitung total data
$total_rows = count($all_data);

// Hitung total halaman
$total_pages = ceil($total_rows / $per_page);

// Hitung offset
$offset = ($current_page - 1) * $per_page;

// Ambil data sesuai dengan halaman saat ini
$current_data = array_slice($all_data, $offset, $per_page);

?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Nilai Alternatif</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <?php foreach ($ATRIBUT[0] as $key => $val) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php if (!empty($current_data)) : ?>
                <?php foreach ($current_data as $key => $val) : ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?= $ALTERNATIF[$key] ?></td>
                        <?php foreach ($val as $k => $v) : ?>
                            <td><?= $v ?></td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            <?php else : ?>
                <tr>
                    <td colspan="<?= count($ATRIBUT[0]) + 2 ?>">Tidak ada data yang ditemukan.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
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






