<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Booking extends Admin_Controller 
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
			$this->data['content'] = 'admin/booking/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
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
		$totalData = $this->transaksi_model->getCountAllByBooking($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"transaksi.created_at" => $search_value,
				"transaksi.nama_pelanggan" => $search_value,
			);
			$totalFiltered = $this->transaksi_model->getCountAllByBooking($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->transaksi_model->getAllByBooking($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$detail_url = "";
				$terjual_url = "";
				$cancel_url = "";

				if ($data->is_deleted == 0) {
					$detail_url = "<a href='" . base_url() . "booking/detail/" . $data->id . "' class='btn btn-sm btn-info white'>Detail</a>";
				}

				if ($this->data['is_can_edit']) {
					$terjual_url = "<a href='#'
						url='" . base_url() . "booking/update_status/" . $data->id . "/" . 1 . "'
						class='btn btn-sm btn-success white update'>Terjual
						</a>";
					$cancel_url = "<a href='#'
						url='" . base_url() . "booking/update_status/" . $data->id . "/" . 3 . "'
						class='btn btn-sm btn-danger white update'>Cancel
						</a>";
				}

				$statusClass = $data->status == 1 ? 'success' : ($data->status == 2 ? 'warning' : 'danger');
				$statusText = $data->status == 1 ? 'Terjual' : ($data->status == 2 ? 'Booking' : 'Cancel');
				
				$nestedData['id'] = $start + $key + 1;
				$nestedData['tanggal_terjual'] = $data->created_at;
				$nestedData['status'] = '<span style="font-size: 1.5em;color: white !important;" class="badge bg-' . $statusClass . '">' . $statusText . '</span>';
				$nestedData['nama_pelanggan'] = $data->nama_pelanggan;
				$nestedData['keterangan'] = substr(strip_tags($data->keterangan), 0, 50);
				$nestedData['action'] = $detail_url." ".$terjual_url." ".$cancel_url;
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

	public function detail() 
	{
		if (!empty($_POST)) {
			$id = $this->input->post('id');
			$this->session->set_flashdata('message_error', validation_errors());
			return redirect("transaksi/edit/" . $id);
		} else {
			$this->data['id'] = $this->uri->segment(3);
			$transaksi = $this->transaksi_model->getAllById(array("transaksi.id" => $this->data['id']));
			$this->data['pesanans'] = $this->pesanan_model->getAllById(array("id_transaksi" => $this->data['id']));
			$this->data['id'] 	= (!empty($transaksi)) ? $transaksi[0]->id : "";
			$this->data['tanggal_terjual'] 	= (!empty($transaksi)) ? $transaksi[0]->created_at : "";
			$this->data['status'] 	= (!empty($transaksi)) ? $transaksi[0]->status : "";
			$this->data['nama_pelanggan'] 	= (!empty($transaksi)) ? $transaksi[0]->nama_pelanggan : "";
			$this->data['keterangan'] 	= (!empty($transaksi)) ? $transaksi[0]->keterangan : "";

			if(!empty($transaksi)){
				$this->data['status_terjual'] =  $transaksi[0]->status == 1 ? 'Terjual' : ($transaksi[0]->status == 2 ? 'Booking' : 'Cancel');
			}

			$this->data['content'] = 'admin/transaksi/detail_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function update_status() 
	{
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$status = $this->uri->segment(4);
		if (!empty($id)) {
			$this->load->model("transaksi_model");
			$data = array(
				'status' => $status,
			);
			$update = $this->transaksi_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "transaksi Berhasil di Ubah";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	
}
