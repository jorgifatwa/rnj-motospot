<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Pesanan</h1>
        <p class="m-0">Transaksi</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Pesanan</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card mb-3">
      <div class="card-header">
          <h3>Keranjang</h3>
      </div>
      <form action="<?php echo base_url('Pesanan/checkout') ?>" method="post">
        <div class="card-body">
          <div class="row">
            <div class="container mt-4 cart-container">
                <table class="table cart-table">
                    <thead>
                        <tr>
                            <th>Motor</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        <!-- Cart items will be displayed here -->
                    </tbody>
                    <tfoot>
                      <tr>
                          <td colspan="2" class="text-right">Subtotal:</td>
                          <td><span id="subtotal">Rp. 0.00</span></td>
                      </tr>
                      <tr>
                          <td colspan="2" class="text-right">Total:</td>
                          <td><span id="total">Rp. 0.00</span></td>
                      </tr>
                  </tfoot>
                </table>
                <div class="text-right mt-3">
                    <button type="submit" id="checkout" class="btn btn-success">Checkout</a>
                    <button id="clear-cart" type="button" class="btn btn-danger">Clear Cart</button>
                </div>
            </div>
          </div>
        </div>    
      </form>
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
                    <th>Plat Nomor</th>
                    <th>Harga Open</th>
                    <th>Harga Nett</th>
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
<script data-main="<?php echo base_url() ?>assets/js/main/main-pesanan" src="<?php echo base_url() ?>assets/js/require.js"></script>