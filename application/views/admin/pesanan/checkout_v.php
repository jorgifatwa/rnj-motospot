<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Checkout</h1>
        <p class="m-0">Pesanan</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>pesanan"></i>Pesanan</a></li>
          <li class="breadcrumb-item active">Checkout</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form_checkout" action="<?php echo base_url('Pesanan/create_pesanan') ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                      <label for="" class="form-label col-sm-3">Nama Pelanggan</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="form-label col-sm-3" for="">Metode Pembayaran</label>
                      <div class="form-check form-inline col-sm-9">
                        <div class="form-check mr-3">
                          <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_pembayaran" value="cash">
                          <label class="form-check-label" for="metode_pembayaran">
                              Cash
                          </label>
                        </div>
                        <div class="form-check mr-3">
                          <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_pembayaran" value="qris">
                          <label class="form-check-label" for="metode_pembayaran">
                              QRIS
                          </label>
                        </div>
                        <div class="form-check mr-3">
                          <input class="form-check-input" type="radio" name="metode_pembayaran" id="metode_pembayaran" value="booking">
                          <label class="form-check-label" for="metode_pembayaran">
                              Booking
                          </label>
                        </div>
                      </div>
                    </div>
                    <p class="error-radio"></p>
                    <div class="form-group row">
                      <label for="" class="form-label col-sm-3">Daftar Motor Yang Dibeli</label>
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Motor</th>
                            <th>Harga Motor</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i=0; $i < count($id_produk); $i++) {  ?>
                          <tr>
                              <input type="hidden" id="id_produk" name="id_produk[$i]" value="<?= $id_produk[$i] ?>">
                              <td><?= $nama[$i] ?></td>
                              <td><input type="text" class="form-control sub_total" id="sub-total-<?= $i ?>" data-index="<?= $i ?>" name="sub_total[]" value="<?= $sub_total[$i] ?>"></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Total Pembayaran</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="total_pembayaran" name="total_pembayaran" value="<?php echo "Rp ".number_format($total) ?>" autocomplete="off" readonly>
                        </div>
                    </div>
                    <?php
                        foreach ($id_produk as $item) {
                          echo '<input type="hidden" name="id_produk[]" value="' . $item . '">';
                        } 
                        foreach ($quantity as $item) {
                          echo '<input type="hidden" name="quantity[]" value="' . $item . '">';
                        }
                      ?>
                    <div class="non_tunai d-none">
                      <div class="form-group row">
                          <label class="form-label col-sm-3" for="">QRIS</label>
                          <div class="col-sm-9">
                              <img width="200" src="<?php echo base_url('assets/images/qris.png') ?>" alt="">
                          </div>
                      </div>
                    </div>
                    <div class="tunai d-none">
                      <div class="form-group row">
                          <label class="form-label col-sm-3" for="">Jumlah Uang</label>
                          <div class="col-sm-9">
                              <input class="form-control" type="text" id="jumlah_uang" name="jumlah_uang" placeholder="Jumlah Uang" autocomplete="off">
                              <p class="text-danger error-jumlah d-none">Jumlah Uang Tidak Bisa Kurang dari Total Pembayaran</p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="form-label col-sm-3" for="">Kembalian</label>
                          <div class="col-sm-9">
                              <input class="form-control" type="text" id="kembalian" name="kembalian" autocomplete="off" value="Rp. 0" readonly>
                          </div>
                      </div>
                    </div>
                    <div class="form-group status-form row">
                      <label for="" class="form-label col-sm-3">Status</label>
                      <di class="col-sm-9">
                        <select name="status" class="form-control" id="status">
                          <option value="1">Terjual</option>
                          <option value="2">Booking</option>
                        </select>
                      </di>
                    </div>
                    <div class="form-group row">
                        <label class="form-label col-sm-3" for="">Keterangan</label>
                        <div class="col-sm-9">
                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
                        </div>
                    </div>
                    <hr class="border-bottom border-3">
                    <div class="row justify-content-center">
                        <div class="text-center col-md-6">
                          <img width="200" class="mt-3 mx-auto" src="<?php echo base_url() ?>assets/images/logo-rnj.png" alt="">
                          <?php
                            // Atur zona waktu
                            date_default_timezone_set('Asia/Jakarta');

                            // Tampilkan hari
                            $hari = date('l');

                            // Tampilkan tanggal
                            $tanggal = date('j F Y');

                            // Tampilkan jam
                            $jam = date('H:i:s');
                          ?>
                          <p><?php echo $hari." ".$tanggal." ".$jam ?></p>
                          <hr class="border-bottom border-3 bg-black">
                          <div class="row justify-content-center">
                            <table>
                              <tr class="border-bottom border-3">
                                <td><b>QTY</b></td>
                                <td><b>ITEM</b></td>
                                <td><b>AMT</b></td>
                              </tr>
                              <?php for ($i=0; $i < count($id_produk); $i++) {  ?>
                                <tr>
                                  <td><?php echo $quantity[$i] ?></td>
                                  <td class="text-left"><?php echo $nama[$i] ?></td>
                                  <td class="sub_total_struk" id="sub_total_struk_<?= $i ?>"><?php echo "Rp ".number_format($sub_total[$i]) ?></td>
                                </tr>
                              <?php } ?>
                              <tr class="border-top border-3">
                                <td colspan="2" class="text-left"><h4>Total</h4></td>
                                <td class="total_struk"><?php echo "Rp ".number_format($total) ?></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>pesanan" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-pesanan" src="<?php echo base_url() ?>assets/js/require.js"></script>