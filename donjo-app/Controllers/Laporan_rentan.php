<?php

use App\Controllers\BaseController;
use App\Models\Config;

class Laporan_rentan extends BaseController
{
    public function __construct()
    {
        $grup = $this->user_model->sesi_grup($_SESSION['sesi']);
        if ($grup !== '1' && $grup !== '2' && $grup !== '3') {
            redirect('siteman');
        }

        $_SESSION['success']  = 0;
        $_SESSION['per_page'] = 20;
        $_SESSION['cari']     = '';
    }

    public function clear()
    {
        unset($_SESSION['cari'], $_SESSION['filter'], $_SESSION['dusun'], $_SESSION['rw'], $_SESSION['rt']);

        redirect('laporan_rentan');
    }

    public function index()
    {
        $config = new Config();

        if (isset($_SESSION['dusun'])) {
            $data['dusun'] = $_SESSION['dusun'];
        } else {
            $data['dusun'] = '';
        }

        $data['list_dusun'] = $this->laporan_bulanan_model->list_dusun();
        $data['config']     = $config->get_data(true);

        $data['main'] = $this->laporan_bulanan_model->list_data();

        $nav['act'] = 2;
        $header     = $this->header_model->get_data();
        view('header', $header);
        view('statistik/nav', $nav);
        view('laporan/kelompok', $data);
        view('footer');
    }

    public function cetak()
    {
        $config = new Config();

        $data['config'] = $config->get_data(true);
        $data['main']   = $this->laporan_bulanan_model->list_data();
        view('laporan/kelompok_print', $data);
    }

    public function excel()
    {
        $config = new Config();

        $data['config'] = $config->get_data(true);
        $data['main']   = $this->laporan_bulanan_model->list_data();
        view('laporan/kelompok_excel', $data);
    }

    public function dusun()
    {
        $dusun = $this->input->post('dusun');
        if ($dusun !== '') {
            $_SESSION['dusun'] = $dusun;
        } else {
            unset($_SESSION['dusun']);
        }
        redirect('laporan_rentan');
    }
}
