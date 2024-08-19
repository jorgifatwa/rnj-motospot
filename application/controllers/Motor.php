<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Motor extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('motor_model');
		$this->load->model('cabang_model');
		$this->load->model('jenis_model');
		$this->load->model('merk_model');
		$this->load->model('galeri_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/motor/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->data['cabangs'] = $this->cabang_model->getAllById();
		$this->data['jeniss'] = $this->jenis_model->getAllById();
		$this->data['merks'] = $this->merk_model->getAllById();

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('merk_id', "Merk Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('cabang_id', "Cabang Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('jenis_id', "Jenis Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('warna', "Warna Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nopol', "Nopol Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('part_ori', "Part Ori Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nik', "NIK Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('pajak', "Pajak Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('km', "KM Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('modal_awal', "Modal Awal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('biaya_perbaikan', "Biaya Perbaikan Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('modal_akhir', "Modal Akhir Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga_open', "Harga Open Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga_net', "Harga Nett Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('link_instagram', "Link Instagram Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nama_motor', "Nama Motor Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			
			$data = array(
				'nama_motor' => $this->input->post('nama_motor'),
				'merk_id' => $this->input->post('merk_id'),
				'cabang_id' => $this->input->post('cabang_id'),
				'jenis_id' => $this->input->post('jenis_id'),
				'nik' => $this->input->post('nik'),
				'warna' => $this->input->post('warna'),
				'nopol' => $this->input->post('nopol'),
				'part_ori' => $this->input->post('part_ori'),
				'link_instagram' => $this->input->post('link_instagram'),
				'pajak' => $this->input->post('pajak'),
				'km' => str_replace(".", "", $this->input->post('km')),
				'harga_open' => str_replace(".", "", $this->input->post('harga_open')),
				'harga_modal' => str_replace(".", "", $this->input->post('modal_awal')),
				'biaya_perbaikan' => str_replace(".", "", $this->input->post('biaya_perbaikan')),
				'modal_akhir' => str_replace(".", "", $this->input->post('modal_akhir')),
				'harga_net' => str_replace(".", "", $this->input->post('harga_net')),
				'status' => $this->input->post('status'),
				'keterangan' => $this->input->post('keterangan'),
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->data['users']->id
			);

			$insert = $this->motor_model->insert($data);

			$location_path = "./uploads/motor/";
			if(!is_dir($location_path))
			{
				mkdir($location_path);
			}

			$tmp = $_FILES["gambar"]['name'];
			$ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
			$uploaded      = uploadFile('gambar', $location_path, 'gambar', $ext);
			
			if($uploaded['status']==TRUE){
				$data['gambar'] = str_replace(' ', '_', $uploaded['message']);	
				$data_gambar = array(
					'produk_id' => $insert,
					'gambar' =>  $uploaded['message'],
					'main' => 1,
					'created_at' => date('Y-m-d H:i:s'),
					'created_by' => $this->data['users']->id
				);

				$insert_gambar = $this->galeri_model->insert($data_gambar);
			}

			$uploaded = uploadFileArray('image', $location_path, 'motor', $ext);
			
			if($uploaded){
				for ($i = 0; $i < count($_FILES["image"]['name']); $i++) { 
					$data_galeri = array(
						'produk_id' => $insert,
						'gambar' => $uploaded[$i]['file'],  // Use uploaded file name
						'main' => 0,
						'created_at' => date('Y-m-d H:i:s'),
						'created_by' => $this->data['users']->id
					);
				
					$insert_galeri = $this->galeri_model->insert($data_galeri);
				}   
			}

			if ($insert && $insert_galeri) {
				$this->session->set_flashdata('message', "Motor Baru Berhasil Disimpan");
				redirect("motor");
			} else {
				$this->session->set_flashdata('message_error', "Motor Baru Gagal Disimpan");
				redirect("motor");
			}
		} else {
			$this->data['cabangs'] = $this->cabang_model->getAllById();
			$this->data['jeniss'] = $this->jenis_model->getAllById();
			$this->data['merks'] = $this->merk_model->getAllById();
			$this->data['content'] = 'admin/motor/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit() 
	{
		$this->form_validation->set_rules('merk_id', "Merk Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('cabang_id', "Cabang Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('jenis_id', "Jenis Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('warna', "Warna Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nopol', "Nopol Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('part_ori', "Part Ori Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nik', "NIK Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('pajak', "Pajak Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('km', "KM Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('modal_awal', "Modal Awal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('biaya_perbaikan', "Biaya Perbaikan Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('modal_akhir', "Modal Akhir Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga_open', "Harga Open Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga_net', "Harga Nett Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('link_instagram', "Link Instagram Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nama_motor', "Nama Motor Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			
			$data = array(
				'nama_motor' => $this->input->post('nama_motor'),
				'merk_id' => $this->input->post('merk_id'),
				'cabang_id' => $this->input->post('cabang_id'),
				'jenis_id' => $this->input->post('jenis_id'),
				'nik' => $this->input->post('nik'),
				'warna' => $this->input->post('warna'),
				'nopol' => $this->input->post('nopol'),
				'part_ori' => $this->input->post('part_ori'),
				'link_instagram' => $this->input->post('link_instagram'),
				'pajak' => $this->input->post('pajak'),
				'km' => str_replace(".", "", $this->input->post('km')),
				'harga_open' => str_replace(".", "", $this->input->post('harga_open')),
				'harga_modal' => str_replace(".", "", $this->input->post('modal_awal')),
				'biaya_perbaikan' => str_replace(".", "", $this->input->post('biaya_perbaikan')),
				'modal_akhir' => str_replace(".", "", $this->input->post('modal_akhir')),
				'harga_net' => str_replace(".", "", $this->input->post('harga_net')),
				'status' => $this->input->post('status'),
				'keterangan' => $this->input->post('keterangan'),
				'updated_at' => date('Y-m-d H:i:s'),
				'updated_by' => $this->data['users']->id
			);

			$id = $this->input->post('id');

			print_r($id);
			die();

			$update = $this->motor_model->update($data, array("motor.id" => $id));
			
			$deleted_images = $this->input->post('deleted_images');

			if (!empty($deleted_images)) {
				$deleted_images = json_decode($deleted_images);
				for ($i=0; $i < count($deleted_images); $i++) { 
					// Load the current images for the product
					$current_images = $this->galeri_model->getAllById(array('id' => $deleted_images[$i]));

					$location_path = "./uploads/motor/";
					if(!is_dir($location_path))
					{
						mkdir($location_path);
					}

					// Delete old images from server
					if(!empty($current_images)){
						foreach ($current_images as $image) {
							$image_path = $location_path . $image->gambar;
							if (file_exists($image_path)) {
								unlink($image_path);
							}
						}
					}

					$delete_current_images = $this->galeri_model->delete(array('id' => $deleted_images[$i]));
				}
			}else{
				// Load the current images for the product
				$current_images = $this->galeri_model->getAllById(array('produk_id' => $id, 'main' => 1));
				
				$location_path = "./uploads/motor/";
				if(!is_dir($location_path))
				{
					mkdir($location_path);
				}
				
				if(!empty($_FILES['gambar']['name'])){
					// Delete old images from server
					if(!empty($current_images)){
						foreach ($current_images as $image) {
							$image_path = $location_path . $image->gambar;
							if (file_exists($image_path)) {
								unlink($image_path);
							}
						}
					}
		
					$delete_current_images = $this->galeri_model->delete(array('produk_id' => $id, 'main' => 1));
		
					$tmp = $_FILES["gambar"]['name'];
					$ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
					$uploaded      = uploadFile('gambar', $location_path, 'gambar', $ext);
					
					if($uploaded['status']==TRUE){
						$data['gambar'] = str_replace(' ', '_', $uploaded['message']);	
						$data_gambar = array(
							'produk_id' => $id,
							'gambar' =>  $uploaded['message'],
							'main' => 1,
							'created_at' => date('Y-m-d H:i:s'),
							'created_by' => $this->data['users']->id
						);
		
						$insert_gambar = $this->galeri_model->insert($data_gambar);
					}
		
				}
				if(!empty($_FILES["image"]['name'][0])){
					$uploaded = uploadFileArray('image', $location_path, 'motor', $ext);
					if($uploaded){
						$current_images = $this->galeri_model->getAllById(array('produk_id' => $id, 'main' => 0));
						if(!empty($current_images)){
							foreach ($current_images as $image) {
								$image_path = $location_path . $image->gambar;
								if (file_exists($image_path)) {
									unlink($image_path);
								}
							}
						}

						$delete_current_images = $this->galeri_model->delete(array('produk_id' => $id, 'main' => 0));
			
						for ($i = 0; $i < count($_FILES["image"]['name']); $i++) { 
							$data_galeri = array(
								'produk_id' => $id,
								'gambar' => $uploaded[$i]['file'],  // Use uploaded file name
								'main' => 0,
								'created_at' => date('Y-m-d H:i:s'),
								'created_by' => $this->data['users']->id
							);
						
							$insert_galeri = $this->galeri_model->insert($data_galeri);
						}   
					} 
				}
			}



			if ($update) {
				$this->session->set_flashdata('message', "Motor Berhasil Diubah");
				redirect("motor", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Motor Gagal Diubah");
				redirect("motor", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("motor/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$motor = $this->motor_model->getAllById(array("motor.id" => $this->data['id']));

				$this->data['cabangs'] = $this->cabang_model->getAllById();
				$this->data['jeniss'] = $this->jenis_model->getAllById();
				$this->data['merks'] = $this->merk_model->getAllById();
				
				$this->data['id'] 	= (!empty($motor)) ? $motor[0]->id : "";
				$this->data['nama_motor'] 	= (!empty($motor)) ? $motor[0]->nama_motor : "";
				$this->data['merk_id'] 	= (!empty($motor)) ? $motor[0]->merk_id : "";
				$this->data['jenis_id'] 	= (!empty($motor)) ? $motor[0]->jenis_id : "";
				$this->data['cabang_id'] 	= (!empty($motor)) ? $motor[0]->cabang_id : "";
				$this->data['nik'] 	= (!empty($motor)) ? $motor[0]->nik : "";
				$this->data['km'] 	= (!empty($motor)) ? $motor[0]->km : "";
				$this->data['pajak'] 	= (!empty($motor)) ? $motor[0]->pajak : "";
				$this->data['warna'] 	= (!empty($motor)) ? $motor[0]->warna : "";
				$this->data['nopol'] 	= (!empty($motor)) ? $motor[0]->nopol : "";
				$this->data['part_ori'] 	= (!empty($motor)) ? $motor[0]->part_ori : "";
				$this->data['link_instagram'] 	= (!empty($motor)) ? $motor[0]->link_instagram : "";
				$this->data['modal_akhir'] 	= (!empty($motor)) ? $motor[0]->modal_akhir : "";
				$this->data['biaya_perbaikan'] 	= (!empty($motor)) ? $motor[0]->biaya_perbaikan : "";
				$this->data['harga_modal'] 	= (!empty($motor)) ? $motor[0]->harga_modal : "";
				$this->data['harga_open'] 	= (!empty($motor)) ? $motor[0]->harga_open : "";
				$this->data['harga_net'] 	= (!empty($motor)) ? $motor[0]->harga_net : "";
				$this->data['status'] 	= (!empty($motor)) ? $motor[0]->status : "";
				$this->data['keterangan'] = (!empty($motor)) ? $motor[0]->keterangan : "";

				$this->data['galeris'] = $this->galeri_model->getAllById(array('produk_id' => $this->data['id']));
				$this->data['content'] = 'admin/motor/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'created_at',
			1 => 'nama_motor',
			1 => 'merk_name',
			2 => 'jenis_name',
			3 => 'nik',
			4 => 'km',
			5 => 'pajak',
			6 => 'cabang_name',
			7 => 'nopol',
			8 => 'harga_open',
			9 => 'harga_net',
			10 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$totalData = $this->motor_model->getCountAllBy($limit, $start, $search, $order, $dir);

		// Get filter values from POST request
		$tanggal_publish_mulai = $this->input->post('tanggal_publish_mulai');
		$tanggal_publish_akhir = $this->input->post('tanggal_publish_akhir');
		$dari_harga = $this->input->post('dari_harga');
		$sampai_harga = $this->input->post('sampai_harga');
		$cabang_id = $this->input->post('cabang_id');
		$jenis_id = $this->input->post('jenis_id');
		$merk_id = $this->input->post('merk_id');
		$nik = $this->input->post('nik');
		$pesanan = $this->input->post('pesanan');

		$filtered = false;

		// Apply date range filter for 'created_at'
		if (!empty($tanggal_publish_mulai) && !empty($tanggal_publish_akhir)) {
			$tanggal_publish_akhir .= ' 23:59:59';
			$where['motor.created_at >='] = $tanggal_publish_mulai;
			$where['motor.created_at <='] = $tanggal_publish_akhir;
			$filtered = true;
		}

		// Apply price range filter for 'harga_open'
		if (!empty($dari_harga) && !empty($sampai_harga)) {
			$where['motor.harga_open >='] = str_replace(".", "", $dari_harga);
			$where['motor.harga_open <='] = str_replace(".", "", $sampai_harga);
			$filtered = true;
		}

		// Other filters...
		if (!empty($cabang_id)) {
			$where['motor.cabang_id'] = $cabang_id;
			$filtered = true;
		}

		if (!empty($jenis_id)) {
			$where['motor.jenis_id'] = $jenis_id;
			$filtered = true;
		}

		if (!empty($merk_id)) {
			$where['motor.merk_id'] = $merk_id;
			$filtered = true;
		}

		if (!empty($nik)) {
			$where['motor.nik'] = $nik;
			$filtered = true;
		}

		if($pesanan){
			$where['motor.status'] = 0;
			$filtered = true;
		}

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"motor.nama_motor" => $search_value,
				"motor.nopol" => $search_value,
				"merk.nama" => $search_value,
				"jenis.nama" => $search_value,
				"cabang.nama" => $search_value,
				"motor.nik" => $search_value,
			);

			$filtered = true;
		}

		if ($filtered) {
			$totalFiltered = $this->motor_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$datas = $this->motor_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {
			foreach ($datas as $key => $data) {
				$edit_url = "";
				$delete_url = "";
				$detail_url = "";
				$masukkan_keranjang = "";

				if(!$pesanan){
					if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
						$edit_url = "<a href='" . base_url() . "motor/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
					}
					if ($this->data['is_can_delete']) {
						$delete_url = "<a href='#' url='" . base_url() . "motor/destroy/" . $data->id . "/" . $data->is_deleted . "' class='btn btn-sm btn-danger white delete'>Hapus</a>";
					}
					$detail_url = "<a href='" . base_url() . "motor/detail/" . $data->id . "' class='btn btn-sm btn-success white'> Detail</a>";
				}else{
					$masukkan_keranjang = "<button type='button' class='btn btn-sm btn-info white add-to-cart' data-id='".$data->id."' data-jenis='".$data->jenis_name."' data-merk='".$data->merk_name."' data-price='".$data->harga_open."'> Tambah Ke Keranjang</button>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['created_at'] = $data->created_at;
				$nestedData['nama_motor'] = $data->nama_motor;
				$nestedData['pajak'] = $data->pajak;
				$nestedData['merk_name'] = $data->merk_name;
				$nestedData['cabang_name'] = $data->cabang_name;
				$nestedData['jenis_name'] = $data->jenis_name;
				$nestedData['status'] = $data->status == 0 ? 'Available' : 'On Maintenance';
				$nestedData['nik'] = $data->nik;
				$nestedData['km'] = number_format($data->km);
				$nestedData['nopol'] = $data->nopol;
				$nestedData['harga_open'] = "Rp. " . number_format($data->harga_open);
				$nestedData['harga_net'] = "Rp. " . number_format($data->harga_net);
				$nestedData['action'] = $edit_url . " " . $delete_url." ".$masukkan_keranjang." ".$detail_url;

				$new_data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw" => intval($this->input->post('draw')),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data" => $new_data,
		);

		echo json_encode($json_data);
	}

	public function destroy() 
	{
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
		if (!empty($id)) {
			$this->load->model("motor_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->motor_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "motor Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	public function detail() 
	{		
		if (!empty($_POST)) {
			$id = $this->input->post('id');
			$this->session->set_flashdata('message_error', validation_errors());
			return redirect("motor/" . $id);
		} else {
			$this->data['id'] = $this->uri->segment(3);
			$motor = $this->motor_model->getAllById(array("motor.id" => $this->data['id']));

			$this->data['cabangs'] = $this->cabang_model->getAllById();
			$this->data['jeniss'] = $this->jenis_model->getAllById();
			$this->data['merks'] = $this->merk_model->getAllById();
			
			$this->data['id'] 	= (!empty($motor)) ? $motor[0]->id : "";
			$this->data['nama_motor'] 	= (!empty($motor)) ? $motor[0]->nama_motor : "";
			$this->data['merk_id'] 	= (!empty($motor)) ? $motor[0]->merk_id : "";
			$this->data['merk_name'] 	= (!empty($motor)) ? $motor[0]->merk_name : "";
			$this->data['jenis_id'] 	= (!empty($motor)) ? $motor[0]->jenis_id : "";
			$this->data['jenis_name'] 	= (!empty($motor)) ? $motor[0]->jenis_name : "";
			$this->data['cabang_id'] 	= (!empty($motor)) ? $motor[0]->cabang_id : "";
			$this->data['cabang_name'] 	= (!empty($motor)) ? $motor[0]->cabang_name : "";
			$this->data['nik'] 	= (!empty($motor)) ? $motor[0]->nik : "";
			$this->data['km'] 	= (!empty($motor)) ? $motor[0]->km : "";
			$this->data['pajak'] 	= (!empty($motor)) ? $motor[0]->pajak : "";
			$this->data['warna'] 	= (!empty($motor)) ? $motor[0]->warna : "";
			$this->data['nopol'] 	= (!empty($motor)) ? $motor[0]->nopol : "";
			$this->data['part_ori'] 	= (!empty($motor)) ? $motor[0]->part_ori : "";
			$this->data['link_instagram'] 	= (!empty($motor)) ? $motor[0]->link_instagram : "";
			$this->data['modal_akhir'] 	= (!empty($motor)) ? $motor[0]->modal_akhir : "";
			$this->data['biaya_perbaikan'] 	= (!empty($motor)) ? $motor[0]->biaya_perbaikan : "";
			$this->data['harga_modal'] 	= (!empty($motor)) ? $motor[0]->harga_modal : "";
			$this->data['harga_open'] 	= (!empty($motor)) ? $motor[0]->harga_open : "";
			$this->data['harga_net'] 	= (!empty($motor)) ? $motor[0]->harga_net : "";
			$this->data['status'] 	= (!empty($motor)) ? $motor[0]->status : "";
			$this->data['keterangan'] = (!empty($motor)) ? $motor[0]->keterangan : "";

			$this->data['galeris'] = $this->galeri_model->getAllById(array('produk_id' => $this->data['id']));
			$this->data['content'] = 'admin/motor/detail_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}
}
