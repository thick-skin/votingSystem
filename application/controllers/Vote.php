<?php 
	class Vote extends CI_Controller	{
		
		public function index()
		{
			$data['title'] = "Vote";
			$data['candidates'] = $this->users_model->candidates();
			$data['seats'] = $this->users_model->get_seats();

			$this->load->view('templates/header', $data);
			$this->load->view('vote/index', $data);
			$this->load->view('templates/footer');
		}

		public function ballot()
		{	
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
			}
			}


			echo json_encode($data);
		}

	}
			/*	if (isset($_POST[$seat['name']])) {
					$data['status'] = true;
					
				}*/