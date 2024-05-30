<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Jenis extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('jenis_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/jenis/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			
			$data = array(
				'nama' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->data['users']->id
			);


			$insert = $this->jenis_model->insert($data);

			if ($insert) {
				$this->session->set_flashdata('message', "Jenis Baru Berhasil Disimpan");
				redirect("jenis");
			} else {
				$this->session->set_flashdata('message_error', "Jenis Baru Gagal Disimpan");
				redirect("jenis");
			}
		} else {
			$this->data['content'] = 'admin/jenis/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit() 
	{
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			

			$data = array(
				'nama' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'updated_at' => date('Y-m-d H:i:s'),
				'updated_by' => $this->data['users']->id
			);

			$id = $this->input->post('id');

			$update = $this->jenis_model->update($data, array("jenis.id" => $id));

			if ($update) {
				$this->session->set_flashdata('message', "Jenis Berhasil Diubah");
				redirect("jenis", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Jenis Gagal Diubah");
				redirect("jenis", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("jenis/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$jenis = $this->jenis_model->getAllById(array("jenis.id" => $this->data['id']));
				
				$this->data['id'] 	= (!empty($jenis)) ? $jenis[0]->id : "";
				$this->data['nama'] 	= (!empty($jenis)) ? $jenis[0]->nama : "";
				$this->data['description'] = (!empty($jenis)) ? $jenis[0]->description : "";
				$this->data['content'] = 'admin/jenis/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'nama',
			1 => 'description',
			2 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->jenis_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"jenis.nama" => $search_value,
				"jenis.description" => $search_value,
			);
			$totalFiltered = $this->jenis_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->jenis_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "jenis/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "jenis/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'>Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['nama'] = $data->nama;
				$nestedData['description'] = substr(strip_tags($data->description), 0, 50);
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
			$this->load->model("jenis_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->jenis_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Jenis Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	
}
