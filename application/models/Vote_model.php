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

		public function getVotes()
		{
			/*$this->db->where('seat', $candSeat);
			$this->db->where('candidate', $candName);

			$result = $this->db->get('votes');

			if ($result->num_rows() > 0) {
				return $result;
			} else {
				return false;
			}*/

		$query = $this->db->query('SELECT candidate, seat, COUNT(candidate) AS votecount FROM `votes` GROUP BY candidate ORDER BY votecount DESC');

			if ($query->num_rows() > 0){
			    foreach ($query->result() as $row) 
			        $data[] = array(
			            'total' => $row->votecount,
			            'candidate' => $row->candidate,
			            'seat' => $row->seat
			        );

			return $data;
			}
		}
	}