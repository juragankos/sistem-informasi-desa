<?php

use App\Libraries\Paging;
use App\Models\BaseModel as Model;

class Plan_line_model extends Model
{
    public function autocomplete()
    {
        $sql   = 'SELECT nama FROM line';
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

            return " AND (nama LIKE '{$kw}')";
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

        $sql = 'SELECT COUNT(id) AS id FROM line WHERE tipe = 0 ';
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

        $sql = 'SELECT * FROM line WHERE tipe = 0 ';

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
        $data        = $_POST;
        $lokasi_file = $_FILES['simbol']['tmp_name'];
        $tipe_file   = $_FILES['simbol']['type'];
        $nama_file   = $_FILES['simbol']['name'];
        if (! empty($lokasi_file)) {
            if ($tipe_file === 'image/png' || $tipe_file === 'image/gif') {
                UploadSimbol($nama_file);
                $data['simbol'] = $nama_file;
                $outp           = $this->db->insert('line', $data);
            }
        } else {
            unset($data['simbol']);
            $outp = $this->db->insert('line', $data);
        }
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update($id = 0)
    {
        $data        = $_POST;
        $lokasi_file = $_FILES['simbol']['tmp_name'];
        $tipe_file   = $_FILES['simbol']['type'];
        $nama_file   = $_FILES['simbol']['name'];
        if (! empty($lokasi_file)) {
            if ($tipe_file === 'image/png' || $tipe_file === 'image/gif') {
                UploadSimbol($nama_file);
                $data['simbol'] = $nama_file;
                $this->db->where('id', $id);
                $outp = $this->db->update('line', $data);
            }
            $_SESSION['success'] = 1;
        }

        unset($data['simbol']);
        $this->db->where('id', $id);
        $outp = $this->db->update('line', $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete($id = '')
    {
        $sql  = 'DELETE FROM line WHERE id=?';
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
                $sql  = 'DELETE FROM line WHERE id=?';
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

    public function list_sub_line($line = 1)
    {
        $sql = 'SELECT * FROM line WHERE parrent = ? AND tipe = 2 ';

        $query = $this->db->query($sql, $line);
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

    public function insert_sub_line($parrent = 0)
    {
        $lokasi_file = $_FILES['simbol']['tmp_name'];
        $tipe_file   = $_FILES['simbol']['type'];
        $nama_file   = $_FILES['simbol']['name'];
        if (! empty($lokasi_file)) {
            if ($tipe_file === 'image/png' || $tipe_file === 'image/gif') {
                UploadSimbol($nama_file);
                $data            = $_POST;
                $data['simbol']  = $nama_file;
                $data['parrent'] = $parrent;
                $data['tipe']    = 2;
                $outp            = $this->db->insert('line', $data);
                if ($outp) {
                    $_SESSION['success'] = 1;
                }
            } else {
                $_SESSION['success'] = -1;
            }
        } else {
            $data = $_POST;
            unset($data['simbol']);
            $data['parrent'] = $parrent;
            $data['tipe']    = 2;
            $outp            = $this->db->insert('line', $data);
        }
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update_sub_line($id = 0)
    {
        $data        = $_POST;
        $lokasi_file = $_FILES['simbol']['tmp_name'];
        $tipe_file   = $_FILES['simbol']['type'];
        $nama_file   = $_FILES['simbol']['name'];
        if (! empty($lokasi_file)) {
            if ($tipe_file === 'image/png' || $tipe_file === 'image/gif') {
                UploadSimbol($nama_file);
                $data['simbol'] = $nama_file;
                $this->db->where('id', $id);
                $outp = $this->db->update('line', $data);
            }
            $_SESSION['success'] = 1;
        } else {
            unset($data['simbol']);
            $this->db->where('id', $id);
            $outp = $this->db->update('line', $data);
        }
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_sub_line($id = '')
    {
        $sql  = 'DELETE FROM line WHERE id=?';
        $outp = $this->db->query($sql, [$id]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_all_sub_line()
    {
        $id_cb = $_POST['id_cb'];

        if (is_countable($id_cb) ? count($id_cb) : 0) {
            foreach ($id_cb as $id) {
                $sql  = 'DELETE FROM line WHERE id=?';
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

    public function line_lock($id = '', $val = 0)
    {
        $sql  = 'UPDATE line SET enabled=? WHERE id=?';
        $outp = $this->db->query($sql, [$val, $id]);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function get_line($id = 0)
    {
        $sql   = 'SELECT * FROM line WHERE id=?';
        $query = $this->db->query($sql, $id);

        return $query->row_array();
    }

    public function line_show()
    {
        $sql   = 'SELECT * FROM line WHERE enabled=?';
        $query = $this->db->query($sql, 1);

        return $query->result_array();
    }

    public function list_line_atas()
    {
        $sql = 'SELECT m.* FROM line m WHERE m.parrent = 1 AND m.enabled = 1 AND m.tipe = 1';

        $query = $this->db->query($sql);
        $data  = $query->result_array();
        $url   = site_url('first');
        $i     = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['line'] = "<li><a href='{$url}/" . $data[$i]['simbol'] . "'>" . $data[$i]['nama'] . '</a>';

            $sql2  = 'SELECT s.* FROM line s WHERE s.parrent = ? AND s.enabled = 1 AND s.tipe = 3';
            $query = $this->db->query($sql2, $data[$i]['id']);
            $data2 = $query->result_array();

            if ($data2) {
                $data[$i]['line'] .= '<ul>';
                $j = 0;

                while ($j < (is_countable($data2) ? count($data2) : 0)) {
                    $data[$i]['line'] = $data[$i]['line'] . "<li><a href='{$url}/" . $data2[$j]['simbol'] . "'>" . $data2[$j]['nama'] . '</a></li>';
                    $j++;
                }
                $data[$i]['line'] .= '</ul>';
            }
            $data[$i]['line'] .= '</li>';
            $i++;
        }

        return $data;
    }

    public function list_line_kiri()
    {
        $sql = 'SELECT m.* FROM line m WHERE m.parrent = 1 AND m.enabled = 1 AND m.tipe = 2';

        $query = $this->db->query($sql);
        $data  = $query->result_array();
        $url   = site_url('first');
        $i     = 0;

        while ($i < (is_countable($data) ? count($data) : 0)) {
            $data[$i]['line'] = "<li><a href='{$url}/" . $data[$i]['simbol'] . "'>" . $data[$i]['nama'] . '</a>';

            $sql2  = 'SELECT s.* FROM line s WHERE s.parrent = ? AND s.enabled = 1 AND s.tipe = 3';
            $query = $this->db->query($sql2, $data[$i]['id']);
            $data2 = $query->result_array();

            if ($data2) {
                $data[$i]['line'] .= '<ul>';
                $j = 0;

                while ($j < (is_countable($data2) ? count($data2) : 0)) {
                    $data[$i]['line'] = $data[$i]['line'] . "<li><a href='{$url}/" . $data2[$j]['simbol'] . "'>" . $data2[$j]['nama'] . '</a></li>';
                    $j++;
                }
                $data[$i]['line'] .= '</ul>';
            }
            $data[$i]['line'] .= '</li>';
            $i++;
        }

        return $data;
    }
}
