<?php

use App\Controllers\BaseController;

class Sosmed extends BaseController
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

    public function index()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(1);
        $data['form_action'] = site_url('sosmed/update/1');
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        view('header', $header);
        view('web/nav', $nav);
        view('sosmed/facebook', $data);
        view('footer');
    }

    public function twitter()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(2);
        $id                  = $data['main']['id'];
        $data['form_action'] = site_url("sosmed/update/2/{$id}");
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        view('header', $header);
        view('web/nav', $nav);
        view('sosmed/twitter', $data);
        view('footer');
    }

    public function instagram()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(5);
        $data['form_action'] = site_url('sosmed/update/5');
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        view('header', $header);
        view('web/nav', $nav);
        view('sosmed/google', $data);
        view('footer');
    }

    public function google()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(3);
        $data['form_action'] = site_url('sosmed/update/3');
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        view('header', $header);
        view('web/nav', $nav);
        view('sosmed/instagram', $data);
        view('footer');
    }

    public function youtube()
    {
        $data['main']        = $this->web_sosmed_model->get_sosmed(4);
        $data['form_action'] = site_url('sosmed/update/4');
        $header              = $this->header_model->get_data();
        $nav['act']          = 6;

        view('header', $header);
        view('web/nav', $nav);
        view('sosmed/youtube', $data);
        view('footer');
    }

    public function update($id = '')
    {
        $this->web_sosmed_model->update($id);
        if ($id === '1') {
            redirect('sosmed');
        } elseif ($id === '2') {
            redirect('sosmed/twitter');
        } elseif ($id === '3') {
            redirect('sosmed/google');
        } elseif ($id === '4') {
            redirect('sosmed/youtube');
        } else {
            redirect('sosmed/instagram');
        }
    }
}
