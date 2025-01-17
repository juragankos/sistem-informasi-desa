<?php

use App\Libraries\Paging;
use App\Models\BaseModel as Model;

class Plan_garis_model extends Model
{
    public function autocomplete()
    {
        $sql   = 'SELECT nama FROM garis';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $outp .= ',"' . $data[$i]['nama'] . '"';
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

            return " AND l.nama LIKE '{$kw}'";
        }
    }

    public function filter_sql()
    {
        if (isset($_SESSION['filter'])) {
            $kf = $_SESSION['filter'];

            return " AND l.enabled = {$kf}";
        }
    }

    public function line_sql()
    {
        if (isset($_SESSION['line'])) {
            $kf = $_SESSION['line'];

            return " AND p.id = {$kf}";
        }
    }

    public function subline_sql()
    {
        if (isset($_SESSION['subline'])) {
            $kf = $_SESSION['subline'];

            return " AND m.id = {$kf}";
        }
    }

    public function paging($p = 1, $o = 0)
    {
        $paging = new Paging();

        $sql = 'SELECT COUNT(l.id) AS id FROM garis l LEFT JOIN line p ON l.ref_line = p.id LEFT JOIN line m ON p.parrent = m.id WHERE 1 ';
        $sql .= $this->search_sql();
        $sql .= $this->filter_sql();
        $sql .= $this->line_sql();
        $sql .= $this->subline_sql();
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
            case 1: $order_sql = ' ORDER BY nama';
                break;

            case 2: $order_sql = ' ORDER BY nama DESC';
                break;

            case 3: $order_sql = ' ORDER BY enabled';
                break;

            case 4: $order_sql = ' ORDER BY enabled DESC';
                break;

            default:$order_sql = ' ORDER BY id';
        }
        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $sql = 'SELECT l.*,p.nama AS kategori,m.nama AS jenis,p.simbol AS simbol FROM garis l LEFT JOIN line p ON l.ref_line = p.id LEFT JOIN line m ON p.parrent = m.id WHERE 1 ';

        $sql .= $this->search_sql();
        $sql .= $this->filter_sql();
        $sql .= $this->line_sql();
        $sql .= $this->subline_sql();
        $sql .= $order_sql;
        $sql .= $paging_sql;

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;
        $j = $offset;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $j + 1;

            if ($data[$i]['enabled'] === 1) {
                $data[$i]['aktif'] = 'Yes';
            } else {
                $data[$i]['aktif'] = 'No';
            }

            $i++;
            $j++;
        }

        return $data;
    }

    public function insert()
    {
        $data       = $_POST;
        $garis_file = $_FILES['foto']['tmp_name'];
        $tipe_file  = $_FILES['foto']['type'];
        $nama_file  = $_FILES['foto']['name'];
        if (! empty($garis_file)) {
            if ($tipe_file === 'image/jpg' || $tipe_file === 'image/jpeg') {
                Uploadgaris($nama_file);
                $data['foto'] = $nama_file;
                $outp         = $this->db->insert('garis', $data);
            }
        } else {
            unset($data['foto']);
            $outp = $this->db->insert('garis', $data);
        }

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update($id = 0)
    {
        $data       = $_POST;
        $garis_file = $_FILES['foto']['tmp_name'];
        $tipe_file  = $_FILES['foto']['type'];
        $nama_file  = $_FILES['foto']['name'];
        if (! empty($garis_file)) {
            if ($tipe_file === 'image/jpg' || $tipe_file === 'image/jpeg') {
                Uploadgaris($nama_file);
                $data['foto'] = $nama_file;
                $this->db->where('id', $id);
                $outp = $this->db->update('garis', $data);
            }
        } else {
            unset($data['foto']);
            $this->db->where('id', $id);
            $outp = $this->db->update('garis', $data);
        }
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete($id = '')
    {
        $sql  = 'DELETE FROM garis WHERE id=?';
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
                $sql  = 'DELETE FROM garis WHERE id=?';
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

    public function list_line()
    {
        $sql = 'SELECT * FROM line WHERE tipe = 2 ';

        if (isset($_SESSION['subline'])) {
            $kf = $_SESSION['subline'];
            $sql .= " AND parrent = {$kf}";
        }

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function list_subline()
    {
        $sql = 'SELECT * FROM line WHERE tipe = 0 ';

        if (isset($_SESSION['line'])) {
            $sqlx  = 'SELECT * FROM line WHERE id = ?';
            $query = $this->db->query($sqlx, $_SESSION['line']);
            $temp  = $query->row_array();

            $kf = $temp['parrent'];
        }

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function garis_lock($id = '', $val = 0)
    {
        $sql  = 'UPDATE garis SET enabled=? WHERE id=?';
        $outp = $this->db->query($sql, [$val, $id]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function get_garis($id = 0)
    {
        $sql   = 'SELECT * FROM garis WHERE id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function update_position($id = 0)
    {
        $data = $_POST;
        $this->db->where('id', $id);
        $outp = $this->db->update('garis', $data);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function list_dusun()
    {
        $sql   = "SELECT * FROM tweb_wil_clusterdesa WHERE rt = '0' AND rw = '0' ";
        $query = $this->db->query($sql);

        return $query->result_array();
    }
}
