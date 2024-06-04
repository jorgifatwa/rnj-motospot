<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Motor</h1>
        <p class="m-0">Mater Data</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Motor</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row mb-4">
        <div class="col-sm-12 text-right">
            <?php if ($is_can_create) {?>
                <a href="<?php echo base_url() ?>motor/create" class="btn btn-primary"><i class="fa fa-plus"></i> Motor</a>
            <?php }?>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h3>Filter</h3>
              <div class="row">
                <div class="col-sm-4">
                  <label for="">Cabang</label>
                  <select name="cabang_id" id="cabang_id" class="form-control">
                    <option value="">Pilih Cabang</option>
                      <?php foreach ($cabangs as $key => $cabang) { ?>
                        <option value="<?php echo $cabang->id ?>"><?php echo $cabang->nama ?></option>
                      <?php } ?>
                  </select>
                </div>
                <div class="col-sm-4">
                  <label for="">Merk</label>
                  <select name="merk_id" id="merk_id" class="form-control">
                    <option value="">Pilih Merk</option>
                    <?php foreach ($merks as $key => $merk) { ?>
                        <option value="<?php echo $merk->id ?>"><?php echo $merk->nama ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-4">
                  <label for="">Pilih Jenis</label>
                  <select name="jenis_id" id="jenis_id" class="form-control">
                    <option value="">Pilih Jenis</option>
                      <?php foreach ($jeniss as $key => $jenis) { ?>
                      <option value="<?php echo $jenis->id ?>"><?php echo $jenis->nama ?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>
              <?php if($this->data['users']->id == 1){ ?>
              <div class="row mt-4">
                <div class="col-sm-4">
                  <label for="">Tanggal Publish Mulai</label>
                  <input type="date" class="form-control" name="tanggal_publish_mulai" id="tanggal_publish_mulai">
                </div>
                <div class="col-sm-4">
                  <label for="">Tanggal Publish Akhir</label>
                  <input type="date" class="form-control" name="tanggal_publish_akhir" id="tanggal_publish_akhir">
                </div>
                <div class="col-sm-4">
                  <label for="">Range Harga Open</label>
                  <div class="row">
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="dari_harga" name="dari_harga" placeholder="Dari Harga">
                    </div>
                    <div class="col-sm-2 text-center">
                      -
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="sampai_harga" name="sampai_harga" placeholder="Sampai Harga">
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="row mt-4">
                <div class="col-sm-4">
                  <label for="">NIK</label>
                  <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK">
                </div>
              </div>
              <div class="row col-md-12 mt-3 mr-0">
                <div class="col-md-12">
                  <button id="btn-cari" style="margin-right: -23px !important" class="btn float-right col-md-1 btn-lg btn-primary">Cari</button>
                  <button id="btn-reset" class="btn mr-2 float-right col-md-1 btn-lg btn-danger">Reset</button>
                </div>
              </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal Publish</th>
                            <th>Merk</th>
                            <th>Jenis</th>
                            <th>NIK</th>
                            <th>KM</th>
                            <th>Pajak</th>
                            <th>Cabang</th>
                            <th>Harga Modal</th>
                            <th>Harga Open</th>
                            <th>Harga Nett</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-motor" src="<?php echo base_url() ?>assets/js/require.js"></script>