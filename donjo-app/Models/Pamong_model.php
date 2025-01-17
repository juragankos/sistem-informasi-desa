<?php

use App\Models\BaseModel as Model;

class Pamong_model extends Model
{
    public function list_data()
    {
        $sql = 'SELECT u.* FROM tweb_desa_pamong u WHERE 1';
        $sql .= $this->search_sql();
        $sql .= $this->filter_sql();

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $i + 1;
            $i++;
        }

        return $data;
    }

    public function autocomplete()
    {
        $sql = 'SELECT pamong_nama FROM tweb_desa_pamong
					UNION SELECT pamong_nip FROM tweb_desa_pamong
					UNION SELECT pamong_nik FROM tweb_desa_pamong';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $outp .= ",'" . $data[$i]['pamong_nama'] . "'";
            $i++;
        }
        $outp = substr($outp, 1);

        return '[' . $outp . ']';
    }

    public function search_sql()
    {
        if (isset($_SESSION['cari'])) {
            $cari = $_SESSION['cari'];
            $kw   = $this->db->escape_like_str($cari);
            $kw   = '%' . $kw . '%';

            return " AND (u.pamong_nama LIKE '{$kw}' OR u.pamong_nip LIKE '{$kw}' OR u.pamong_nik LIKE '{$kw}')";
        }
    }

    public function filter_sql()
    {
        if (isset($_SESSION['filter'])) {
            $kf = $_SESSION['filter'];

            return " AND u.pamong_status = {$kf}";
        }
    }

    public function get_data($id = 0)
    {
        $sql   = 'SELECT * FROM tweb_desa_pamong WHERE pamong_id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function insert()
    {
        $nip     = penetration($this->input->post('pamong_nip'));
        $nama    = penetration($this->input->post('pamong_nama'));
        $nik     = penetration($this->input->post('pamong_nik'));
        $jabatan = penetration($this->input->post('jabatan'));
        $status  = penetration($this->input->post('pamong_status'));

        $sql = 'INSERT INTO tweb_desa_pamong (pamong_nama,pamong_nip,pamong_nik,jabatan,pamong_status,pamong_tgl_terdaftar)
				VALUES (?,?,?,?,?,NOW())';

        $outp = $this->db->query($sql, [$nama, $nip, $nik, $jabatan, $status]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update($id = 0)
    {
        $nip     = $this->input->post('pamong_nip');
        $nama    = penetration($this->input->post('pamong_nama'));
        $nik     = $this->input->post('pamong_nik');
        $jabatan = penetration($this->input->post('jabatan'));
        $status  = $this->input->post('pamong_status');

        $sql  = 'UPDATE tweb_desa_pamong SET pamong_nama=?,pamong_nip=?,pamong_nik=?,jabatan=?,pamong_status=? WHERE pamong_id=?';
        $outp = $this->db->query($sql, [$nama, $nip, $nik, $jabatan, $status, $id]);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete($id = '')
    {
        $sql  = 'DELETE FROM tweb_desa_pamong WHERE pamong_id=?';
        $outp = $this->db->query($sql, [$id]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_all()
    {
        $id_cb = $_POST['id_cb'];

        if (is_countable($id_cb) ? count($id_cb) : 0) {
            foreach ($id_cb as $id) {
                $sql  = 'DELETE FROM tweb_desa_pamong WHERE pamong_id=?';
                $outp = $this->db->query($sql, [$id]);
            }
        } else {
            $outp = false;
        }

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }
}
