<?php

$fuzzy = new TsukamotoPakar(get_aturan(), $_POST['nilai']);
$fuzzy->calculate();

?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Nilai Fuzzy</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover small">
            <thead>
                <tr>
                    <th rowspan="3"></th>
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
            <tr>
                <td>Nilai</td>
                <?php foreach ($fuzzy->get_nilai() as $k => $v) : ?>
                    <?php foreach ($v as $a => $b) : ?>
                        <td><?= round($b, 3) ?></td>
                    <?php endforeach ?>
                <?php endforeach ?>
            </tr>
        </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">Aturan</div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Aturan</th>
                <th>miu</th>
                <th>z</th>
            </tr>
        </thead>
        <?php
        $miu = $fuzzy->get_miu();
        $z = $fuzzy->get_z();
        foreach ($fuzzy->get_rules() as $k => $v) : if (!$miu[$k]) continue ?>
            <tr>
                <td><?= $k ?></td>
                <td><?= $v->to_string() ?></td>
                <td><?= round($miu[$k], 3) ?></td>
                <td class="nw">
                    <?php
                    $arr_z = array();
                    foreach ($z[$k] as $b) {
                        $arr_z[] = round($b, 2);
                    }
                    ?>
                    [ <?= implode(', ', $arr_z) ?> ]</td>
            </tr>
        <?php endforeach ?>
    </table>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Hasil</h3>
    </div>
    <div class="panel-body">
        <p>Berdasarkan perhitungan, totalnya adalah <b><?= round($fuzzy->get_total(), 2) ?> (<?= $fuzzy->get_klasifikasi($fuzzy->get_total()) ?>)</b></p>
    </div>
</div>