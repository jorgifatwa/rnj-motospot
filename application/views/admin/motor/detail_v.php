<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Detail Motor</h1>
        <p class="m-0">Motor</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>motor"></i>Motor</a></li>
          <li class="breadcrumb-item active">Detail Motor</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Cabang</label>
                                <div class="col-sm-9">
                                    <p><?= $cabang_name ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Merk</label>
                                <div class="col-sm-9">
                                    <p><?= $merk_name ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Jenis</label>
                                <div class="col-sm-9">
                                    <p><?= $jenis_name ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Warna</label>
                                <div class="col-sm-9">
                                    <p><?= $warna ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Nopol</label>
                                <div class="col-sm-9">
                                    <p><?= $nopol ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Part Ori</label>
                                <div class="col-sm-9">
                                    <p><?= $part_ori ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">NIK</label>
                                <div class="col-sm-9">
                                    <p><?= $nik ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Pajak</label>
                                <div class="col-sm-9">
                                    <p><?= $pajak ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">KM</label>
                                <div class="col-sm-9">
                                    <p><?= $km ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Modal Awal</label>
                                <div class="col-sm-9">
                                    <p><?= $harga_modal ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Biaya Perbaikan</label>
                                <div class="col-sm-9">
                                    <p><?= $biaya_perbaikan ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Modal Akhir</label>
                                <div class="col-sm-9">
                                    <p><?= $modal_akhir ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Harga Open</label>
                                <div class="col-sm-9">
                                    <p><?= $harga_open ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Harga Nett</label>
                                <div class="col-sm-9">
                                    <p><?= $harga_net ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Link Instagram</label>
                                <div class="col-sm-9">
                                    <p><?= $link_instagram ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Status</label>
                                <div class="col-sm-9">
                                    <p><?= ($status == 0) ? 'Aktif' : 'Tidak Aktif' ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-3">Keterangan</label>
                                <div class="col-sm-9">
                                    <p><?= $keterangan ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row gallery">
                                <?php foreach($galeris as $galeri): ?>
                                    <div class="col-md-4 mb-3">
                                        <img src="<?= base_url('uploads/motor/' . $galeri->gambar) ?>" alt="Image" class="img-fluid">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>motor" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-motor" src="<?php echo base_url() ?>assets/js/require.js"></script>


</section>
