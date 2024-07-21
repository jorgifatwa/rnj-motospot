<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Motor Baru</h1>
        <p class="m-0">Motor</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>motor"></i>Motor</a></li>
          <li class="breadcrumb-item active">Motor Baru</li>
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
        <div class="card mb-2">
            <form id="form" method="post" enctype="multipart/form-data">
                <div class="card-body">
                <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Nama Kendaraan</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="nama_motor" name="nama_motor" autocomplete="off" placeholder="Nama Kendaraan">
                      </div>
                  </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Pilih Cabang</label>
                        <div class="col-sm-4">
                        <input type="hidden" id="editMode" value="false">
                            <select name="cabang_id" id="cabang_id" class="form-control">
                            <option value="">Pilih Cabang</option>
                                <?php foreach ($cabangs as $key => $cabang) { ?>
                                <option value="<?php echo $cabang->id ?>"><?php echo $cabang->nama ?></option>
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
                                <option value="<?php echo $merk->id ?>"><?php echo $merk->nama ?></option>
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
                                <option value="<?php echo $jenis->id ?>"><?php echo $jenis->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Warna</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="warna" name="warna" autocomplete="off" placeholder="Warna">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Nopol</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="nopol" name="nopol" autocomplete="off" placeholder="Nopol">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Part Ori</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="part_ori" name="part_ori" autocomplete="off" placeholder="Part Ori    ">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">NIK</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="nik" name="nik" autocomplete="off" placeholder="NIK">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Pajak</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="date" id="pajak" name="pajak" autocomplete="off" placeholder="Pajak">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">KM</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="km" name="km" autocomplete="off" placeholder="KM">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Modal Awal</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="modal_awal" name="modal_awal" autocomplete="off" placeholder="Modal Awal">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Biaya Perbaikan</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="biaya_perbaikan" name="biaya_perbaikan" autocomplete="off" placeholder="Biaya Perbaikan">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Modal Akhir</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="modal_akhir" name="modal_akhir" autocomplete="off" placeholder="Modal Akhir">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Harga Open</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="harga_open" name="harga_open" autocomplete="off" placeholder="Harga Open">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Harga Nett</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="harga_net" name="harga_net" autocomplete="off" placeholder="Harga Nett">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Link Instagram</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="link_instagram" name="link_instagram" autocomplete="off" placeholder="Link Instagram">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Status</label>
                      <div class="col-sm-4">
                          <select name="status" id="status" class="form-control">
                            <option value="0">Available</option>
                            <option value="1">On Maintenance</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Keterangan</label>
                      <div class="col-sm-4">
                          <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" cols="30" rows="10"></textarea>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Gambar Motor</label>
                      <div class="col-sm-4">
                          <input type="file" name="gambar" id="gambar">
                          <div class="gambar-motor mt-2">
                            
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