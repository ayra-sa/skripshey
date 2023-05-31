<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_CentroidAwal extends CI_Controller {

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

		$SQL = "SELECT * FROM tcentroid ";

		if ($id == '') {
			$rs = $this->db->query($SQL);
		}
		else{
			$rs = $this->ModelsExecuteMaster->FindData(array('id'=>$id),'tcentroid');
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
		$KodeData = $this->input->post('KodeData');
		$Centroid = $this->input->post('Centroid');
		$Asset = $this->input->post('Asset');
		$JmlPekerja = $this->input->post('JmlPekerja');
		$Omset = $this->input->post('Omset');

		// $exploder = explode("|",$ItemGroup[0]);

		$id = $this->input->post('id');

		$formtype = $this->input->post('formtype');

		$param = array(
			'KodeData' 			=> $KodeData,
			'Centroid'		=> $Centroid,
			'Asset' 	=> $Asset,
			'JmlPekerja' 		=> $JmlPekerja,
			'Omset' 	=> $Omset,
		);
		if ($formtype == 'add') {
			$this->db->trans_begin();
			try {
				$call_x = $this->ModelsExecuteMaster->ExecInsert($param,'tcentroid');
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
			$param = array(
				'Asset' 	=> $Asset,
				'JmlPekerja' 		=> $JmlPekerja,
				'Omset' 	=> $Omset,
			);
			try {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('id'=> $id),'tcentroid');
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
				$SQL = "DELETE FROM tcentroid WHERE id = ".$id;
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
