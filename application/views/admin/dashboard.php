<section class="content-header">
  <div class="container-fluid">
	<div class="row mb-2">
	  <div class="col-sm-6">
		<h1 class="m-0">Dashboard</h1>
		<p class="m-0">Rekap Data RNJ Motospot</p>
	  </div><!-- /.col -->
	  <div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
		  <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"></i>Dashboard</a></li>
		  <!-- <li class="breadcrumb-item active">Unit Baru</li> -->
		</ol>
	  </div><!-- /.col -->
	</div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content for-dashboard">
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<label for="">Pilih Cabang</label>
				<select name="cabang_id" class="form-control" id="cabang_id">
					<option value="">Pilih Cabang</option>
					<?php foreach ($cabangs as $key => $cabang) { ?>
						<option value="<?php echo $cabang->id ?>"><?php echo $cabang->nama ?></option>
					<?php } ?>
					<option value="all">Semua Cabang</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 col-6">
			<div class="small-box bg-success">
			  <div class="inner">
				<h3 id="pendapatan_bersih"><?php echo $pendapatan_bersih; ?></h3>
				<p>Profit Bersih Bulan Ini</p>
			  </div>
			  <div class="icon">
				<i class="fa fa-coins "></i>
			  </div>
			  <p class="small-box-footer">
				<br>
			  </p>
			</div>
		</div>
		<div class="col-lg-6 col-6">
			<div class="small-box bg-primary">
			  <div class="inner">
				<h3 id="pendapatan_kotor"><?php echo $pendapatan_kotor; ?></h3>
				<p>Omset Bulan Ini</p>
			  </div>
			  <div class="icon">
				<i class="fa fa-coins "></i>
			  </div>
			  <p class="small-box-footer">
				<br>
			  </p>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<h4>Grafik Pendapatan Bersih Per Bulan</h4>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="graph-section" id="container-grafik-pendapatan-bersih-per-bulan">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<h4>Grafik Pendapatan Per Tahun</h4>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="graph-section" id="container-grafik-pendapatan-pertahun">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-dashboard" src="<?php echo base_url() ?>assets/js/require.js"></script>