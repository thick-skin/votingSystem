<?php  
	class Users extends CI_Controller	{
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

		public function register()
		{
			if (!$this->session->userdata('log_in')) {
			 	redirect('home');
			 }
			$data['title'] = "Register";
			$election_year = date("Y");
			//Show seats frm db in a select tag
			$data['seats'] = $this->users_model->get_seats($election_year);

			$this->load->view('templates/header', $data);
			$this->load->view('users/register', $data);
			$this->load->view('templates/footer');
		}

		public function generateKey()
		{
			$key = rand(345678,765432);
			// Check if number exists in database
			$check = $this->users_model->generateKey($key);
			
			if($check = true){
				echo json_encode($key);
			}else{
				$key = rand(345678,765432);
			}

		}
		
		public function regVoter()
		{
			//login check
			//if (!$this->session->userdata('log_in')) {
			 //	redirect('home');
			 //}

			
			//To check registerAsVoter button and register
			//if ($this->input->post('regvoter')) {
			$data = array('status' => false, 'messages' => array());
			//Show seats frm db in a select tag
			//$data['seats'] = $this->users_model->get_seats();
			$this->form_validation->set_rules('level', 'Level', 'required');
			$this->form_validation->set_rules('fname', 'Firstname', 'required');
			$this->form_validation->set_rules('lname', 'Lastname', 'required');
			$this->form_validation->set_rules('oname', 'Othernames', 'required');
			$this->form_validation->set_rules('faculty', 'Faculty', 'required');
			$this->form_validation->set_rules('dept', 'Department', 'required');
			$this->form_validation->set_rules('regno', 'RegNo', 'required|is_unique[voters.regno]',
				array(
                'is_unique'     => 'This %s already exists.'
        )
		);
			$this->form_validation->set_rules('key', 'Key', 'required|is_unique[voters.votekey]',
				array(
					'required'      => 'Please select the %s input.',
                'is_unique'     => 'Please select the %s input again.'
        )
			);
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
			
		if ($this->form_validation->run() === FALSE) {
			foreach ($_POST as $key => $value) {
					$data['messages'][$key] = form_error($key);
				}
		}else{
			$data['status'] = true;
			
			$this->users_model->registerVoter();
		}
		echo json_encode($data);
		}

		public function regCand()
		{
				$data = array('status' => false, 'messages' => array());
			//Show seats frm db in a select tag
			//$data['seats'] = $this->users_model->get_seats();
		
			$this->form_validation->set_rules('year', 'Level', 'required');
			$this->form_validation->set_rules('first', 'Firstname', 'required');
			$this->form_validation->set_rules('last', 'Lastname', 'required');
			$this->form_validation->set_rules('other', 'Othernames', 'required');
			$this->form_validation->set_rules('fac', 'Faculty', 'required');
			$this->form_validation->set_rules('dep', 'Department', 'required');
			$this->form_validation->set_rules('reg', 'RegNo', 'required');
			$this->form_validation->set_rules('gpa', 'GPA', 'required');
			$this->form_validation->set_rules('uname', 'username', 'required');
			$this->form_validation->set_rules('pwd', 'password', 'required');
			$this->form_validation->set_rules('seat', 'Seat', 'callback_seat_check');
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
			
		if ($this->form_validation->run() === FALSE) {
			foreach ($_POST as $key => $value) {
					$data['messages'][$key] = form_error($key);
				}
		} else {
			//hash password
			$enc_password = md5($this->input->post('pwd'));
			if($_FILES['userfile']['error'] != 0) {
                $data['status'] = false;
                $data['messages'] = array("userfile"=>"<p class='text-danger'>Select image to upload</p>");
            } else {
			//Upload Image
			$config['upload_path'] = './assets/img/candidates';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2048';
			$config['max_width'] = '0';
			$config['max_height'] = '0';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('userfile')) {
				$errors = array('error' => $this->upload->display_errors());
				$post_image = 'noimage.jpg';
			}else{
				$data = array('upload_data' => $this->upload->data());
				$post_image = $_FILES['userfile']['name'];
			}
			$election_year = date("Y");
			$data['status'] = true;


			$this->users_model->registerCandidate($post_image, $enc_password, $election_year);
		}
		}
		echo json_encode($data);
		}

		public function seat_check($str)
        {
                if ($str == 'Select seat')
                {
                        $this->form_validation->set_message('seat_check', 'Please select a post');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }

		public function candidates()
		{
			$data['title'] = "Candidates";
			$election_year = date("Y");

			$data['candidates'] = $this->users_model->candidates($election_year);
			$data['seats'] = $this->users_model->get_seats($election_year);
			$this->checkSm();

			$this->load->view('templates/header', $data);
			$this->load->view('users/candidates', $data);
			$this->load->view('templates/footer');
		}

		public function login()
		{
			$data['title'] = 'Admin not logged in';

			$admin = 'admin';
			$pass = 'password';

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
		
			if ($this->form_validation->run() === FALSE) {
				$this->checkSm();
				$this->load->view('templates/header', $data);
				$this->load->view('pages/home');
				$this->load->view('templates/footer');
			}else{
				// Get username
				$username = $this->input->post('username');

				// Get password
				$password = $this->input->post('password');

				// Login user
				if ($username == $admin && $password == $pass) {
					// Create session
					$user_data = array(
						'usr_id' => 1,
						'usernme' => $username,
						'log_in' => true
					);

					$this->session->set_userdata($user_data);

				//Set message
				$this->session->set_flashdata('user_loggedin', 'You are now logged in as');

				redirect('users/dashboard');

				} else {						
				//Set message
				$this->session->set_flashdata('login_failed', 'Login is invalid');

				redirect('home');
					
				}
				
			}
		}
		// Logout user
		public function logout()
		{
			if (!$this->session->userdata('log_in')) {
			 	redirect('home');
			 }
			// Unset user data
			$this->session->unset_userdata('log_in');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('username');

			//Set message
				$this->session->set_flashdata('user_loggedout', 'Logged out');	
				//$this->session->sess_destroy();	
			redirect('home');
		}

		public function dashboard() {
			
			 if (!$this->session->userdata('log_in')) {
			 	redirect('home');
			 } 
			 $election_year = date("Y");
			$data['title'] = 'Dashboard';

			$data['seats'] = $this->users_model->get_seats($election_year);

			$data['votes'] = $this->vote_model->getVotes($election_year);
			
			$this->load->view('templates/header', $data);
				$this->load->view('users/dashboard', $data);
				$this->load->view('templates/footer');
			// Remember to Check login
				}

		public function getSeat()
		{
			$election_year = date("Y");
			$seats = $this->users_model->get_seats($election_year);

			echo json_encode($seats);
			
		}

		public function seatYear($str)
        {
        	$election_year = date("Y");
        	$seats = $this->users_model->get_seats($election_year);
        	foreach ($seats as $seat) {
        		
                if ($str == $seat['name'])
                {
                        $this->form_validation->set_message('seatYear', 'You have created this seat.');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        	}
        }

		public function dashB()
		{
			$data = array('success' => false, 'messages' => array());

			$this->form_validation->set_rules('name', 'Name', 'required|callback_seatYear');
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if($this->form_validation->run() === FALSE){
				foreach ($_POST as $key => $value) {
					$data['messages'][$key] = form_error($key);
				}
			} else {
				$data['success'] = true;
				$election_year = date("Y");

				$this->users_model->create_seat($election_year);
			}
			echo json_encode($data);
			}

		public function deleteSeat(){
			// Remember to Check login
		//	if (!$this->session->userdata('log_in')) {
		//	 	redirect('home');
		//	 }
			//$data = array('success' => false, 'messages' => array());
		$btn = $this->input->post('seatname');
		
		$this->users_model->delete_seat($btn);
		
				$data['success'] = true;
		
		
			echo json_encode($data);
		}

		// Login Voter
		public function loginVoter()
		{
			$data = array('success' => false, 'messages' => array());
			$data['error'] = false;
			
			$this->form_validation->set_rules('voterRegNo', 'voterRegNo', 'required');
			$this->form_validation->set_rules('voterKey', 'voterKey', 'required');
			$this->form_validation->set_error_delimiters('<p class="text-danger bg-danger">', '</p>');
		
			if ($this->form_validation->run() === FALSE) {
				foreach ($_POST as $key => $value) {
					$data['messages'][$key] = form_error($key);
				}
			}else{
				// Get voterRegNo
				$voterRegNo = $this->input->post('voterRegNo');

				// Get and encrypt voterKey
				$voterKey = $this->input->post('voterKey');

				// Login voter
				$voter_ids = $this->users_model->loginVoter($voterRegNo, $voterKey);

				if ($voter_ids) {
					// Create session
					foreach ($voter_ids as $voter_id) {
						
					$voter_data = array(
						'voter_name' => $voter_id['fname'],
						'voter_id' => $voter_id['id'],
						'voterdept' => $voter_id['dept'],
						'voterlevel' => $voter_id['level'],
						'voter_in' => true
					);

					$this->session->set_userdata($voter_data);
					}

				$data['success'] = true;

				} else {
					$data['error'] = true;
				}
				
			}
			echo json_encode($data);
		}

		// Logout voter
		public function logoutVoter()
		{
			if (!$this->session->userdata('voter_in')) {
			 	redirect('home');
			 }
			// Unset user data
			$this->session->unset_userdata('voter_name');
			$this->session->unset_userdata('voter_in');
			$this->session->unset_userdata('voterlevel');
			$this->session->unset_userdata('voterdept');
			$this->session->unset_userdata('voter_id');


				$this->session->sess_destroy();	
			redirect('home');
		}
	}