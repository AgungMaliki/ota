<?php
class Booking_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
		date_default_timezone_set('Asia/Jakarta');
    }


    public function get_ticket()
    {

        $query = $this->db->query('select a.*, b.name as origin_airport, c.name as destination_airport, d.name as airline_name from ticket a
        left join airport b ON b.code = a.origin_airport_code
        left join airport c ON c.code = a.destination_airport_code
        left join airline d ON d.code = a.airline_code where a.stock > 0 ');

		return $query->result();
    }

    public function get_ticket_id($id)
    {
        $this->db->where('id', $id);
		$query = $this->db->get('ticket');

		return $query->result();
    }

    public function insert_ticket($p)
    {
        $this->db->insert('ticket_inquiry', $p);
		return $this->db->affected_rows();
    }

    public function get_stock($p)
    {
        $this->db->where('id', $p);
        $res = $this->db->get('ticket');
        return $res->row()->stock;
    }

    public function update_ticket($p)
    {
        $this->db->where('id', $p['id']);
        $this->db->update('ticket', $p);
        return $this->db->affected_rows();
    }
}

?>