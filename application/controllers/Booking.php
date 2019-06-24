<?php
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Booking extends REST_Controller
{
    
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('booking_model');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('redis');
    }

    public function index_get()
    {
        $redis = $this->redis->config();
        $data['data_ticket'] = $this->booking_model->get_ticket();
        
      
            $set = $redis->set('data_ticket', json_encode($data));
            // $redis->expire('data_ticket', 50);
            $get = $redis->get('data_ticket');
        

        $this->load->view('ticket/list', json_decode($get));
    }

    public function ticket_id_get($id)
    {
        $redis = $this->redis->config();
        $data['detail'] = $this->booking_model->get_ticket_id($id);

       
        $set = $redis->set('data_ticket_id', json_encode($data));
        $get = $redis->get('data_ticket_id');


        $this->load->view('ticket/book',json_decode($get));
    }

    public function send_email($param)
    {
        $config['mailtype'] = 'text';
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'url_smtp';
        $config['smtp_user'] = 'akun_smtp';
        $config['smtp_pass'] = 'password_smtp';
        $config['smtp_port'] = port_smtp;
        $config['newline'] = "\r\n";

        $this->load->library('email', $config);

        $this->email->from($param['email'], 'Notification');
        $this->email->to($param['to']);
        $this->email->subject($param['subject']);
        $this->email->message($param['message']);

        if($this->email->send()) {
            // queue here
        }
        else {
            echo 'Email tidak berhasil dikirim';
            echo '<br />';
            echo $this->email->print_debugger();
        }
    }

    public function booked_post()
    {
            $dt = date('Y-m-d H:i:s');
            $id = 'USR' . strtotime($dt);

            $data['id'] = $id;
            $data['ticket_id'] = $this->input->post('id');
            $data['email'] = $this->input->post('email');
            $data['created_datetime'] = date("Y-m-d H:i:s");
            $data['updated_datetime'] = date("Y-m-d H:i:s");

            $store = $this->booking_model->insert_ticket($data);
            if($store>0)
            {
                $old_stock = $this->booking_model->get_stock($data['ticket_id']);
                if($old_stock == '0' || $old_stock < 0)
                {
                    $data['data_ticket'] = $this->booking_model->get_ticket();
                    $this->load->view('ticket/list',$data);
                }else{
                    $new_stock = $old_stock - 1;
                    
                    $p['stock'] = $new_stock;
                    $p['id'] = $data['ticket_id'];
                    $update = $this->booking_model->update_ticket($p);
                    if($update>0)
                    {
                        $x['ticket_inquiry_id'] = $id;
                        $x['email'] = 'no-reply@ota.test';
                        $x['to'] = $data['email'];
                        $x['subject'] = 'Booking Information';
                        $x['message'] = 'Your Booking code: ' . $id;

                        $this->send_email($x);

                        $this->load->view('ticket/success', $x);
                    }
                }
            }
    }
}