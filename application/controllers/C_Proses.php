<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Proses extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Apps_mod');
		$this->load->model('LoginMod');
	}
	public function GetNormalisasiAwal()
	{

		$data = array('success' => false, 'message' => array(), 'data' => array());


		$SQL = "SELECT * FROM vw_normalisasidata ";

		$rs = $this->db->query($SQL);

		if ($rs->num_rows() > 0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		} else {
			$data['message'] = 'No Record Found';
		}
		echo json_encode($data);
	}
	public function addhasil()
	{
		$data = array('success' => false, 'message' => array());

		$KodeData = $this->input->post('KodeData');
		$Keanggotaan = $this->input->post('Keanggotaan');
		$iterasi = $this->input->post('iterasi');

		// $exploder = explode("|",$ItemGroup[0]);

		$formtype = $this->input->post('formtype');

		$param = array(
			'KodeData' 			=> $KodeData,
			'Keanggotaan'		=> $Keanggotaan,
			'iterasi' 			=> $iterasi
		);

		$call_x = $this->ModelsExecuteMaster->ExecInsert($param, 'thasil');
		if ($call_x) {
			$data['success'] = true;
		}
		echo json_encode($data);
	}

	public function getHasil()
	{
		$kelompok = $this->input->post('kelompok');
		$SQL = "SELECT 
					a.keanggotaan, b.*,
					CASE WHEN a.Keanggotaan = 'C1' THEN 'RENDAH' ELSE CASE WHEN a.Keanggotaan = 'C2' THEN 'SEDANG' ELSE CASE WHEN a.Keanggotaan = 'C3' THEN 'TINGGI' ELSE '' END END END Kelompok
				FROM thasil a
				LEFT JOIN tdata b on a.KodeData = b.id WHERE 1 = 1 ";

		if ($kelompok <> '') {
			$SQL .= " AND a.Keanggotaan = '$kelompok'  ";
		}

		$rs = $this->db->query($SQL);
		$marker = [];
		foreach ($rs->result() as $key) {
			$currentData = array('node' => '', 'lat' => '', 'lng' => '', 'nama' => '', 'NamaAnggota' => '', 'NamaPemilik' => '', 'anggota' => 0, 'Pemasaran' => '');
			$x = explode(',', $key->Koordinat);

			$currentData['Alamat'] = $key->Alamat;
			$currentData['lat'] =  $x[0];
			$currentData['lng'] = $x[1];
			$currentData['nama'] =  $key->Nama;
			$currentData['anggota'] = $key->keanggotaan;
			$currentData['Keterangan'] = $key->Kelompok;
			$currentData['Tahun'] = $key->JenisUsaha;
			array_push($marker, $currentData);
		}
		echo json_encode($marker);
	}
	public function DeleteData()
	{
		$data = array('success' => true, 'message' => array());
		$delete = $this->db->query("truncate table thasil");
	}
}
