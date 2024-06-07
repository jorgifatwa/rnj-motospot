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
		$this->form_validation->set_rules('nik', "NIK Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('pajak', "Pajak Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('km', "KM Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga_modal', "Harga Modal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga_open', "Harga Open Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga_net', "Harga Nett Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			
			$data = array(
				'merk_id' => $this->input->post('merk_id'),
				'cabang_id' => $this->input->post('cabang_id'),
				'jenis_id' => $this->input->post('jenis_id'),
				'nik' => $this->input->post('nik'),
				'pajak' => $this->input->post('pajak'),
				'km' => str_replace(".", "", $this->input->post('km')),
				'harga_open' => str_replace(".", "", $this->input->post('harga_open')),
				'harga_modal' => str_replace(".", "", $this->input->post('harga_modal')),
				'harga_net' => str_replace(".", "", $this->input->post('harga_net')),
				'status' => $this->input->post('status'),
				'keterangan' => $this->input->post('keterangan'),
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->data['users']->id
			);

			// $location_path = "./uploads/motor/";
			// if(!is_dir($location_path))
			// {
			// 	mkdir($location_path);
			// }

			// $tmp = $_FILES["gambar"]['name'];
			// $ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
			// $uploaded      = uploadFile('gambar', $location_path, 'motor', $ext);
			
			// if($uploaded['status']==TRUE){
			// 	$data['gambar'] = str_replace(' ', '_', $uploaded['message']);	
			// }

			$insert = $this->motor_model->insert($data);

			if ($insert) {
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
		$this->form_validation->set_rules('nik', "NIK Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('pajak', "Pajak Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('km', "KM Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga_modal', "Harga Modal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga_open', "Harga Open Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga_net', "Harga Nett Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			
			$data = array(
				'merk_id' => $this->input->post('merk_id'),
				'cabang_id' => $this->input->post('cabang_id'),
				'jenis_id' => $this->input->post('jenis_id'),
				'nik' => $this->input->post('nik'),
				'pajak' => $this->input->post('pajak'),
				'km' => str_replace(".", "", $this->input->post('km')),
				'harga_open' => str_replace(".", "", $this->input->post('harga_open')),
				'harga_modal' => str_replace(".", "", $this->input->post('harga_modal')),
				'harga_net' => str_replace(".", "", $this->input->post('harga_net')),
				'status' => $this->input->post('status'),
				'keterangan' => $this->input->post('keterangan'),
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->data['users']->id
			);

			$id = $this->input->post('id');

			// $location_path = "./uploads/motor/";
			// if(!is_dir($location_path))
			// {
			// 	mkdir($location_path);
			// }

			// $tmp = $_FILES["gambar"]['name'];
			// $ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
			// $uploaded      = uploadFile('gambar', $location_path, 'motor', $ext);
			
			// if($uploaded['status']==TRUE){
			// 	$data['gambar'] = str_replace(' ', '_', $uploaded['message']);	
			// }

			$update = $this->motor_model->update($data, array("motor.id" => $id));

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
				$this->data['merk_id'] 	= (!empty($motor)) ? $motor[0]->merk_id : "";
				$this->data['jenis_id'] 	= (!empty($motor)) ? $motor[0]->jenis_id : "";
				$this->data['nik'] 	= (!empty($motor)) ? $motor[0]->nik : "";
				$this->data['km'] 	= (!empty($motor)) ? $motor[0]->km : "";
				$this->data['pajak'] 	= (!empty($motor)) ? $motor[0]->pajak : "";
				$this->data['cabang_id'] 	= (!empty($motor)) ? $motor[0]->cabang_id : "";
				$this->data['harga_modal'] 	= (!empty($motor)) ? $motor[0]->harga_modal : "";
				$this->data['harga_open'] 	= (!empty($motor)) ? $motor[0]->harga_open : "";
				$this->data['harga_net'] 	= (!empty($motor)) ? $motor[0]->harga_net : "";
				$this->data['status'] 	= (!empty($motor)) ? $motor[0]->status : "";
				$this->data['keterangan'] = (!empty($motor)) ? $motor[0]->keterangan : "";
				$this->data['content'] = 'admin/motor/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
{
    $columns = array(
        0 => 'created_at',
        1 => 'merk_name',
        2 => 'jenis_name',
        3 => 'nik',
        4 => 'km',
        5 => 'pajak',
        6 => 'cabang_name',
        7 => 'harga_modal',
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
            $masukkan_keranjang = "";

			if(!$pesanan){
				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "motor/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#' url='" . base_url() . "motor/destroy/" . $data->id . "/" . $data->is_deleted . "' class='btn btn-sm btn-danger white delete'>Hapus</a>";
				}
			}else{
				$masukkan_keranjang = "<button type='button' class='btn btn-sm btn-info white add-to-cart' data-id='".$data->id."' data-jenis='".$data->jenis_name."' data-merk='".$data->merk_name."' data-price='".$data->harga_open."'> Tambah Ke Keranjang</button>";
			}

            $nestedData['id'] = $start + $key + 1;
            $nestedData['created_at'] = $data->created_at;
            $nestedData['pajak'] = $data->pajak;
            $nestedData['merk_name'] = $data->merk_name;
            $nestedData['cabang_name'] = $data->cabang_name;
            $nestedData['jenis_name'] = $data->jenis_name;
            $nestedData['status'] = $data->status == 0 ? 'Aktif' : 'Tidak Aktif';
            $nestedData['nik'] = $data->nik;
            $nestedData['km'] = number_format($data->km);
            $nestedData['harga_modal'] = "Rp. " . number_format($data->harga_modal);
            $nestedData['harga_open'] = "Rp. " . number_format($data->harga_open);
            $nestedData['harga_net'] = "Rp. " . number_format($data->harga_net);
            $nestedData['action'] = $edit_url . " " . $delete_url." ".$masukkan_keranjang;

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

	
}
