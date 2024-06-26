<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Dashboard extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('pesanan_model');
		$this->load->model('cabang_model');
	}
	public function index() {
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/dashboard';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->data['pendapatan_kotor'] = $this->pesanan_model->getPendapatan();
		$total = array_reduce($this->data['pendapatan_kotor'], function($carry, $item) {
			return $carry + $item->total;
		}, 0);
		$total_kotor = $total;
		$this->data['pendapatan_kotor'] = "Rp. ".number_format($total);

		$this->data['pendapatan_bersih'] = $this->pesanan_model->getPendapatanBersih();
		$total = array_reduce($this->data['pendapatan_bersih'], function($carry, $item) {
			return $carry + $item->total;
		}, 0);
		$total_bersih = $total;
		$total = $total_kotor - $total_bersih;
		$this->data['pendapatan_bersih'] = "Rp. ".number_format($total);

		$this->data['cabangs'] = $this->cabang_model->getAllById();

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function get_pendapatan_kotor_bersih(){
		$where = array();
		if($this->input->post('cabang_id') != 'all'){
			$where = array('motor.cabang_id' => $this->input->post('cabang_id'));
		}

		$this->data['pendapatan_kotor'] = $this->pesanan_model->getPendapatan($where);
		$total = array_reduce($this->data['pendapatan_kotor'], function($carry, $item) {
			return $carry + $item->total;
		}, 0);
		$total_kotor = $total;
		$this->data['pendapatan_kotor'] = "Rp. ".number_format($total);

		$this->data['pendapatan_bersih'] = $this->pesanan_model->getPendapatanBersih($where);
		$total = array_reduce($this->data['pendapatan_bersih'], function($carry, $item) {
			return $carry + $item->total;
		}, 0);
		$total_bersih = $total;
		$total = $total_kotor - $total_bersih;
		$this->data['pendapatan_bersih'] = "Rp. ".number_format($total);

		print_r(json_encode($this->data));
	}

	public function grafikPendapatan() {

		$currentYear = date('Y'); // Get the current year in the format 'YYYY'

		// Initialize an array to store monthly data
		$monthlyData = [];

		$cabang_id = 0;

		if($this->input->post()){
			$cabang_id = $this->input->post('cabang_id');
		}

		// Loop through each month (from January to December)
		for ($month = 1; $month <= 12; $month++) {
			// Calculate total income for the current month and year
			if($this->input->post() && $cabang_id != 'all'){
				$totalPendapatanQuery = $this->db->query("
					SELECT SUM(po.jumlah * pr.harga_modal) AS total_bersih, SUM(po.jumlah * po.harga_terjual) as total_jual
					FROM pesanan po
					JOIN motor pr ON po.id_produk = pr.id
					JOIN transaksi t ON po.id_transaksi = t.id
					WHERE t.status = 1
					AND po.is_deleted = 0
					AND pr.cabang_id = $cabang_id
					AND MONTH(t.created_at) = $month
					AND YEAR(t.created_at) = $currentYear
				");
			}else{
				$totalPendapatanQuery = $this->db->query("
					SELECT SUM(po.jumlah * pr.harga_modal) AS total_bersih, SUM(po.jumlah * po.harga_terjual) as total_jual
					FROM pesanan po
					JOIN motor pr ON po.id_produk = pr.id
					JOIN transaksi t ON po.id_transaksi = t.id
					WHERE t.status = 1
					AND po.is_deleted = 0
					AND MONTH(t.created_at) = $month
					AND YEAR(t.created_at) = $currentYear
				");
			}

			$totalPendapatanResult = $totalPendapatanQuery->row();
			if($totalPendapatanResult){
				$totalPendapatan = $totalPendapatanResult->total_jual - $totalPendapatanResult->total_bersih;
			}else{
				$totalPendapatan = 0;
			}

			$monthlyData[$month] = [
				'total_pendapatan' => $totalPendapatan,
			];

		}

		if (!empty($monthlyData)) {
			// $return_data['data'] = $datas;
			$return_data['tahun'] = $currentYear;
			$return_data['grafik'] = $monthlyData;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		} else {
			$return_data['data'] = [];
			$return_data['grafik'] = [];
			$return_data['status'] = false;
			$return_data['message'] = "Gagal mengambil data!";
		}

		echo json_encode($return_data);
	}

	public function grafikPendapatanPerTahun() {
		// Get the current year in the format 'YYYY'
		$currentYear = date('Y');

		// Initialize an array to store yearly data
		$yearlyData = [];

		$cabang_id = 0;

		if($this->input->post()){
			$cabang_id = $this->input->post('cabang_id');
		}

		// Loop through each year (you can adjust the range as needed)
		for ($year = $currentYear - 3; $year <= $currentYear; $year++) {
			// Calculate total income for the current year
			if($this->input->post() && $cabang_id != 'all'){
				$totalPendapatanQuery = $this->db->query("
					SELECT SUM(po.jumlah * pr.harga_modal) AS total_bersih, SUM(po.jumlah * po.harga_terjual) as total_jual
					FROM pesanan po
					JOIN motor pr ON po.id_produk = pr.id
					JOIN transaksi t ON po.id_transaksi = t.id
					WHERE t.status = 1
					AND pr.cabang_id = $cabang_id
					AND po.is_deleted = 0
					AND YEAR(t.created_at) = $year
				");
			}else{
				$totalPendapatanQuery = $this->db->query("
					SELECT SUM(po.jumlah * pr.harga_modal) AS total_bersih, SUM(po.jumlah * po.harga_terjual) as total_jual
					FROM pesanan po
					JOIN motor pr ON po.id_produk = pr.id
					JOIN transaksi t ON po.id_transaksi = t.id
					WHERE t.status = 1
					AND po.is_deleted = 0
					AND YEAR(t.created_at) = $year
				");
			}


			$totalPendapatanResult = $totalPendapatanQuery->row();
			if($totalPendapatanResult){
				$totalPendapatan = $totalPendapatanResult->total_jual - $totalPendapatanResult->total_bersih;
			}else{
				$totalPendapatan = 0;
			}

			$yearlyData[$year] = [
				'total_pendapatan' => $totalPendapatan,
			];
		}

		if (!empty($yearlyData)) {
			$return_data['grafik'] = $yearlyData;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		} else {
			$return_data['data'] = [];
			$return_data['grafik'] = [];
			$return_data['status'] = false;
			$return_data['message'] = "Gagal mengambil data!";
		}

		echo json_encode($return_data);
	}

}
