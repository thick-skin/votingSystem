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

			//$this->db->where('candidate', $candidate);
			$query = $this->db->query('SELECT id, name, comment_body, comment_time, campaign_id FROM `campaign_comments` WHERE campaign_id="'.$camp_id.'" ORDER BY id DESC LIMIT 2');

			//$query = $this->db->get('candidates');
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) 
			        $data[] = array(
			            'name' => $row->name,
			            'comment_body' => $row->comment_body,
			            'campaign_id' => $row->campaign_id,
			            'comment_time' => $row->comment_time

			        );

			return $data;
			}else{
				return false;
			}
/*
		$this->db->order_by('campaign_comments.id', 'DESC');
		$query = $this->db->get('campaign_comments');
		return $query->result_array();*/
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