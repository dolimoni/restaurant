<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 7/7/18
 * Time: 4:03 PM
 */

class Email extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        if ( ! $this->session->userdata('isLogin')) {
            redirect('login');
        }

        $this->load->model('model_email');

    }

    public function compose($user_id)
    {
        $this->log_begin();
        $data['params'] = $this->getParams();
        $this->load->view('admin/email/compose_view', $data);
        $this->log_end($data);
    }


}