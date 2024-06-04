<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class History_transaksi extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('transaksi_model');
		$this->load->model('pesanan_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/transaksi/list_v';
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


			$insert = $this->transaksi_model->insert($data);

			if ($insert) {
				$this->session->set_flashdata('message', "transaksi Baru Berhasil Disimpan");
				redirect("transaksi");
			} else {
				$this->session->set_flashdata('message_error', "transaksi Baru Gagal Disimpan");
				redirect("transaksi");
			}
		} else {
			$this->data['content'] = 'admin/transaksi/create_v';
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

			$update = $this->transaksi_model->update($data, array("transaksi.id" => $id));

			if ($update) {
				$this->session->set_flashdata('message', "transaksi Berhasil Diubah");
				redirect("transaksi", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "transaksi Gagal Diubah");
				redirect("transaksi", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("transaksi/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$transaksi = $this->transaksi_model->getAllById(array("transaksi.id" => $this->data['id']));
				
				$this->data['id'] 	= (!empty($transaksi)) ? $transaksi[0]->id : "";
				$this->data['nama'] 	= (!empty($transaksi)) ? $transaksi[0]->nama : "";
				$this->data['description'] = (!empty($transaksi)) ? $transaksi[0]->description : "";
				$this->data['content'] = 'admin/transaksi/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'created_at',
			1 => 'nama_pelanggan',
			2 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->transaksi_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"transaksi.created_at" => $search_value,
				"transaksi.nama_pelanggan" => $search_value,
			);
			$totalFiltered = $this->transaksi_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->transaksi_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$detail_url = "";
				$delete_url = "";

				if ($data->is_deleted == 0) {
					$detail_url = "<a href='" . base_url() . "transaksi/detail/" . $data->id . "' class='btn btn-sm btn-info white'>Detail</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "history_transaksi/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'>Hapus
						</a>";
				}

				$statusClass = $data->status == 1 ? 'success' : ($data->status == 2 ? 'warning' : 'danger');
				$statusText = $data->status == 1 ? 'Terjual' : ($data->status == 2 ? 'Booking' : 'Cancel');
				
				$nestedData['id'] = $start + $key + 1;
				$nestedData['tanggal_terjual'] = $data->created_at;
				$nestedData['status'] = '<span style="font-size: 1.5em; color: white !important;" class="badge bg-' . $statusClass . '">' . $statusText . '</span>';
				$nestedData['nama_pelanggan'] = $data->nama_pelanggan;
				$nestedData['keterangan'] = substr(strip_tags($data->keterangan), 0, 50);
				$nestedData['action'] = $detail_url." ".$delete_url;
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
			$this->load->model("transaksi_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);

			$update = $this->transaksi_model->update($data, array("id" => $id));
			$update = $this->pesanan_model->update($data, array("id_transaksi" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "transaksi Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	
}
