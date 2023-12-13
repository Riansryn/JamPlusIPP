<?php
class Ipp_kategori_model extends CI_Model
{
    private $table = 'ipp_kategori';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Create
    public function tambah_kategori($data)
    {
        $this->db->insert('ipp_kategori', $data);
        return $this->db->insert_id();
    }

    // Read
    public function kategori()
    {
        return $this->db->get('ipp_kategori')->result();
    }
    
    public function kategori_aktif()
    {
        $this->db->where('ktg_status', 1);
        return $this->db->get('ipp_kategori')->result();
    }

    public function getKategori(){
        return $this->db->get('ipp_kategori')->result();
    }

    public function detail_kategori($ktg_id)
    {
        return $this->db->get_where('ipp_kategori', array('ktg_id' => $ktg_id))->row();
    }

    // Update
    public function update_kategori($where, $data)
    {
        $this->db->where($where);
        $this->db->update('ipp_kategori', $data);
    }
    
    function get_kategori($where,$table){		
        return $this->db->get_where($table,$where);
    }

    // Delete
    public function hapus_kategori($ktg_id)
    {
        return $this->db->delete('ipp_kategori', array('ktg_id' => $ktg_id));
    }
}
?>
