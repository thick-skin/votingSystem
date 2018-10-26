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
		$data['candidateSet'] = false;
		$data['title'] = ucfirst($page);
		//$data['campaign'] = $this->pages_model->get_campaign();
		$this->checkSm();

		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page);
		$this->load->view('templates/footer');
	}

	public function showCampaign()
		{
			$candidate = $this->input->get('candidate');
			if ($candidate == 'Home') {
			$campaign = $this->pages_model->get_campaign();

			echo json_encode($campaign);
			}else{
				$campaign = $this->pages_model->get_CampaignWhere($candidate);

			echo json_encode($campaign);
			}
		}

	public function showMoreCampaign()
		{
			$candidate = $this->input->get('candidate');
			if ($candidate == 'Home') {
			$campaign = $this->pages_model->get_MoreCampaign();

			echo json_encode($campaign);
			}else{
				
				$campaign = $this->pages_model->get_MoreCampaignWhere($candidate);

			echo json_encode($campaign);
			}
			
		}

	public function showFirstCampaign()
	{
		$candidate = $this->input->get('candidate');
		$lastId = $this->input->get('lastId');
			if ($candidate == 'Home') {
			$campaign = $this->pages_model->showFirstCampaign($lastId);

			echo json_encode($campaign);
			}else{
				
				$campaign = $this->pages_model->get_FirstCampaignWhere($candidate);

			echo json_encode($campaign);
			}
	}

	public function candidatePersonal()
	{
		$this->checkSm();
		
		$data['candidateSet'] = true;
		$candidate = $this->uri->segment(3);
		$data['title'] = ucfirst($candidate);

		$data['candidate1'] = $this->pages_model->candidate($candidate);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/home', $data);
		$this->load->view('templates/footer');
	}

	public function addComment()
	{
		$data = array('success' => false, 'messages' => array());
		$camp_id = $this->input->post('campaignid');
		$name = $this->input->post('commentName-'.$camp_id);
		$comment = $this->input->post('commentBody-'.$camp_id);

			$this->form_validation->set_rules('commentName-'.$camp_id, 'Name', 'required');
			$this->form_validation->set_rules('commentBody-'.$camp_id, 'Comment', 'required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if($this->form_validation->run() === FALSE){
				foreach ($_POST as $key => $value) {
					$data['messages'][$key] = form_error($key);
				}
			}else{
				$this->pages_model->addComment($camp_id, $name, $comment);
				$data['success'] = true;
			}
			echo json_encode($data);
	}

	public function showComments()
		{
			$comment = $this->pages_model->get_comments();

			echo json_encode($comment);
			
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
				$candidateExists = $this->pages_model->candidateExists($username, $password);

				if ($candidateExists) {
					foreach ($candidateExists as $candidateExist) {
						
					$user_id = $candidateExist['id'];
					$user_seat = $candidateExist['seat'];
					$user_seat_id = $candidateExist['seat_id'];

					$this->pages_model->create_campaign($username, $user_seat, $user_id, $user_seat_id);
					
					}


					$data['success'] = true;
				
				}else{
					$data['error'] = true;
				}
			}
			echo json_encode($data);
	}
	
}
