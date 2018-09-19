<?php  
	class Vote_model extends CI_Model{
		public function __construct(){
		$this->load->database();	
		}

		public function create_vote($voterdept, $voterlevel, $voteChoice, $voteChoiceSeat, $voteChoiceId)
		{
			$data = array(
				'dept' => $voterdept,
				'level' => $voterlevel,
				'seat' => $voteChoiceSeat,
				'candidate' => $voteChoice,
				'candidate_id' => $voteChoiceId
			);
			//$voterid = $this->session->userdata('voter_id');

			return $this->db->insert('votes', $data);
			//delete voterRecord from db
			//$this->db->where('id', $voterid);
			//$this->db->delete('voters');
			//return true;
		}
	}