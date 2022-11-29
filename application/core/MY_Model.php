<?php 
class MY_Model extends CI_Model{

    // ==== Create Read Upadte Delete ==== //

    public $table;

    public function __construct($table){
        $this->load->database();
        $this->table = $table;
    }
    

    public function create($insert){
        return $this->db->insert($this->table,$insert);
    }


    public function read($where, $limit=99){
        return $this->db->get_where($this->table, $where, $limit)->result_array();
    }

    public function readOne(){
        return $this->db->get($this->table)->row_array();
    }

    public function search($where, $limit=99){
        $this->db->like($where,'both');
        return $this->db->get($this->table,$limit)->result_array();
    }


    public function update($where,$data_array){
        $this->db->set($data_array);
        $this->db->where($where);
        $this->db->update($this->table);
    }


    public function soft_delete($where){
        $this->db->where($where);
        return $this->db->update($this->table, ['is_deleted'=>1]);
    }
    public function delete($where){
        return $this->db->delete($this->table, $where);
    }

}
?>