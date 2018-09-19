<?php 
	class Vote extends CI_Controller	{
		
		public function index()
		{
			if (!$this->session->userdata('voter_in')) {
			 	redirect('home');
			 }
			$data['title'] = "Vote";
			$data['candidates'] = $this->users_model->candidates();
			$data['seats'] = $this->users_model->get_seats();

			$this->load->view('templates/header', $data);
			$this->load->view('vote/index', $data);
			$this->load->view('templates/footer');
		}

		public function ballot()
		{	
			if (!$this->session->userdata('voter_in')) {
			 	redirect('home');
			 }
			$data['candidates'] = $this->users_model->candidates();
			$data['seats'] = $this->users_model->get_seats();

			$data = array('status' => false, 'messages' => array());
			$seats = $this->users_model->get_seats();
			$candidates = $this->users_model->candidates();

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
						$this->vote_model->create_vote($voterdept, $voterlevel, $voteChoice, $voteChoiceSeat, $voteChoiceId);
					}
				}
			}
			// Unset user data
			$this->session->unset_userdata('voter_name');
			$this->session->unset_userdata('voter_in');
			$this->session->unset_userdata('voterlevel');
			$this->session->unset_userdata('voterdept');
			$this->session->unset_userdata('voter_id');
			$this->session->sess_destroy();
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

	}
			/*	if (isset($_POST[$seat['name']])) {
					$data['status'] = true;
					
				}*/