<?php 
	class Vote extends CI_Controller	{
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
		
		public function index()
		{
			$this->checkSm();
			if ($this->session->userdata('resultReady')) {
			 	redirect('vote/results');
			 }
			if (!$this->session->userdata('voter_in')) {
			 	redirect('home');
			 }
			 $election_year = date("Y");

			$data['title'] = "Vote";
			$data['candidates'] = $this->users_model->candidates($election_year);
			$data['seats'] = $this->users_model->get_seats($election_year);

			$this->load->view('templates/header', $data);
			$this->load->view('vote/index', $data);
			$this->load->view('templates/footer');
		}

		public function ballot()
		{	
			if (!$this->session->userdata('voter_in')) {
			 	redirect('home');
			 }
			 $election_year = date("Y");
			$data['candidates'] = $this->users_model->candidates($election_year);
			$data['seats'] = $this->users_model->get_seats($election_year);

			$data = array('status' => false, 'messages' => array());
			$seats = $this->users_model->get_seats($election_year);
			$candidates = $this->users_model->candidates($election_year);

			$st = 0;
			foreach ($seats as $seat) {
				$st++;
			$this->form_validation->set_rules('seat-'.$st, $seat['name'], 'required', array(
					'required'      => 'You need to vote for a %s.'));
			}
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run() == FALSE) {
				$key = 0;
				foreach ($seats as $seat => $value) {
					$key++;
					$data['messages']['seat-'.$key] = form_error('seat-'.$key);
				}
			} else {
				$data['status'] = true;
				$stkey = 0;
			foreach ($seats as $seat) {
				$stkey++;
				$voteChoice = $this->input->post('seat-'.$stkey);
				foreach ($candidates as $candidate) {
					if ($candidate['uname'] == $voteChoice) {
					$voteChoiceSeat = $candidate['seat'];
					$voteChoiceId = $candidate['id'];
					$voterdept = $this->session->userdata('voterdept');
					$voterlevel = $this->session->userdata('voterlevel');
					$election_year = date("Y");
						$this->vote_model->create_vote($voterdept, $voterlevel, $voteChoice, $voteChoiceSeat, $voteChoiceId, $election_year);
					}
				}
			}
				// Unset user data
				$this->thanksForVoting();
			}


			echo json_encode($data);
		}

		public function thanksForVoting()
		{
			// Unset user data
			$this->session->unset_userdata('voter_name');
			$this->session->unset_userdata('voter_in');
			$this->session->unset_userdata('voterlevel');
			$this->session->unset_userdata('voterdept');
			$this->session->unset_userdata('voter_id');
			$this->session->sess_destroy();	
		}

		public function releaseResult()
		{
			$data['status'] = false;

			$result = $this->vote_model->updateVotes();
			if ($result) {
				$data['status'] = true;
			}
			echo json_encode($data);
		}


		public function results()
		{
			$this->checkSm();
			if (!$this->session->userdata('resultReady')) {
			 	redirect('home');
			 }
			 $election_year = date("Y");

			$data['title'] = 'Results';
			$data['seats'] = $this->users_model->get_seats($election_year);
			$data['candidates'] = $this->users_model->candidates($election_year);
			$data['votes'] = $this->vote_model->getVotes($election_year);

			$this->load->view('templates/header', $data);
			$this->load->view('vote/results', $data);
			$this->load->view('templates/footer');
		}

		public function yearResult()
		{
			$this->checkSm();
			if (!$this->session->userdata('resultReady')) {
			 	redirect('home');
			 }
			 $election_year = $this->uri->segment(3);

			$data['seats'] = $this->users_model->get_seats($election_year);
			$data['candidates'] = $this->users_model->candidates($election_year);
			$data['votes'] = $this->vote_model->getVotes($election_year);
			
			$this->load->view('vote/resultyear', $data);
		}

		public function hideResults()
		{
			$removeResult = $this->vote_model->removeResult();
			if ($removeResult) {
			$this->session->unset_userdata('resultReady');
			redirect('users/dashboard');
			}
		}

		public function voteDetails()
		{
			$detail = $this->vote_model->voteDetails();
			echo json_encode($detail);
		}

	}
			/*	if (isset($_POST[$seat['name']])) {
					$data['status'] = true;
					
				}*/