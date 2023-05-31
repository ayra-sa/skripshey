<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Data extends CI_Controller {

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
	public function Read()
	{
		$data = array('success' => false ,'message'=>array(),'data' => array());

		$id = $this->input->post('id');

		$SQL = "SELECT * FROM tdata ";

		if ($id == '') {
			$rs = $this->db->query($SQL);
		}
		else{
			$rs = $this->ModelsExecuteMaster->FindData(array('id'=>$id),'tdata');
		}

		if ($rs->num_rows()>0) {
			$data['success'] = true;
			$data['data'] = $rs->result();
		}
		else{
			$data['message'] = 'No Record Found';
		}
		echo json_encode($data);
	}
	public function CRUD()
	{
		$data = array('success' => false ,'message'=>array());
		$Nama = $this->input->post('Nama');
		$Alamat = $this->input->post('Alamat');
		$Asset = $this->input->post('Asset');
		$Jmlpekerja = $this->input->post('JmlPekerja');
		$Omset = $this->input->post('Omset');
		$Koordinat = $this->input->post('Koordinat');
		$JenisUsaha = $this->input->post('JenisUsaha');

		// $exploder = explode("|",$ItemGroup[0]);

		$id = $this->input->post('id');

		$formtype = $this->input->post('formtype');

		$param = array(
			'Nama' 			=> $Nama,
			'Alamat'		=> $Alamat,
			'Asset' 	=> $Asset,
			'Jmlpekerja' 	=> $Jmlpekerja,
			'Koordinat' 	=> $Koordinat,
			'Omset'			=> $Omset,
			'JenisUsaha'	=> $JenisUsaha
		);
		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'tdata');
				if ($call_x) {
					$this->db->trans_commit();
					$data['success'] = true;
				}
				else{
					$data['message'] = "Gagal Input Role";
					goto jump;
				}
			} catch (Exception $e) {
				jump:
				$this->db->trans_rollback();
				// $data['success'] = false;
				// $data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		elseif ($formtype == 'edit') {
			try {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('id'=> $id),'tdata');
				if ($rs) {
					$data['success'] = true;
				}
			} catch (Exception $e) {
				$data['success'] = false;
				$data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		elseif ($formtype == 'delete') {
			try {
				$SQL = "DELETE FROM tdata WHERE id = ".$id;
				$rs = $this->db->query($SQL);
				if ($rs) {
					$data['success'] = true;
				}
			} catch (Exception $e) {
				$data['success'] = false;
				$data['message'] = "Gagal memproses data ". $e->getMessage();
			}
		}
		else{
			$data['success'] = false;
			$data['message'] = "Invalid Form Type";
		}
		echo json_encode($data);
	}
}
