<?php

use App\Controllers\BaseController;

class Penduduk_log extends BaseController
{
    public function __construct()
    {
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup === '1') {
            return;
        }
        if ($grup === '2') {
            return;
        }
        if ($grup === '3') {
            return;
        }
        redirect('siteman');
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter'], $_SESSION['sex'], $_SESSION['dusun'], $_SESSION['rw'], $_SESSION['rt'], $_SESSION['agama'], $_SESSION['umur_min'], $_SESSION['umur_max'], $_SESSION['pekerjaan_id'], $_SESSION['status'], $_SESSION['pendidikan_id'], $_SESSION['status_penduduk']);

        $_SESSION['per_page'] = 200;
        $_SESSION['log']      = 1;
        redirect('penduduk_log');
    }

    public function index($p = 1, $o = 0)
    {
        $_SESSION['log'] = 1;
        $data['p']       = $p;
        $data['o']       = $o;

        if (isset($_SESSION['cari'])) {
            $data['cari'] = $_SESSION['cari'];
        } else {
            $data['cari'] = '';
        }

        if (isset($_SESSION['filter'])) {
            $data['filter'] = $_SESSION['filter'];
        } else {
            $data['filter'] = '';
        }
        if (isset($_SESSION['sex'])) {
            $data['sex'] = $_SESSION['sex'];
        } else {
            $data['sex'] = '';
        }

        if (isset($_SESSION['dusun'])) {
            $data['dusun']   = $_SESSION['dusun'];
            $data['list_rw'] = $this->penduduk_model->list_rw($data['dusun']);

            if (isset($_SESSION['rw'])) {
                $data['rw']      = $_SESSION['rw'];
                $data['list_rt'] = $this->penduduk_model->list_rt($data['dusun'], $data['rw']);

                if (isset($_SESSION['rt'])) {
                    $data['rt'] = $_SESSION['rt'];
                } else {
                    $data['rt'] = '';
                }
            } else {
                $data['rw'] = '';
            }
        } else {
            $data['dusun'] = '';
            $data['rw']    = '';
            $data['rt']    = '';
        }
        if (isset($_SESSION['agama'])) {
            $data['agama'] = $_SESSION['agama'];
        } else {
            $data['agama'] = '';
        }
        if (isset($_SESSION['pekerjaan_id'])) {
            $data['pekerjaan_id'] = $_SESSION['pekerjaan_id'];
        } else {
            $data['pekerjaan_id'] = '';
        }
        if (isset($_SESSION['status'])) {
            $data['status'] = $_SESSION['status'];
        } else {
            $data['status'] = '';
        }
        if (isset($_SESSION['pendidikan_id'])) {
            $data['pendidikan_id'] = $_SESSION['pendidikan_id'];
        } else {
            $data['pendidikan_id'] = '';
        }
        if (isset($_SESSION['status_penduduk'])) {
            $data['status_penduduk'] = $_SESSION['status_penduduk'];
        } else {
            $data['status_penduduk'] = '';
        }

        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']     = $this->penduduk_model->paging($p, $o, 1);
        $data['main']       = $this->penduduk_model->list_data($o, $data['paging']->offset, $data['paging']->per_page, 1);
        $data['keyword']    = $this->penduduk_model->autocomplete();
        $data['list_agama'] = $this->penduduk_model->list_agama();
        $data['list_dusun'] = $this->penduduk_model->list_dusun();

        $header     = $this->header_model->get_data();
        $nav['act'] = 2;

        view('header', $header);
        view('sid/nav', $nav);
        view('sid/kependudukan/penduduk_log', $data);
        view('footer');
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('penduduk_log');
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== '') {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('penduduk_log');
    }

    public function sex()
    {
        $sex = $this->input->post('sex');
        if ($sex !== '') {
            $_SESSION['sex'] = $sex;
        } else {
            unset($_SESSION['sex']);
        }
        redirect('penduduk_log');
    }

    public function agama()
    {
        $agama = $this->input->post('agama');
        if ($agama !== '') {
            $_SESSION['agama'] = $agama;
        } else {
            unset($_SESSION['agama']);
        }
        redirect('penduduk_log');
    }

    public function dusun()
    {
        $dusun = $this->input->post('dusun');
        if ($dusun !== '') {
            $_SESSION['dusun'] = $dusun;
        } else {
            unset($_SESSION['dusun']);
        }
        redirect('penduduk_log');
    }

    public function rw()
    {
        $rw = $this->input->post('rw');
        if ($rw !== '') {
            $_SESSION['rw'] = $rw;
        } else {
            unset($_SESSION['rw']);
        }
        redirect('penduduk_log');
    }

    public function rt()
    {
        $rt = $this->input->post('rt');
        if ($rt !== '') {
            $_SESSION['rt'] = $rt;
        } else {
            unset($_SESSION['rt']);
        }
        redirect('penduduk_log');
    }

    public function edit_status_dasar($p = 1, $o = 0, $id = 0)
    {
        $data['nik']         = $this->penduduk_model->get_penduduk($id);
        $data['form_action'] = site_url("penduduk_log/update_status_dasar/{$p}/{$o}/{$id}");
        view('sid/kependudukan/ajax_edit_status_dasar', $data);
    }

    public function update_status_dasar($p = 1, $o = 0, $id = '')
    {
        $this->penduduk_model->update_status_dasar($id);
        redirect("penduduk_log/index/{$p}/{$o}");
    }

    public function cetak($o = 0)
    {
        $data['main'] = $this->penduduk_model->list_data($o, 0, 10000);
        view('sid/kependudukan/penduduk_print', $data);
    }

    public function delete_all($p = 1, $o = 0)
    {
        $this->penduduk_model->delete_all();
        redirect("penduduk_log/index/{$p}/{$o}");
    }
}
