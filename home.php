<h1>Sistem Pendukung Keputusan</h1>
<p> Aplikasi sistem pendukung  keputusan berbasis website </p>

<?php
$fuzzy = new Fuzzy(get_aturan(), get_relasi());
$fuzzy->calculate();

// Jumlah data per halaman
$per_page = 10;

// Halaman saat ini
$current_page = isset($_GET['page_defuzifikasi']) ? (int)$_GET['page_defuzifikasi'] : 1;

// Ambil semua data
$total = $fuzzy->get_total();
$rank = $fuzzy->get_rank();

// Hitung total data
$total_rows_defuzifikasi = count($rank);

// Hitung total halaman
$total_pages_defuzifikasi = ceil($total_rows_defuzifikasi / $per_page);

// Hitung offset
$offset_defuzifikasi = ($current_page - 1) * $per_page;

// Ambil data sesuai dengan halaman saat ini
$current_rank = array_slice($rank, $offset_defuzifikasi, $per_page, true);

?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Hasil Defuzifikasi</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover small">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($current_rank)) : ?>
                    <?php foreach ($current_rank as $key => $val) : ?>
                        <tr>
                            <td><?= $val ?></td>
                            <td><?= $key ?></td>
                            <td><?= $ALTERNATIF[$key] ?></td>
                            <td><?= round($total[$key], 3) ?></td>
                            <td><?= $fuzzy->get_klasifikasi($total[$key]) ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">Tidak ada data yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="text-center">
    <ul class="pagination">
        <?php if ($current_page > 1) : ?>
            <li>
                <a href="?<?= http_build_query(array_merge($_GET, ['page_defuzifikasi' => $current_page - 1])) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages_defuzifikasi; $i++) : ?>
            <li <?= $i == $current_page ? 'class="active"' : '' ?>>
                <a href="?<?= http_build_query(array_merge($_GET, ['page_defuzifikasi' => $i])) ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages_defuzifikasi) : ?>
            <li>
                <a href="?<?= http_build_query(array_merge($_GET, ['page_defuzifikasi' => $current_page + 1])) ?>" aria-label="Next">
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
