<?php

use App\Libraries\Paging;
use App\Models\BaseModel as Model;

class Kelompok_master_model extends Model
{
    public function autocomplete()
    {
        $sql   = 'SELECT kelompok FROM kelompok_master';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $outp .= ',"' . $data[$i]['kelompok'] . '"';
            $i++;
        }
        $outp = strtolower(substr($outp, 1));

        return '[' . $outp . ']';
    }

    public function search_sql()
    {
        if (isset($_SESSION['cari'])) {
            $cari = $_SESSION['cari'];
            $kw   = $this->db->escape_like_str($cari);
            $kw   = '%' . $kw . '%';

            return " AND (u.kelompok LIKE '{$kw}' OR u.kelompok LIKE '{$kw}')";
        }
    }

    public function filter_sql()
    {
        if (isset($_SESSION['filter'])) {
            $kf = $_SESSION['filter'];

            return " AND u.id = {$kf}";
        }
    }

    public function state_sql()
    {
        if (isset($_SESSION['state'])) {
            $kf = $_SESSION['state'];

            return " AND u.lock = {$kf}";
        }
    }

    public function paging($p = 1, $o = 0)
    {
        $paging = new Paging();

        $sql = 'SELECT COUNT(id) AS id FROM kelompok_master u WHERE 1';
        $sql .= $this->search_sql();
        $sql .= $this->filter_sql();
        $sql .= $this->state_sql();
        $query    = $this->db->query($sql);
        $row      = $query->row_array();
        $jml_data = $row['id'];

        $cfg['page']     = $p;
        $cfg['per_page'] = $_SESSION['per_page'];
        $cfg['num_rows'] = $jml_data;

        $paging->init($cfg);

        return $paging;
    }

    public function list_data($o = 0, $offset = 0, $limit = 500)
    {
        switch ($o) {
            case 1: $order_sql = ' ORDER BY u.kelompok';
                break;

            case 2: $order_sql = ' ORDER BY u.kelompok DESC';
                break;

            case 3: $order_sql = ' ORDER BY u.kelompok';
                break;

            case 4: $order_sql = ' ORDER BY u.kelompok DESC';
                break;

            case 5: $order_sql = ' ORDER BY g.kelompok';
                break;

            case 6: $order_sql = ' ORDER BY g.kelompok DESC';
                break;

            default:$order_sql = ' ORDER BY u.kelompok';
        }

        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $sql = 'SELECT u.* FROM kelompok_master u WHERE 1 ';

        $sql .= $this->search_sql();

        $sql .= $order_sql;
        $sql .= $paging_sql;

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;
        $j = $offset;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $j + 1;
            $i++;
            $j++;
        }

        return $data;
    }

    public function insert()
    {
        $data = $_POST;
        $outp = $this->db->insert('kelompok_master', $data);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update($id = 0)
    {
        $data = $_POST;
        $this->db->where('id', $id);
        $outp = $this->db->update('kelompok_master', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete($id = '')
    {
        $sql  = 'DELETE FROM kelompok_master WHERE id=?';
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
                $sql  = 'DELETE FROM kelompok_master WHERE id=?';
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

    public function get_kelompok_master($id = 0)
    {
        $sql   = 'SELECT * FROM kelompok_master WHERE id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function list_subjek()
    {
        $sql   = 'SELECT * FROM kelompok_ref_subjek';
        $query = $this->db->query($sql);

        return $query->result_array();
    }
}
