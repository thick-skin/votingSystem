<?php  
	class Users_model extends CI_Model{
		public function __construct(){
		$this->load->database();	
		}

		public function generateKey($key)
		{
			$key = $key;
			$query = $this->db->get_where('voters', array('votekey' => $key));
			if (empty($query->row_array())) {
				return true;
		}else{
			return false;
		}
	}

		public function registerVoter()
		{
				//User data array
			$data = array(
				'level' => $this->input->post('level'),
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'oname' => $this->input->post('oname'),
				'faculty' => $this->input->post('faculty'),
				'dept' => $this->input->post('dept'),
				'regno' => $this->input->post('regno'),
				'votekey' => $this->input->post('key')
			);

			//Insert user
			return $this->db->insert('voters', $data);

		}

		public function registerCandidate($post_image, $enc_password)
	{
		$slug = $this->input->post('uname');
		$data = array(
			'image' => $post_image,
			'year' => $this->input->post('year'),
			'first_name' => $this->input->post('first'),
			'last_name' => $this->input->post('last'),
			'other_name' => $this->input->post('other'),
			'fac' => $this->input->post('fac'),
			'dep' => $this->input->post('dep'),
			'reg' => $this->input->post('reg'),
			'gpa' => $this->input->post('gpa'), 
			'uname' => $this->input->post('uname'), 
			'pwd' => $enc_password,
			'seat' => $this->input->post('seat')
		);

		return $this->db->insert('candidates', $data);
	}

	public function candidates()
	{
		$this->db->order_by('id');
		$query = $this->db->get('candidates');
		return $query->result_array();
	}

		public function get_seats()
	{
		$this->db->order_by('id');
		$query = $this->db->get('seats');
		return $query->result_array();
	}

		public function create_seat()
		{
			$data = array(
				'name' => $this->input->post('name')
			);

			return $this->db->insert('seats', $data);
		}

		/*public function get_seat($id){
			$query = $this->db->get_where('seats', array('id' => $id));
			return $query->row();
		}*/

		public function delete_seat($btn)
	{	
		$name = $btn;

		$this->db->where('name', $name);
		$this->db->delete('seats');
		$this->db->where('seat', $name);
		$this->db->delete('candidates');
		
		return true;
	}
	}