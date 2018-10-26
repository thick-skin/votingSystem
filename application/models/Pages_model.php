<?php  
	class Pages_model extends CI_Model{
		public function __construct(){
		$this->load->database();	
		}

		public function get_campaign()
	{
		$query = $this->db->query('SELECT * FROM `campaign` ORDER BY id DESC LIMIT 2');
		return $query->result_array();
	}

	public function get_MoreCampaign()
	{
		$offset = $this->input->get('offset');
		$query = $this->db->query('SELECT * FROM `campaign` ORDER BY id DESC LIMIT '.$offset.', 2');
		return $query->result_array();
	}

	public function showFirstCampaign($lastId)
	{
		$query = $this->db->query('SELECT * FROM `campaign` WHERE id > "'.$lastId.'" ORDER BY id DESC');
		return $query->result_array();
	}

	public function candidate($candidate)
	{
		$query = $this->db->query('SELECT * FROM `candidates` WHERE uname = "'.$candidate.'"');
		return $query->result_array();
	}

	public function get_CampaignWhere($candidate)
	{
		$query = $this->db->query('SELECT * FROM `campaign` WHERE username = "'.$candidate.'" ORDER BY id DESC LIMIT 2');
		return $query->result_array();
	}

	public function get_MoreCampaignWhere($candidate)
	{
		$offset = $this->input->get('offset');
		$query = $this->db->query('SELECT * FROM `campaign` WHERE username = "'.$candidate.'" ORDER BY id DESC LIMIT '.$offset.', 2');
		return $query->result_array();
	}

	public function get_FirstCampaignWhere($candidate)
	{
		$query = $this->db->query('SELECT * FROM `campaign` WHERE username = "'.$candidate.'" ORDER BY id DESC LIMIT 1');
		return $query->result_array();
	}

		public function addComment($camp_id, $name, $comment)
		{
			$data = array(
				'name' => $name,
				'campaign_id' => $camp_id,
				'comment_body' => $comment
			);

			return $this->db->insert('campaign_comments', $data);
		}

		public function get_comments()
	{
		$camp_id = $this->input->get('camp_id');
		$limit = $this->input->get('limit');

		$query = $this->db->query('SELECT id, name, comment_body, comment_time, campaign_id FROM `campaign_comments` WHERE campaign_id="'.$camp_id.'" ORDER BY id DESC LIMIT '.$limit.'');

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

		public function create_campaign($username, $user_seat, $user_id, $user_seat_id)
		{
			$data = array(
				'username' => $username,
				'user_id' => $user_id,
				'user_seat' => $user_seat,
				'user_seat_id' => $user_seat_id,
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