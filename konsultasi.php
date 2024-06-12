<div class="page-header">
    <h1>Konsultasi</h1>
</div>
<form method="post">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Pilih Atribut</h3>
                </div>
                <div class="panel-body">
                    <?php foreach ($ATRIBUT[0] as $key => $val) : ?>
                        <div class="form-group">
                            <label><?= $val->nama_kriteria ?></label>
                            <input class="form-control" type="text" name="nilai[<?= $key ?>]" value="<?= $_POST['nilai'][$key] ?>">
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary"><span class="glyphicon glyphicon-signal"></span> Hitung</button>
                </div>
            </div>
        </div>
    </div>
    <?php if ($_POST) include 'konsultasi_hasil.php'; ?>
</form>