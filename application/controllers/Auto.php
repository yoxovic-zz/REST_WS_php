<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Auto extends REST_Controller {

	function __construct() {
		
		parent::__construct();
		$this->load->model('Auto_model');

	}

	public function auto_lista_get(){
		
		$rezultat = $this->Auto_model->auto_lista();
		
		if(is_null($rezultat)){
			$this->response(['status' => FALSE, 'message' => 'Traženi resurs nije pronađen!' ],
							REST_Controller::HTTP_NOT_FOUND); // NOT FOUND (404)
		}
		
		$this->response($rezultat, REST_Controller::HTTP_OK); // OK (200)
	}
	
	public function auto_id_get(){
			
			if($this->get('id') == null){
				$this->response(null, REST_Controller::HTTP_BAD_REQUEST); // BAD REQUEST (400)
			}
		
			$rezultat = $this->Auto_model->auto_po_id($this->get('id'));
			
			if(is_null($rezultat)){
				$this->response(['status' => FALSE, 'message' => 'Traženi resurs nije pronađen!' ], 
								REST_Controller::HTTP_NOT_FOUND); // NOT FOUND (404)
			}
			
			$this->response($rezultat, REST_Controller::HTTP_OK); // OK (200)
	}
	
	public function auto_podaci_post(){
		
		$marka = $this->post('marka');
		$model = $this->post('model');
		$godiste = $this->post('godiste');
		$kubikaza = $this->post('kubikaza');
		$boja = $this->post('boja');
		$cena = $this->post('cena');
		
		if($marka == null || $model == null || $godiste == null || $kubikaza == null || $boja == null || $cena == null){
			$this->response(null, REST_Controller::HTTP_BAD_REQUEST); // BAD REQUEST (400)
		}
		
		$rezultat = $this->Auto_model->sacuvaj_auto($marka, $model, $godiste, $kubikaza, $boja, $cena);
		
		if(is_null($rezultat)){
			$this->response(['status' => FALSE, 'message' => 'Zahtev za resursom je loše definisan!'],
							REST_Controller::HTTP_NOT_FOUND); // NOT FOUND (404)
		}

		$this->response($rezultat, REST_Controller::HTTP_CREATED); // OK (201)
	}
	
	public function auto_azuriraj_put(){
		
		if($this->put('auto_id') == null || $this->put('marka')){
			$this->response(null, REST_Controller::HTTP_BAD_REQUEST); // BAD REQUEST (400)
		}
		
		$rezultat = $this->Auto_model->uredi_auto($this->put('auto_id'), $this->put('marka'));
		
		if(is_null($rezultat)){
			$this->response(['status' => FALSE, 'message' => 'Zahtev za resursom je loše definisan!',
							'id'=> $this->put('auto_id'), 'marka'=> $this->put('marka')],
							REST_Controller::HTTP_NOT_MODIFIED); // NOT MODIFIED (304)
		}

		$this->response($rezultat, REST_Controller::HTTP_ACCEPTED); // OK (202)
	}
	
	public function auto_izbrisi_delete($auto_id){
		
		if($auto_id == null){
			$this->response(null, REST_Controller::HTTP_BAD_REQUEST); // BAD REQUEST (400)
		}
		
		$rezultat = $this->Auto_model->izbrisi_auto($auto_id);
		
		if($rezultat != TRUE){
			$this->response(['status' => FALSE, 'message' => 'Zahtev za resursom je loše definisan!'],
							REST_Controller::HTTP_BAD_REQUEST); // BAD REQUEST (400)
		}

		$this->response($rezultat, REST_Controller::HTTP_OK); // OK (200)
	}
	
}
