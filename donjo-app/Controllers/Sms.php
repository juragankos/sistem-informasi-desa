<?php

use App\Controllers\BaseController;

class Sms extends BaseController
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
        unset($_SESSION['cari'], $_SESSION['filter'], $_SESSION['cari1'], $_SESSION['sex1'], $_SESSION['dusun1'], $_SESSION['rw1'], $_SESSION['rt1'], $_SESSION['agama1'], $_SESSION['pekerjaan1'], $_SESSION['status1'], $_SESSION['pendidikan1'], $_SESSION['status_penduduk1'], $_SESSION['TextDecoded1'], $_SESSION['grup1']);

        redirect('sms');
    }

    public function index($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

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
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']  = $this->sms_model->paging($p, $o);
        $data['main']    = $this->sms_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->sms_model->autocomplete();
        $header          = $this->header_model->get_data();
        $menu['act']     = '0';

        view('header', $header);
        view('sms/nav', $menu);
        view('sms/manajemen_sms_table', $data);
        view('footer');
        unset($_SESSION['cari'], $_SESSION['filter'], $_SESSION['cari1'], $_SESSION['sex1'], $_SESSION['dusun1'], $_SESSION['rw1'], $_SESSION['rt1'], $_SESSION['agama1'], $_SESSION['pekerjaan1'], $_SESSION['status1'], $_SESSION['pendidikan1'], $_SESSION['status_penduduk1'], $_SESSION['TextDecoded1'], $_SESSION['grup1']);
    }

    public function setting($p = 1, $o = 0)
    {
        $data['main']        = $this->sms_model->get_autoreply();
        $data['form_action'] = site_url('sms/insert_autoreply');
        $header              = $this->header_model->get_data();
        $menu['act']         = '1';

        view('header', $header);
        view('sms/nav', $menu);
        view('sms/setting', $data);
        view('footer');
    }

    public function insert_autoreply()
    {
        $this->sms_model->insert_autoreply();
        redirect('sms/setting');
    }

    public function polling($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_SESSION['cari_polling'])) {
            $data['cari_polling'] = $_SESSION['cari_polling'];
        } else {
            $data['cari_polling'] = '';
        }

        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']  = $this->sms_model->paging_polling($p, $o);
        $data['main']    = $this->sms_model->list_data_polling($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->sms_model->autocomplete();
        $header          = $this->header_model->get_data();
        $menu['act']     = '3';

        view('header', $header);
        view('sms/nav', $menu);
        view('sms/polling', $data);
        view('footer');
    }

    public function outbox($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

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
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']  = $this->sms_model->paging_terkirim($p, $o);
        $data['main']    = $this->sms_model->list_data_terkirim($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->sms_model->autocomplete();
        $header          = $this->header_model->get_data();
        $menu['act']     = '0';

        view('header', $header);
        view('sms/nav', $menu);
        view('sms/create_sms', $data);
        view('footer');
        unset($_SESSION['cari'], $_SESSION['filter'], $_SESSION['cari1'], $_SESSION['sex1'], $_SESSION['dusun1'], $_SESSION['rw1'], $_SESSION['rt1'], $_SESSION['agama1'], $_SESSION['pekerjaan1'], $_SESSION['status1'], $_SESSION['pendidikan1'], $_SESSION['status_penduduk1'], $_SESSION['TextDecoded1'], $_SESSION['grup1']);
    }

    public function sentitem($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

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
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']  = $this->sms_model->paging_terkirim($p, $o);
        $data['main']    = $this->sms_model->list_data_terkirim($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->sms_model->autocomplete();
        $header          = $this->header_model->get_data();
        $menu['act']     = '0';

        view('header', $header);
        view('sms/nav', $menu);
        view('sms/berita_terkirim', $data);
        view('footer');
        unset($_SESSION['cari'], $_SESSION['filter'], $_SESSION['cari1'], $_SESSION['sex1'], $_SESSION['dusun1'], $_SESSION['rw1'], $_SESSION['rt1'], $_SESSION['agama1'], $_SESSION['pekerjaan1'], $_SESSION['status1'], $_SESSION['pendidikan1'], $_SESSION['status_penduduk1'], $_SESSION['TextDecoded1'], $_SESSION['grup1']);
    }

    public function pending($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

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
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']  = $this->sms_model->paging_tertunda($p, $o);
        $data['main']    = $this->sms_model->list_data_tertunda($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->sms_model->autocomplete();
        $header          = $this->header_model->get_data();
        $menu['act']     = '0';

        view('header', $header);
        view('sms/nav', $menu);
        view('sms/pesan_tertunda', $data);
        view('footer');
        unset($_SESSION['cari'], $_SESSION['filter'], $_SESSION['cari1'], $_SESSION['sex1'], $_SESSION['dusun1'], $_SESSION['rw1'], $_SESSION['rt1'], $_SESSION['agama1'], $_SESSION['pekerjaan1'], $_SESSION['status1'], $_SESSION['pendidikan1'], $_SESSION['status_penduduk1'], $_SESSION['TextDecoded1'], $_SESSION['grup1']);
    }

    public function form($p = 1, $o = 0, $tipe = 0, $id = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if ($id) {
            $data['sms']          = $this->sms_model->get_sms($tipe, $id);
            $data['form_action']  = site_url("sms/insert/{$tipe}");
            $data['tipe']['tipe'] = $tipe;
            $data['grup']         = $this->sms_model->list_grup();
            $data['kontak']       = $this->sms_model->list_kontak();
            view('sms/ajax_sms_form', $data);
        } else {
            $data['sms']          = null;
            $data['form_action']  = site_url("sms/insert/{$tipe}");
            $data['tipe']['tipe'] = $tipe;
            $data['grup']         = $this->sms_model->list_grup();
            $data['kontak']       = $this->sms_model->list_kontak();
            view('sms/ajax_sms_form_kirim', $data);
        }
    }

    public function carikontak($tipe = 0)
    {
        if (isset($_POST['TextDecoded'])) {
            $data['text']['TextDecoded'] = $_POST['TextDecoded'];
        }
        $data['text']['TextDecoded'] = null;

        $data['form_action'] = site_url("sms/formaftercari/0/0/{$tipe}");

        $data['kontak'] = $this->sms_model->list_kontak();
        view('sms/ajax_sms_form_cari', $data);
    }

    public function formaftercari($tipe = 0)
    {
        $data['sms']['DestinationNumber'] = $_POST['kontak'];
        $data['sms']['TextDecoded']       = $_POST['text'];
        $data['form_action']              = site_url("sms/insert/{$tipe}");
        $data['tipe']['tipe']             = $tipe;
        $data['grup']                     = $this->sms_model->list_grup();
        view('sms/ajax_sms_form', $data);
    }

    public function send_broadcast()
    {
        $data['input'] = $_POST;
        if (isset($_SESSION['cari1'])) {
            $data['cari1'] = $_SESSION['cari1'];
        } else {
            $data['cari1'] = '';
        }
        if (isset($_SESSION['sex1'])) {
            $data['sex1'] = $_SESSION['sex1'];
        } else {
            $data['sex1'] = '';
        }

        if (isset($_SESSION['dusun1'])) {
            $data['dusun1']   = $_SESSION['dusun1'];
            $data['list_rw1'] = $this->penduduk_model->list_rw($data['dusun1']);

            if (isset($_SESSION['rw1'])) {
                $data['rw1']      = $_SESSION['rw1'];
                $data['list_rt1'] = $this->penduduk_model->list_rt($data['dusun1'], $data['rw11']);

                if (isset($_SESSION['rt1'])) {
                    $data['rt1'] = $_SESSION['rt1'];
                } else {
                    $data['rt1'] = '';
                }
            } else {
                $data['rw1'] = '';
            }
        } else {
            $data['dusun1'] = '';
        }

        if (isset($_SESSION['agama1'])) {
            $data['agama1'] = $_SESSION['agama1'];
        } else {
            $data['agama1'] = '';
        }
        if (isset($_SESSION['pekerjaan1'])) {
            $data['pekerjaan1'] = $_SESSION['pekerjaan1'];
        } else {
            $data['pekerjaan1'] = '';
        }
        if (isset($_SESSION['status1'])) {
            $data['status1'] = $_SESSION['status1'];
        } else {
            $data['status1'] = '';
        }
        if (isset($_SESSION['pendidikan1'])) {
            $data['pendidikan1'] = $_SESSION['pendidikan1'];
        } else {
            $data['pendidikan1'] = '';
        }
        if (isset($_SESSION['status_penduduk1'])) {
            $data['status_penduduk1'] = $_SESSION['status_penduduk1'];
        } else {
            $data['status_penduduk1'] = '';
        }

        if (isset($_SESSION['TextDecoded1'])) {
            $data['TextDecoded1'] = $_SESSION['TextDecoded1'];
        } else {
            $data['TextDecoded1'] = '';
        }
        if (isset($_SESSION['grup1'])) {
            $data['grup'] = $_SESSION['grup1'];
        } else {
            $data['grup1'] = '';
        }
        $data['insert'] = $this->sms_model->send_broadcast($data);
        redirect('sms/outbox');
    }

    public function broadcast_proses()
    {
        $adv_search = $_POST;
        $i          = 0;

        while ($i++ < count($adv_search)) {
            $col[$i] = key($adv_search);
            next($adv_search);
        }
        $i = 0;

        while ($i++ < count($col)) {
            if ($adv_search[$col[$i]] === '') {
                unset($adv_search[$col[$i]]);
            } else {
                $_SESSION[$col[$i]] = $adv_search[$col[$i]];
            }
        }

        redirect('sms/send_broadcast');
    }

    public function broadcast()
    {
        $data['dusun']       = $this->penduduk_model->list_dusun();
        $data['agama']       = $this->penduduk_model->list_agama();
        $data['pendidikan']  = $this->penduduk_model->list_pendidikan();
        $data['pekerjaan']   = $this->penduduk_model->list_pekerjaan();
        $data['grup']        = $this->sms_model->list_grup_kontak();
        $data['form_action'] = site_url('sms/broadcast_proses');
        view('sms/ajax_broadcast_form', $data);
    }

    public function ajax_penduduk_rw($dusun = '')
    {
        $rw = $this->penduduk_model->list_rw($dusun);
        echo "<td>RW</td>
		<td><select name='rw' onchange=RWSel('" . $dusun . "',this.value)>
		<option value=''>Pilih RW&nbsp;</option>";

        foreach ($rw as $data) {
            echo '<option>' . $data['rw'] . '</option>';
        }
        echo '</select>
		</td>';
    }

    public function ajax_penduduk_rt($dusun = '', $rw = '')
    {
        $rt = $this->penduduk_model->list_rt($dusun, $rw);
        echo "<td>RT</td>
		<td><select name='rt'>
		<option value=''>Pilih RT&nbsp;</option>";

        foreach ($rt as $data) {
            echo '<option value=' . $data['rt'] . '>' . $data['rt'] . '</option>';
        }
        echo '</select>
		</td>';
    }

    public function search()
    {
        $cari = $this->input->post('cari');
        if ($cari !== '') {
            $_SESSION['cari'] = $cari;
        } else {
            unset($_SESSION['cari']);
        }
        redirect('sms');
    }

    public function search_kontak()
    {
        $cari = $this->input->post('cari_kontak');
        if ($cari !== '') {
            $_SESSION['cari_kontak'] = $cari;
        } else {
            unset($_SESSION['cari_kontak']);
        }
        redirect('sms/kontak');
    }

    public function search_grup()
    {
        $cari = $this->input->post('cari_grup');
        if ($cari !== '') {
            $_SESSION['cari_grup'] = $cari;
        } else {
            unset($_SESSION['cari_grup']);
        }
        redirect('sms/group');
    }

    public function search_anggota($id = 0)
    {
        $cari = $this->input->post('cari_anggota');
        if ($cari !== '') {
            $_SESSION['cari_anggota'] = $cari;
        } else {
            unset($_SESSION['cari_anggota']);
        }
        redirect("sms/anggota/{$id}");
    }

    public function filter()
    {
        $filter = $this->input->post('filter');
        if ($filter !== 0) {
            $_SESSION['filter'] = $filter;
        } else {
            unset($_SESSION['filter']);
        }
        redirect('sms');
    }

    public function insert($tipe = 0)
    {
        $this->sms_model->insert();
        if ($tipe === 1) {
            redirect('sms');
        } elseif ($tipe === 2) {
            redirect('sms/sentitem');
        } elseif ($tipe === 3) {
            redirect('sms/pending');
        } else {
            redirect('sms/outbox');
        }
    }

    public function update($id = '', $p = 1, $o = 0)
    {
        $this->sms_model->update($id);
        redirect("sms/index/{$p}/{$o}");
    }

    public function delete($p = 1, $o = 0, $tipe = 0, $id = '')
    {
        $this->sms_model->delete($tipe, $id);
        if ($tipe === 1) {
            redirect('sms');
        } elseif ($tipe === 2) {
            redirect('sms/sentitem');
        } elseif ($tipe === 3) {
            redirect('sms/pending');
        } else {
            redirect('sms/outbox');
        }
    }

    public function delete_all($p = 1, $o = 0, $tipe = 0)
    {
        $this->sms_model->delete_all($tipe);
        if ($tipe === 1) {
            redirect('sms');
        } elseif ($tipe === 2) {
            redirect('sms/sentitem');
        } elseif ($tipe === 3) {
            redirect('sms/pending');
        } else {
            redirect('sms/outbox');
        }
    }

    public function sms_lock($id = '')
    {
        $this->sms_model->sms_lock($id, 0);
        redirect("sms/index/{$p}/{$o}");
    }

    public function sms_unlock($id = '')
    {
        $this->sms_model->sms_lock($id, 1);
        redirect("sms/index/{$p}/{$o}");
    }

    public function kontak($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_SESSION['cari_kontak'])) {
            $data['cari_kontak'] = $_SESSION['cari_kontak'];
        } else {
            $data['cari_kontak'] = '';
        }

        if (isset($_SESSION['filter'])) {
            $data['filter'] = $_SESSION['filter'];
        } else {
            $data['filter'] = '';
        }
        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']  = $this->sms_model->paging_kontak($p, $o);
        $data['main']    = $this->sms_model->list_data_kontak($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->sms_model->autocomplete();
        $header          = $this->header_model->get_data();
        $menu['act']     = '2';

        view('header', $header);
        view('sms/nav', $menu);
        view('sms/kontak', $data);
        view('footer');
        unset($_SESSION['cari_kontak']);
    }

    public function form_kontak($id = 0)
    {
        $data['nama']        = $this->sms_model->list_nama();
        $data['form_action'] = site_url('sms/kontak_insert');
        $data['kontak']      = $this->sms_model->get_kontak($id);
        if ($id === 0) {
            view('sms/ajax_kontak_form', $data);
        } else {
            view('sms/ajax_kontak_form_edit', $data);
        }
    }

    public function kontak_insert()
    {
        $data['input']  = $_POST;
        $data['insert'] = $this->sms_model->insert_kontak($data);
        redirect('sms/kontak');
    }

    public function kontak_delete($id = 0)
    {
        $data['hapus'] = $this->sms_model->delete_kontak($id);
        redirect('sms/kontak');
    }

    public function delete_all_kontak()
    {
        $this->sms_model->delete_all_kontak();
        redirect('sms/kontak');
    }

    public function group($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_SESSION['cari_grup'])) {
            $data['cari_grup'] = $_SESSION['cari_grup'];
        } else {
            $data['cari_grup'] = '';
        }

        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']  = $this->sms_model->paging_grup($p, $o);
        $data['main']    = $this->sms_model->list_data_grup($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword'] = $this->sms_model->autocomplete();
        $header          = $this->header_model->get_data();
        $menu['act']     = '2';

        view('header', $header);
        view('sms/nav', $menu);
        view('sms/group', $data);
        view('footer');
        unset($_SESSION['cari_grup']);
    }

    public function form_grup($id = 0)
    {
        if ($id === '0') {
            $data['form_action']       = site_url('sms/grup_insert');
            $data['grup']['nama_grup'] = '';
        } else {
            $data['form_action'] = site_url('sms/grup_update');
            $data['grup']        = $this->sms_model->get_grup($id);
        }
        view('sms/ajax_grup_form', $data);
    }

    public function grup_insert()
    {
        $data['input']  = $_POST;
        $data['insert'] = $this->sms_model->insert_grup($data);
        redirect('sms/group');
    }

    public function grup_update()
    {
        $data['input']  = $_POST;
        $data['update'] = $this->sms_model->update_grup($data);
        redirect('sms/group');
    }

    public function grup_delete($id = 0)
    {
        $data['hapus'] = $this->sms_model->delete_grup($id);
        redirect('sms/group');
    }

    public function delete_all_grup()
    {
        $this->sms_model->delete_all_grup();
        redirect('sms/group');
    }

    public function anggota($id = 0, $p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_SESSION['cari_anggota'])) {
            $data['cari_anggota'] = $_SESSION['cari_anggota'];
        } else {
            $data['cari_anggota'] = '';
        }

        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']            = $this->sms_model->paging_anggota($id, $p, $o);
        $data['main']              = $this->sms_model->list_data_anggota($id, $o, $data['paging']->offset, $data['paging']->per_page);
        $data['grup']['nama_grup'] = $id;
        $data['keyword']           = $this->sms_model->autocomplete();
        $header                    = $this->header_model->get_data();
        $menu['act']               = '2';

        view('header', $header);
        view('sms/nav', $menu);
        view('sms/group_detail', $data);
        view('footer');
        unset($_SESSION['cari_anggota']);
    }

    public function form_anggota($id = 0)
    {
        $data['form_action'] = site_url("sms/anggota_insert/{$id}");
        $data['main']        = $this->sms_model->list_data_nama($id);
        view('sms/ajax_anggota_form', $data);
    }

    public function anggota_insert($id = 0)
    {
        $data['insert'] = $this->sms_model->insert_anggota($id);
        redirect("sms/anggota/{$id}");
    }

    public function anggota_delete($grup = 0, $id = 0)
    {
        $data['hapus'] = $this->sms_model->delete_anggota($grup, $id);
        redirect("sms/anggota/{$grup}");
    }

    public function delete_all_anggota($grup = 0)
    {
        $this->sms_model->delete_all_anggota($grup);
        redirect("sms/anggota/{$grup}");
    }

    public function form_polling($id = 0)
    {
        $data['main'] = $this->sms_model->get_data_polling($id);

        $data['form_action'] = site_url("sms/insert_polling/{$id}");
        view('sms/ajax_polling_form', $data);
    }

    public function insert_polling($id = 0)
    {
        $data['insert'] = $this->sms_model->insert_polling($id);
        redirect('sms/polling');
    }

    public function polling_delete($id = 0)
    {
        $data['hapus'] = $this->sms_model->delete_polling($id);
        redirect('sms/polling');
    }

    public function delete_all_polling()
    {
        $this->sms_model->delete_all_polling();
        redirect('sms/polling');
    }

    public function pertanyaan($id = 0, $p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        if (isset($_POST['per_page'])) {
            $_SESSION['per_page'] = $_POST['per_page'];
        }
        $data['per_page'] = $_SESSION['per_page'];

        $data['paging']                = $this->sms_model->paging_pertanyaan($id, $p, $o);
        $data['main']                  = $this->sms_model->list_data_pertanyaan($id, $o, $data['paging']->offset, $data['paging']->per_page);
        $data['polling']['id_polling'] = $id;
        $data['keyword']               = $this->sms_model->autocomplete();
        $header                        = $this->header_model->get_data();
        $menu['act']                   = '2';

        view('header', $header);
        view('sms/nav', $menu);
        view('sms/pertanyaan', $data);
        view('footer');
    }

    public function form_pertanyaan($id = 0)
    {
        $data['form_action'] = site_url("sms/pertanyaan_insert/{$id}");
        view('sms/ajax_pertanyaan_form', $data);
    }

    public function pertanyaan_insert($id = 0)
    {
        $data['insert'] = $this->sms_model->insert_pertanyaan($id);
        redirect("sms/pertanyaan/{$id}");
    }
}
