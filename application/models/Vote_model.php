<?php  
	class Vote_model extends CI_Model{
		public function __construct(){
		$this->load->database();	
		}

		public function create_vote($voterdept, $voterlevel, $voteChoice, $voteChoiceSeat, $voteChoiceId, $election_year)
		{
			$data = array(
				'dept' => $voterdept,
				'level' => $voterlevel,
				'seat' => $voteChoiceSeat,
				'candidate' => $voteChoice,
				'candidate_id' => $voteChoiceId,
				'election_year' => $election_year
			);
			//$voterid = $this->session->userdata('voter_id');

			return $this->db->insert('votes', $data);
			//delete voterRecord from db
			//$this->db->where('id', $voterid);
			//$this->db->delete('voters');
			//return true;
		}

		public function updateVotes()
		{
		
		$this->db->set('show_results', 1);
        $this->db->where('show_results', 0);
        $result = $this->db->update('votes');

			//$result = $this->db->update_batch('votes', $data, 'id');
			if ($result) {
				return true;
			}
		}

		public function getVotes($election_year)
		{
			$election_year = $election_year;
		$query = $this->db->query('SELECT candidate, seat, COUNT(candidate) AS votecount FROM `votes` WHERE election_year = "'.$election_year.'" GROUP BY candidate ORDER BY votecount DESC');

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

		public function voteDetails()
		{
			$candidate = $this->input->get('candidate');

			//$this->db->where('candidate', $candidate);
			$query = $this->db->query('SELECT dept, seat, COUNT(dept) AS votecount FROM `votes` WHERE candidate="'.$candidate.'" GROUP BY dept ORDER BY votecount DESC');

			//$query = $this->db->get('candidates');
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) 
			        $data[] = array(
			            'total' => $row->votecount,
			            'dept' => $row->dept
			            //'seat' => $row->seat
			        );

			return $data;
			}else{
				return false;
			}
		}

		public function voteReady()
	{
		$this->db->order_by('id');
		$query = $this->db->get('votes');
		return $query->result_array();
	}

	public function removeResult()
	{
		$this->db->set('show_results', 0);
        $this->db->where('show_results', 1);
        $result = $this->db->update('votes');

			//$result = $this->db->update_batch('votes', $data, 'id');
			if ($result) {
				return true;
			}
	}
	}