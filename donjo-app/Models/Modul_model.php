<?php

use App\Models\BaseModel as Model;

class Modul_model extends Model
{
    public function list_data()
    {
        $sql = 'SELECT u.* FROM setting_modul u WHERE hidden = 0';
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
        $sql = 'SELECT modul FROM setting_modul WHERE hidden = 0
					UNION SELECT url FROM setting_modul WHERE  hidden = 0';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $outp .= ",'" . $data[$i]['modul'] . "'";
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

            return " AND (u.modul LIKE '{$kw}' OR u.url LIKE '{$kw}')";
        }
    }

    public function filter_sql()
    {
        if (isset($_SESSION['filter'])) {
            $kf = $_SESSION['filter'];

            return " AND u.aktif = {$kf}";
        }
    }

    public function get_data($id = 0)
    {
        $sql   = 'SELECT * FROM setting_modul WHERE id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function update($id = 0)
    {
        $data = $_POST;
        $this->db->where('id', $id);
        $outp = $this->db->update('setting_modul', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete($id = '')
    {
        $sql  = 'DELETE FROM setting_modul WHERE id=?';
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
                $sql  = 'DELETE FROM setting_modul WHERE id=?';
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
