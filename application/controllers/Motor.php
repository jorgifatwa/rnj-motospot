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

			$location_path = "./uploads/motor/";
			if(!is_dir($location_path))
			{
				mkdir($location_path);
			}

			$tmp = $_FILES["gambar"]['name'];
			$ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
			$uploaded      = uploadFile('gambar', $location_path, 'motor', $ext);
			
			if($uploaded['status']==TRUE){
				$data['gambar'] = str_replace(' ', '_', $uploaded['message']);	
			}

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
		$limit = 0;
		$start = 0;
		$totalData = $this->motor_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"merk.nama" => $search_value,
				"cabang.nama" => $search_value,
				"jenis.nama" => $search_value,
				"motor.nik" => $search_value,
				"motor.km" => $search_value,
				"motor.pajak" => $search_value,
				"motor.harga_modal" => $search_value,
				"motor.harga_open" => $search_value,
				"motor.harga_net" => $search_value
			);
			$totalFiltered = $this->motor_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->motor_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "motor/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "motor/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'>Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['created_at'] = $data->created_at;
				$nestedData['pajak'] = $data->pajak;
				$nestedData['merk_name'] = $data->merk_name;
				$nestedData['cabang_name'] = $data->cabang_name;
				$nestedData['jenis_name'] = $data->jenis_name;
				$nestedData['nik'] = $data->nik;
				$nestedData['km'] = number_format($data->km);
				$nestedData['harga_modal'] = "Rp. ".number_format($data->harga_modal);
				$nestedData['harga_open'] = "Rp. ".number_format($data->harga_open);
				$nestedData['harga_net'] = "Rp. ".number_format($data->harga_net);
				$nestedData['action'] = $edit_url . " " . $delete_url;
				
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
