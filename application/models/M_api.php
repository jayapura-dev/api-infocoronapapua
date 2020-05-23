<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_api extends CI_model{
    function suspect()
    {
        $query = $this->db->query("SELECT
        tb_kabupaten.id_kabupaten as id_kabupaten,
        tb_kabupaten.nama_kab as nama_kab,
        COUNT(tb_suspect.id_suspect) as confirm,
        COUNT(Distinct CASE WHEN tb_suspect.status = 'POSITIF' THEN id_suspect END) as positif,
        COUNT(Distinct CASE WHEN tb_suspect.status = 'MENINGGAL' THEN id_suspect END) as meninggal,
        COUNT(Distinct CASE WHEN tb_suspect.status = 'SEMBUH' THEN id_suspect END) as sembuh
        FROM tb_suspect
        LEFT JOIN tb_kabupaten ON tb_suspect.id_kabupaten = tb_kabupaten.id_kabupaten
        GROUP BY tb_kabupaten.id_kabupaten");

        return $query->result();
    }

    function rekapkabkota($id = null)
    {
        if($id === null){
            $query = $this->db->query("SELECT
            tb_kabupaten.id_kabupaten as id_kabupaten,
            tb_kabupaten.nama_kab as nama_kab,
            tb_kabupaten.logo_path as logo,
            COUNT(tb_suspect.id_suspect) as confirm,
            COUNT(Distinct CASE WHEN tb_suspect.status = 'POSITIF' THEN id_suspect END) as positif,
            COUNT(Distinct CASE WHEN tb_suspect.status = 'MENINGGAL' THEN id_suspect END) as meninggal,
            COUNT(Distinct CASE WHEN tb_suspect.status = 'SEMBUH' THEN id_suspect END) as sembuh
            FROM tb_suspect
            LEFT JOIN tb_kabupaten ON tb_suspect.id_kabupaten = tb_kabupaten.id_kabupaten
            GROUP BY tb_kabupaten.id_kabupaten");
        }
        else {
            $query = $this->db->query("SELECT
            tb_kabupaten.id_kabupaten as id_kabupaten,
            tb_kabupaten.nama_kab as nama_kab,
            tb_kabupaten.logo_path as logo,
            COUNT(tb_suspect.id_suspect) as confirm,
            COUNT(Distinct CASE WHEN tb_suspect.status = 'POSITIF' THEN id_suspect END) as positif,
            COUNT(Distinct CASE WHEN tb_suspect.status = 'MENINGGAL' THEN id_suspect END) as meninggal,
            COUNT(Distinct CASE WHEN tb_suspect.status = 'SEMBUH' THEN id_suspect END) as sembuh
            FROM tb_suspect
            LEFT JOIN tb_kabupaten ON tb_suspect.id_kabupaten = tb_kabupaten.id_kabupaten
            WHERE tb_suspect.id_kabupaten = '$id'
            GROUP BY tb_kabupaten.id_kabupaten");
        }
        return $query->result();
    }

    public function get_suspect_kabkota($id_kabupaten = 0)
    {
        $query = $this->db->query("SELECT 
        tb_suspect.id_suspect as id_suspect,
        tb_suspect.nama as nama,
        tb_suspect.gender as gender,
        tb_suspect.umur as umur,
        tb_suspect.alamat as alamat,
        tb_suspect.kontak as kontak,
        tb_suspect.id_rs as id_rs,
        tb_suspect.id_kabupaten as id_kabupaten,
        tb_suspect.is_from as is_from,
        tb_suspect.date_created as date_created,
        tb_suspect.status as status,
        tb_kabupaten.nama_kab as nama_kab,
        tb_rs_rujukan.rumah_sakit as rumah_sakit
        FROM tb_suspect 
        LEFT JOIN tb_kabupaten ON tb_suspect.id_kabupaten = tb_kabupaten.id_kabupaten
        LEFT JOIN tb_rs_rujukan ON tb_suspect.id_rs = tb_rs_rujukan.id_rs
        WHERE tb_suspect.id_kabupaten = '$id_kabupaten' ");
        
        return $query->result();
    }

    function suspect_kabkota()
    {
        $query = $this->db->query("SELECT * FROM v_jumlah_suspect ORDER BY jumlah_suspect DESC ");

        return $query->result();
    }

    function rekap_suspect()
    {
        $query = $this->db->query("SELECT 
        COUNT(Distinct tb_suspect.id_suspect) as Confirm,
        COUNT(Distinct CASE WHEN tb_suspect.status = 'POSITIF' THEN tb_suspect.id_suspect END) as Positif,
        COUNT(Distinct CASE WHEN tb_suspect.status = 'SEMBUH' THEN tb_suspect.id_suspect END) as Sembuh,
        COUNT(Distinct CASE WHEN tb_suspect.status = 'MENINGGAL' THEN tb_suspect.id_suspect END) as Meninggal
        FROM tb_suspect ");
    
        return $query->result();
    }
    
    function prosentase_suspect()
    {
        $query = $this->db->query("SELECT 
        v_rekap_suspect.Positif / v_rekap_suspect.Confirm * 100 as p_positif,
        v_rekap_suspect.Sembuh / v_rekap_suspect.Confirm * 100 as p_sembuh,
        v_rekap_suspect.Meninggal / v_rekap_suspect.Confirm * 100 as p_meninggal
        FROM v_rekap_suspect ");

        return $query->result();
    }

    public function get_count_suspect($id_kabupaten)
    {
        $query = $this->db->query("SELECT 
        COUNT(Distinct tb_suspect.id_suspect) as confirm,
        COUNT(Distinct CASE WHEN tb_suspect.status = 'POSITIF' THEN tb_suspect.id_suspect END) as positif,
        COUNT(Distinct CASE WHEN tb_suspect.status = 'SEMBUH' THEN tb_suspect.id_suspect END) as sembuh,
        COUNT(Distinct CASE WHEN tb_suspect.status = 'MENINGGAL' THEN tb_suspect.id_suspect END) as meninggal
        FROM tb_suspect 
        WHERE tb_suspect.id_kabupaten = $id_kabupaten ");
    
        return $query->row_array();
    }

    function get_porsentase_suspect($id_kabupaten)
    {
        $query = $this->db->query("SELECT
        positif / jumlah_suspect * 100 as p_positif,
        sembuh / jumlah_suspect * 100 as p_sembuh,
        meninggal / jumlah_suspect * 100 as p_meninggal
        FROM v_jumlah_suspect 
        WHERE id_kabupaten = '$id_kabupaten' ");
        return $query->row_array();
    }
}