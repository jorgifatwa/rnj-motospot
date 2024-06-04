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

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Pilih Cabang</label>
                        <div class="col-sm-4">
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
                      <label class="form-label col-sm-3" for="">Harga Modal</label>
                      <div class="col-sm-4">
                          <input class="form-control" type="text" id="harga_modal" name="harga_modal" autocomplete="off" placeholder="Harga Modal">
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
                      <label class="form-label col-sm-3" for="">Status</label>
                      <div class="col-sm-4">
                          <select name="status" id="status" class="form-control">
                            <option value="0">Aktif</option>
                            <option value="1">Tidak Aktif</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Keterangan</label>
                      <div class="col-sm-4">
                          <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" cols="30" rows="10"></textarea>
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