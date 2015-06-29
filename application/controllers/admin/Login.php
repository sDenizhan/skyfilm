<?php

class Login extends AdminController {

    public function __construct()
    {
        $this->setAdminControl(false);
        parent::__construct();
        $this->setPageLayout('login');
    }

    public function index()
    {
        $this->render('login');
    }

    public function dologin()
    {
        $this->form_validation->set_rules('kullanici_adi', 'Kullanıcı Adı', 'required|xss_clean|trim');
        $this->form_validation->set_rules('sifre', 'Sifre', 'required|trim|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/login/index');
        } else {

            $_kullanici_adi = $this->input->post('kullanici_adi', TRUE);
            $_sifre = $this->input->post('sifre', TRUE);

            $_kullanici = $this->auth->admin_login($_kullanici_adi, $_sifre);

            if ($this->auth->login_control() && true == $_kullanici) {
                redirect('admin/panel/index');
            } else {
                $this->session->set_flashdata('error', 'Üyelik Bilgileriniz Bulunamadı.');
                redirect('admin/login/index');
            }
        }
    }
}