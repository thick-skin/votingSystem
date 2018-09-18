<?php  
	class Pages_model extends CI_Model{
		public function __construct(){
		$this->load->database();	
		}

		public function get_campaign()
	{
		$this->db->order_by('campaign.id', 'DESC');
		$query = $this->db->get('campaign');
		return $query->result_array();
	}

	// Check if candidate exists
		public function candidateExists($username, $password)
		{
		// Validate
			$this->db->where('uname', $username);
			$this->db->where('pwd', $password);

			$result = $this->db->get('candidates');

			if ($result->num_rows() > 0) {
				return $result->result_array();
			} else {
				return false;
			}
			
		}

		public function create_campaign($username, $user_seat)
		{
			$data = array(
				'username' => $username,
				'user_seat' => $user_seat,
				'campaign' => $this->input->post('campaign')
			);

			return $this->db->insert('campaign', $data);
		}

		/*public function delete_campaign($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('seats');
		return true;
	}*/
	}