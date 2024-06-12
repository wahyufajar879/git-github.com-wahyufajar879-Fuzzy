<div class="page-header">
    <h1>Perhitungan Nilai Fuzzy</h1>
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
        <h3 class="panel-title">Nilai Fuzzy</h3>
    </div>
    <?php

    // Jumlah data per halaman
    $per_page = 10;

    // Halaman saat ini
    $current_page = isset($_GET['page_fuzzy']) ? (int)$_GET['page_fuzzy'] : 1;

    // Ambil semua data
    $all_data_fuzzy = $fuzzy->get_nilai();

    // Hitung total data
    $total_rows_fuzzy = count($all_data_fuzzy);

    // Hitung total halaman
    $total_pages_fuzzy = ceil($total_rows_fuzzy / $per_page);

    // Hitung offset
    $offset_fuzzy = ($current_page - 1) * $per_page;

    // Ambil data sesuai dengan halaman saat ini
    $current_data_fuzzy = array_slice($all_data_fuzzy, $offset_fuzzy, $per_page);

    ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover small">
            <thead>
                <tr>
                    <!-- <th rowspan="3">Kode</th> -->
                    <th rowspan="3">Nama</th>
                    <?php foreach ($ATRIBUT[0] as $key => $val) : ?>
                        <th colspan="<?= count($KRITERIA_HIMPUNAN[$key]) ?>" class="text-center"><?= $val->nama_kriteria ?></th>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <?php foreach ($ATRIBUT[0] as $key => $val) : ?>
                        <?php foreach ($KRITERIA_HIMPUNAN[$key] as $k => $v) : ?>
                            <td><?= $HIMPUNAN[$k]->nama_himpunan ?><br />[<?= $HIMPUNAN[$k]->n1 ?> <?= $HIMPUNAN[$k]->n2 ?> <?= $HIMPUNAN[$k]->n3 ?> <?= $HIMPUNAN[$k]->n4 ?>]</td>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($current_data_fuzzy)) : ?>
                <?php foreach ($current_data_fuzzy as $key => $val) : ?>
                    <tr>
                        <!-- <td><?= $key ?></td> -->
                        <td><?= $ALTERNATIF[$key] ?></td>
                        <?php foreach ($val as $k => $v) : ?>
                            <?php foreach ($v as $a => $b) : ?>
                                <td><?= round($b, 3) ?></td>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            <?php else : ?>
                <tr>
                    <td colspan="<?= count($ATRIBUT[0]) * count($HIMPUNAN) + 2 ?>">Tidak ada data yang ditemukan.</td>
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
                <a href="?<?= http_build_query(array_merge($_GET, ['page_fuzzy' => $current_page - 1])) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages_fuzzy; $i++) : ?>
            <li <?= $i == $current_page ? 'class="active"' : '' ?>>
                <a href="?<?= http_build_query(array_merge($_GET, ['page_fuzzy' => $i])) ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages_fuzzy) : ?>
            <li>
                <a href="?<?= http_build_query(array_merge($_GET, ['page_fuzzy' => $current_page + 1])) ?>" aria-label="Next">
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
