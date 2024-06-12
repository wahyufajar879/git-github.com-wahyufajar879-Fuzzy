<div class="page-header">
    <h1>Perhitungan Aturan</h1>
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
        <h3 class="panel-title">Aturan</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <?php foreach ($ALTERNATIF as $key => $val) : ?>
                        <th>miu[<?= $key ?>]</th>
                        <th>z[<?= $key ?>]</th>
                        <th>a*z[<?= $key ?>]</th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $miu = $fuzzy->get_miu();
                $z = $fuzzy->get_z();
                $rules = $fuzzy->get_rules();
                $alfa_z = $fuzzy->get_alfaZ(); // Ambil nilai alfa_z di luar loop foreach untuk efisiensi
                
                // Filter rules yang memiliki nilai selain 0
                $filtered_rules = array_filter($rules, function($key) use ($miu) {
                    return array_sum($miu[$key]) != 0;
                }, ARRAY_FILTER_USE_KEY);
                
                foreach ($filtered_rules as $key => $val) :
                ?>
                    <tr>
                        <td><?= $key ?></td>
                        <?php foreach ($ALTERNATIF as $k => $v) : ?>
                            <td><?= round($miu[$key][$k], 3) ?></td>
                            <td>
                                <?php
                                $arr_z = array();
                                foreach ($z[$key][$k] as $b) {
                                    $arr_z[] = round($b, 2);
                                }
                                ?>
                                [<?= implode(',', $arr_z) ?>]
                            </td>
                            <td>
                                <?php
                                // Hitung nilai a*z
                                $az_values = array();
                                foreach ($z[$key][$k] as $z_val) {
                                    $az_values[] = round($miu[$key][$k] * $z_val, 2);
                                }
                                ?>
                                [<?= implode(',', $az_values) ?>]
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Tambahkan bagian ini untuk menampilkan akumulasi miu dan az per alternatif -->
<!-- <div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Akumulasi Per Alternatif</h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    <th>Akumulasi Miu</th>
                    <th>Akumulasi AZ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sum_miu = $fuzzy->get_sum_miu();
                $sum_az = $fuzzy->get_sum_az();
                foreach ($ALTERNATIF as $key => $val) : ?>
                    <tr>
                        <td><?= $val ?></td>
                        <td><?= isset($sum_miu[$key]) ? round($sum_miu[$key], 3) : 0 ?></td>
                        <td><?= isset($sum_az[$key]) ? round($sum_az[$key], 3) : 0 ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div> -->
