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

    public function booked_post()
    {
        if(isset($_POST['submit'])){
            
            $dt = date('Y-m-d H:i:s');
            $id = 'USR' . strtotime($dt);

            $data['id'] = $id;
            $data['ticket_id'] = $this->input->post('id');
            $data['email'] = $this->input->post('email');
            $data['created_datetime'] = date("Y-m-d H:i:s");
            $data['updated_datetime'] = date("Y-m-d H:i:s");

            // print_r($data);
            // die();

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
                        $this->load->view('ticket/success', $x);
                    }
                }
            }
        }
    }
}