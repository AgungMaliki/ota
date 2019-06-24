<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use Restserver\Libraries\REST_Controller;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exchange\AMQPExchangeType;


class Welcome extends CI_Controller {

	function __construct()
    {
		parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        /*$this->methods['signfacebook_post']['limit'] = 1000; // 3 requests per hour per user/key
        $this->methods['signgoogle_post']['limit'] = 1000; // 3 requests per hour per user/key
        $this->methods['signup_post']['limit'] = 1000; // 3 requests per hour per user/key
        $this->methods['signin_post']['limit'] = 1000; // 3 requests per hour per user/key
        $this->methods['forgetpassword_post']['limit'] = 1000; // 3 requests per hour per user/key
        $this->methods['servicetype_post']['limit'] = 1000; // 3 requests per hour per user/key*/
		date_default_timezone_set('Asia/Jakarta');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function testing()
    {
        $host = 'spider-01.rmq.cloudamqp.com';
        $user = 'xgcgrirt';
        $pass = 'WwPbKECk3j9vyZRc8Zvxxe8je75NISXU';
        $vhost = 'xgcgrirt';
        $port = '5672';
        $exchange = 'subsribers';
        $queue = 'testing_ota';


        $connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
        $channel = $connection->channel();
        $channel->queue_declare($queue, false, true, false, false);
      
        $channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);
        $channel->queue_bind($queue, $exchange);
        $messageBody = json_encode([
			'email' => 'test@test.com',
			'subscribed' => true
		]);
        $message = new AMQPMessage($messageBody, array('content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $channel->basic_publish($message, $exchange);
        $channel->close();
        $connection->close();
    }

	function test_redis(){
		$this->load->library('redis');
		$redis = $this->redis->config();

		$set = $redis->set('Data1', 'Tutorial redis codeigniter');

		$get = $redis->get('Data1');
		echo $get;
	}

	public function test()
	{
		echo("be");
		die();
	}
}
