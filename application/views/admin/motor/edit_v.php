<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Ubah Motor</h1>
        <p class="m-0">Motor</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>motor"></i>Motor</a></li>
          <li class="breadcrumb-item active">Ubah Motor</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<style>
    .image_container {
        height: 120px;
        width: 200px;
        border-radius: 6px;
        overflow: hidden;
    }
    .image_container img {
        height: 100%;
        width: auto;
        object-fit: cover;
    }
    .image_container span {
        top: -8px;
        right: 8px;
        color:red;
        font-size: 28px;
        font-weight: normal;
        cursor: pointer;
    }
</style>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form" method="post" enctype="multipart/form-data">
                <div class="card-body">
                <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Nama Kendaraan</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="nama_motor" name="nama_motor" autocomplete="off" placeholder="Nama Kendaraan" value="<?= $nama_motor ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Pilih Cabang</label>
                      <div class="col-sm-4">
                        <input type="hidden" id="editMode" value="true">
                          <select name="cabang_id" id="cabang_id" class="form-control">
                          <option value="">Pilih Cabang</option>
                              <?php foreach ($cabangs as $key => $cabang) { ?>
                              <option value="<?php echo $cabang->id ?>" <?php if($cabang_id == $cabang->id){ echo "selected"; } ?>><?php echo $cabang->nama ?></option>
                              <?php } ?>
                          </select>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Pilih Merk</label>
                      <div class="col-sm-4">
                          <select name="merk_id" id="merk_id" class="form-control">
                          <option value="">Pilih Merk</option>
                          <?php foreach ($merks as $key => $merk) { ?>
                              <option value="<?php echo $merk->id ?>" <?php if($merk_id == $merk->id){ echo "selected"; } ?>><?php echo $merk->nama ?></option>
                          <?php } ?>
                          </select>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Pilih Jenis</label>
                      <div class="col-sm-4">
                          <select name="jenis_id" id="jenis_id" class="form-control">
                          <option value="">Pilih Jenis</option>
                              <?php foreach ($jeniss as $key => $jenis) { ?>
                              <option value="<?php echo $jenis->id ?>" <?php if($jenis_id == $jenis->id){ echo "selected"; } ?>><?php echo $jenis->nama ?></option>
                              <?php } ?>
                          </select>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Warna</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="warna" name="warna" autocomplete="off" placeholder="Warna" value="<?= $warna ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Nopol</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="nopol" name="nopol" autocomplete="off" placeholder="Nopol" value="<?= $nopol ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Part Ori</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="part_ori" name="part_ori" autocomplete="off" placeholder="Part Ori" value="<?= $part_ori ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">NIK</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="hidden" id="id" name="id" autocomplete="off" placeholder="id" value="<?php echo $id ?>">
                          <input class="form-control" type="text" id="nik" name="nik" autocomplete="off" placeholder="NIK" value="<?php echo $nik ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Pajak</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="date" id="pajak" name="pajak" autocomplete="off" placeholder="Pajak" value="<?php echo $pajak ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">KM</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="km" name="km" autocomplete="off" placeholder="KM" value="<?php echo $km ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Modal Awal</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="modal_awal" name="modal_awal" autocomplete="off" placeholder="Modal Awal" value="<?php echo $harga_modal ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Biaya Perbaikan</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="biaya_perbaikan" name="biaya_perbaikan" autocomplete="off" placeholder="Biaya Perbaikan" value="<?php echo $biaya_perbaikan ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Modal Akhir</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="modal_akhir" name="modal_akhir" autocomplete="off" placeholder="Modal Akhir" value="<?php echo $modal_akhir ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Harga Open</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="harga_open" name="harga_open" autocomplete="off" placeholder="Harga Open" value="<?php echo $harga_open ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Harga Nett</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="harga_net" name="harga_net" autocomplete="off" placeholder="Harga Nett" value="<?php echo $harga_net ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Link Instagram</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="link_instagram" name="link_instagram" autocomplete="off" placeholder="Link Instagram" value="<?= $link_instagram ?>">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Status</label>
                      <div class="col-sm-4">
                          <select name="status" id="status" class="form-control">
                            <option value="0" <?php if($status == 0){ echo "selected"; } ?>>Available</option>
                            <option value="1" <?php if($status == 1){ echo "selected"; } ?>>On Maintenance</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Keterangan</label>
                      <div class="col-sm-4">
                          <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" cols="30" rows="10"><?php echo $keterangan ?></textarea>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Gambar Motor</label>
                      <div class="col-sm-4">
                          <input type="file" name="gambar" id="gambar">
                          <div class="gambar-motor mt-2">
                            <?php if(!empty($galeris)){ ?>
                                <?php foreach ($galeris as $key => $galeri) { ?>
                                    <?php if($galeri->main == 1){ ?>
                                        <div class="image_container d-flex justify-content-center position-relative">
                                            <img src="<?= base_url('uploads/motor/'.$galeri->gambar) ?>" alt="image">
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                          </div>
                      </div>
                  </div>
                  <hr>
                    <div class="card shadow-sm w-100 mt-2">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Detail Gambar</h4>
                            <input type="file" name="image[]" id="image" multiple="" class="d-none">
                            <button class="btn btn-sm btn-primary" onclick="document.getElementById('image').click()" type="button">Pilih Gambar</button>
                        </div>
                        <div class="card-body d-flex flex-wrap justify-content-start image-container">
                            <?php if(!empty($galeris)){ $i = 0;?>
                                <?php foreach ($galeris as $key => $galeri) { ?>
                                    <?php if($galeri->main == 0){ ?>
                                        <div class="image_container d-flex justify-content-center position-relative">
                                            <img src="<?= base_url('uploads/motor/'.$galeri->gambar)?>" alt="image">
                                            <span class="position-absolute delete-image-update" data-id="<?= $galeri->id ?>" data-index="<?= $i ?>" data-form="update">&times;</span>
                                        </div>
                                    <?php $i++;} ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="deleted-images d-none">

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
