<?php

use App\Libraries\Paging;
use App\Models\BaseModel as Model;

class Web_kategori_model extends Model
{
    public function autocomplete()
    {
        $sql   = 'SELECT kategori FROM kategori WHERE parrent =0';
        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $outp .= ',"' . $data[$i]['kategori'] . '"';
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

            return " AND (kategori LIKE '{$kw}')";
        }
    }

    public function filter_sql()
    {
        if (isset($_SESSION['filter'])) {
            $kf = $_SESSION['filter'];

            return " AND enabled = {$kf}";
        }
    }

    public function paging($p = 1, $o = 0)
    {
        $paging = new Paging();

        $sql = 'SELECT COUNT(id) AS id FROM kategori WHERE parrent = 0';
        $sql .= $this->search_sql();
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
            case 1: $order_sql = ' ORDER BY kategori';
                break;

            case 2: $order_sql = ' ORDER BY kategori DESC';
                break;

            case 3: $order_sql = ' ORDER BY enabled';
                break;

            case 4: $order_sql = ' ORDER BY enabled DESC';
                break;

            default:$order_sql = ' ORDER BY id';
        }
        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;
        $sql        = 'SELECT k.*,k.kategori AS kategori FROM kategori k WHERE parrent = 0';

        $sql .= $this->search_sql();
        $sql .= $this->filter_sql();
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
        $data            = $_POST;
        $data['enabled'] = 1;
        $outp            = $this->db->insert('kategori', $data);
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
        $outp = $this->db->update('kategori', $data);
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
                $sql  = 'DELETE FROM kategori WHERE id=?';
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

    public function list_sub_kategori($kategori = 1)
    {
        $sql = 'SELECT * FROM kategori WHERE parrent = ? ';

        $query = $this->db->query($sql, $kategori);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $i + 1;

            if ($data[$i]['enabled'] === 1) {
                $data[$i]['aktif'] = 'Yes';
            } else {
                $data[$i]['aktif'] = 'No';
            }

            $i++;
        }

        return $data;
    }

    public function list_link()
    {
        $sql = "SELECT a.* FROM artikel a INNER JOIN kategori k ON a.id_kategori=k.id WHERE tipe ='2'";

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no'] = $i + 1;
            $i++;
        }

        return $data;
    }

    public function list_kategori()
    {
        $sql = 'SELECT k.id,k.kategori AS kategori FROM kategori k WHERE 1';

        $query = $this->db->query($sql);
        $data  = $query->result_array();

        $i = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['no']    = $i + 1;
            $data[$i]['judul'] = $data[$i]['kategori'];
            $i++;
        }

        return $data;
    }

    public function insert_sub_kategori($kategori = 0)
    {
        $data = $_POST;

        $data['parrent'] = $kategori;
        $data['enabled'] = 1;
        $outp            = $this->db->insert('kategori', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update_sub_kategori($id = 0)
    {
        $data = $_POST;

        $this->db->where('id', $id);
        $outp = $this->db->update('kategori', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_all_sub_kategori()
    {
        $id_cb = $_POST['id_cb'];

        if (is_countable($id_cb) ? count($id_cb) : 0) {
            foreach ($id_cb as $id) {
                $sql  = 'DELETE FROM kategori WHERE id=?';
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

    public function kategori_lock($id = '', $val = 0)
    {
        $sql  = 'UPDATE kategori SET enabled=? WHERE id=?';
        $outp = $this->db->query($sql, [$val, $id]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function kategori_show()
    {
        $sql   = 'SELECT * FROM kategori WHERE enabled=?';
        $query = $this->db->query($sql, 1);

        return $query->result_array();
    }

    public function list_kategori_atas()
    {
        $sql = 'SELECT m.* FROM kategori m WHERE m.parrent = 1 AND m.enabled = 1 AND m.tipe = 1';

        $query = $this->db->query($sql);
        $data  = $query->result_array();
        $url   = site_url('first');
        $i     = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['kategori'] = "<li><a href='{$url}/" . $data[$i]['link'] . "'>" . $data[$i]['kategori'] . '</a>';

            $sql2  = 'SELECT s.* FROM kategori s WHERE s.parrent = ? AND s.enabled = 1 AND s.tipe = 3';
            $query = $this->db->query($sql2, $data[$i]['id']);
            $data2 = $query->result_array();

            if ($data2) {
                $data[$i]['kategori'] .= '<ul>';
                $j = 0;

                while ($j < (is_countable($data2) ? count($data2) : 0)) {
                    $data[$i]['kategori'] = $data[$i]['kategori'] . "<li><a href='{$url}/" . $data2[$j]['link'] . "'>" . $data2[$j]['kategori'] . '</a></li>';
                    $j++;
                }
                $data[$i]['kategori'] .= '</ul>';
            }
            $data[$i]['kategori'] .= '</li>';
            $i++;
        }

        return $data;
    }

    public function list_kategori_kiri()
    {
        $sql = 'SELECT m.* FROM kategori m WHERE m.parrent = 1 AND m.enabled = 1 AND m.tipe = 2';

        $query = $this->db->query($sql);
        $data  = $query->result_array();
        $url   = site_url('first');
        $i     = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['kategori'] = "<li><a href='{$url}/" . $data[$i]['link'] . "'>" . $data[$i]['kategori'] . '</a>';

            $sql2  = 'SELECT s.* FROM kategori s WHERE s.parrent = ? AND s.enabled = 1 AND s.tipe = 3';
            $query = $this->db->query($sql2, $data[$i]['id']);
            $data2 = $query->result_array();

            if ($data2) {
                $data[$i]['kategori'] .= '<ul>';
                $j = 0;

                while ($j < (is_countable($data2) ? count($data2) : 0)) {
                    $data[$i]['kategori'] = $data[$i]['kategori'] . "<li><a href='{$url}/" . $data2[$j]['link'] . "'>" . $data2[$j]['kategori'] . '</a></li>';
                    $j++;
                }
                $data[$i]['kategori'] .= '</ul>';
            }
            $data[$i]['kategori'] .= '</li>';
            $i++;
        }

        return $data;
    }
}
