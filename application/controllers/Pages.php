<?php 
class Pages extends CI_Controller{
	public function checkSm(){
			$this->session->unset_userdata('resultReady');
			$resultReadys = $this->vote_model->voteReady();
			if ($resultReadys) {
				// Create session
					foreach ($resultReadys as $resultReady) {
						
						if ($resultReady['show_results'] == 1) {
							$result_data = array(
								'resultReady' => true
						);

					$this->session->set_userdata($result_data);
							}	
					}
			}
		}

	public function view($page = 'home'){
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}
		$data['title'] = ucfirst($page);
		$data['campaign'] = $this->pages_model->get_campaign();
		$this->checkSm();

		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page);
		$this->load->view('templates/footer');
	}

	public function showCampaign()
		{
			$campaign = $this->pages_model->get_campaign();

			echo json_encode($campaign);
			
		}

	public function create_campaign()
	{
		$data = array('success' => false, 'messages' => array());
		$data['error'] = false;
			

			$this->form_validation->set_rules('user', 'Username', 'required');
			$this->form_validation->set_rules('pass', 'Password', 'required');
			$this->form_validation->set_rules('campaign', 'Campaign', 'required');
			$this->form_validation->set_error_delimiters('<small class="text-danger"><i>', '</i></small>');

			if($this->form_validation->run() === FALSE){
				foreach ($_POST as $key => $value) {
					$data['messages'][$key] = form_error($key);
				}
			} else {
				// Get username
				$username = $this->input->post('user');

				// Get and encrypt password
				$password = md5($this->input->post('pass'));

				// Check if candidate exists
				$user_seats = $this->pages_model->candidateExists($username, $password);

				if ($user_seats) {
					foreach ($user_seats as $user_seat) {
						
					$user_seat = $user_seat['seat'];

					$this->pages_model->create_campaign($username, $user_seat);
					
					}


					$data['success'] = true;
				
				}else{
					$data['error'] = true;
				}
			}
			echo json_encode($data);
	}
	
}
