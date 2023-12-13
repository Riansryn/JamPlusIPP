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

	//ganttchart
    public function getChartData() {
        $sql = "SELECT ipp_pekerjaan.pkj_nama, ipp_pekerjaan.pkj_creaby, ipp_kategori.ktg_nama, sso_karyawan.kry_nama
                FROM ipp_pekerjaan
                JOIN ipp_kategori ON ipp_pekerjaan.ktg_id = ipp_kategori.ktg_id
                JOIN sso_karyawan ON ipp_pekerjaan.pkj_creaby = sso_karyawan.kry_id";

        $result = $this->db->query($sql);

        $data = array(
            'categories' => array(),
            'dataset1' => array(),
            'dataset2' => array(),
            'dataset3' => array(),
            'dataset4' => array(),
        );

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data['categories'][] = $row['kry_nama'];
                $data['dataset1'][] = $row['ktg_nama'];
                $data['dataset2'][] = $row['ktg_nama'];
                $data['dataset3'][] = $row['ktg_nama'];
                $data['dataset4'][] = $row['ktg_nama'];
        	}
    	}

        return $data;
    }
}
?>
