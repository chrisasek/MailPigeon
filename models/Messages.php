<?php
class Messages
{

	//message constants
	const
		SITE_URL = 'https://oniontabs.com/',
		ADMIN_EMAIL = 'admin@oniontabs.com';

	private static $_msg_template = "<!DOCTYPE html>
	<html lang='en'>
	<head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<style>.container{position:relative;width:100%;max-width:960px;margin:0 auto;padding:0 20px;box-sizing:border-box}.column,.columns{width:100%;float:left;box-sizing:border-box}@media (min-width:400px){.container{width:85%;padding:0}}@media (min-width:550px){.container{width:80%}.column,.columns{margin-left:4%}.column:first-child,.columns:first-child{margin-left:0}.one.column,.one.columns{width:4.66666666667%}.two.columns{width:13.3333333333%}.three.columns{width:22%}.four.columns{width:30.6666666667%}.five.columns{width:39.3333333333%}.six.columns{width:48%}.seven.columns{width:56.6666666667%}.eight.columns{width:65.3333333333%}.nine.columns{width:74%}.ten.columns{width:82.6666666667%}.eleven.columns{width:91.3333333333%}.twelve.columns{width:100%;margin-left:0}.one-third.column{width:30.6666666667%}.two-thirds.column{width:65.3333333333%}.one-half.column{width:48%}.offset-by-one.column,.offset-by-one.columns{margin-left:8.66666666667%}.offset-by-two.column,.offset-by-two.columns{margin-left:17.3333333333%}.offset-by-three.column,.offset-by-three.columns{margin-left:26%}.offset-by-four.column,.offset-by-four.columns{margin-left:34.6666666667%}.offset-by-five.column,.offset-by-five.columns{margin-left:43.3333333333%}.offset-by-six.column,.offset-by-six.columns{margin-left:52%}.offset-by-seven.column,.offset-by-seven.columns{margin-left:60.6666666667%}.offset-by-eight.column,.offset-by-eight.columns{margin-left:69.3333333333%}.offset-by-nine.column,.offset-by-nine.columns{margin-left:78%}.offset-by-ten.column,.offset-by-ten.columns{margin-left:86.6666666667%}.offset-by-eleven.column,.offset-by-eleven.columns{margin-left:95.3333333333%}.offset-by-one-third.column,.offset-by-one-third.columns{margin-left:34.6666666667%}.offset-by-two-thirds.column,.offset-by-two-thirds.columns{margin-left:69.3333333333%}.offset-by-one-half.column,.offset-by-one-half.columns{margin-left:52%}}html{font-size:62.5%}body{font-size:1.5em;line-height:1.6;font-weight:400;font-family:Raleway,HelveticaNeue,'Helvetica Neue',Helvetica,Arial,sans-serif;color:#222}h1,h2,h3,h4,h5,h6{margin-top:0;margin-bottom:2rem;font-weight:300}h1{font-size:4rem;line-height:1.2;letter-spacing:-.1rem}h2{font-size:3.6rem;line-height:1.25;letter-spacing:-.1rem}h3{font-size:3rem;line-height:1.3;letter-spacing:-.1rem}h4{font-size:2.4rem;line-height:1.35;letter-spacing:-.08rem}h5{font-size:1.8rem;line-height:1.5;letter-spacing:-.05rem}h6{font-size:1.5rem;line-height:1.6;letter-spacing:0}@media (min-width:550px){h1{font-size:5rem}h2{font-size:4.2rem}h3{font-size:3.6rem}h4{font-size:3rem}h5{font-size:2.4rem}h6{font-size:1.5rem}}p{margin-top:0}a{color:#1eaedb}a:hover{color:#0fa0ce}ul{list-style:circle inside}ol{list-style:decimal inside}ol,ul{padding-left:0;margin-top:0}ol ol,ol ul,ul ol,ul ul{margin:1.5rem 0 1.5rem 3rem;font-size:90%}li{margin-bottom:1rem}code{padding:.2rem .5rem;margin:0 .2rem;font-size:90%;white-space:nowrap;background:#f1f1f1;border:1px solid #e1e1e1;border-radius:4px}pre>code{display:block;padding:1rem 1.5rem;white-space:pre}td,th{padding:12px 15px;text-align:left;border-bottom:1px solid #e1e1e1}td:first-child,th:first-child{padding-left:0}td:last-child,th:last-child{padding-right:0}.button,button{margin-bottom:1rem}fieldset,input,select,textarea{margin-bottom:1.5rem}blockquote,dl,figure,form,ol,p,pre,table,ul{margin-bottom:2.5rem}.u-full-width{width:100%;box-sizing:border-box}.u-max-full-width{max-width:100%;box-sizing:border-box}.u-pull-right{float:right}.u-pull-left{float:left}hr{margin-top:3rem;margin-bottom:3.5rem;border-width:0;border-top:1px solid #e1e1e1}.container:after,.row:after,.u-cf{content:'';display:table;clear:both}.fw-bold{font-weight:700}.text-accent{color:#00ffd6}.text-primary{color:#ffad23}.text-green{color:green}.text-center{text-align:center}.mb-1rem{margin-bottom:1rem}.mb-0{margin-bottom:0}p{margin-bottom:1rem}</style>
	</head>
	
	<body>
		<div class='container'>
			<div class='row'>
				<div class='offset-by-two eight columns' style='margin-top: 5%;'>
					<div class='card' style='background:#fff;border-radius:.8rem;border:0;'>
						<div class='card-body' style='padding:2rem 1.6rem;'>
							<h2>Fly Bird</h2>
							<br>
							<br>
							<br>
							<h5 class=''>Hello <span  style='font-weight: bold;'>[name]</span>,</h5>
							<br>
							    [message]
							<br>
							<br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>";

	// variables static		
	private static 	$_headers,
		$_to,
		$_message,
		$_subject,
		$_table_name = 'message',
		$_table_id = 'id';
	private $_db,
		$_data,
		$_table = array('message_snippets', 'notification_snippets', 'sms_snippets');
	// constructor
	public function __construct()
	{
		$this->_db = DB::getInstance();
	}

	//create
	// working
	public function create($fields = array(), $table = "message_snippets")
	{
		if (!$this->_db->insert($table, $fields)) {
			throw new Exception('There was a problem saving your plan.');
		}
	}
	// update
	public function update($fields = array(), $id = null, $table = "message_snippets")
	{
		if ($id && is_numeric($id)) {
			$id = (int) $id;
			if (!$this->_db->update($table, $id, $fields)) {
				throw new Exception('There was a problem saving your information...');
			}
			return true;
		}
		return false;
	}

	// logically improper
	public function find($id, $table = "message_snippets")
	{
		$result = $this->_db->get($table, array('id', '=', $id));
		if ($result->count()) {
			$this->_data = $result->first();
			return true;
		}
		return false;
	}

	public function getMessages($per_page, $off_set, $where = null, $table = "message_snippets")
	{
		return $this->_db->getPerPage($per_page, $off_set, $table, $where, "ORDER BY id DESC");
	}

	public static function send_with_temp($message, $subject, $to = null)
	{
		if (!$to) {
			self::$_to = self::ADMIN_EMAIL;
		} else {
			self::$_to = $to;
		}
		// spacify boundary
		//$boundary = uniqid('nsuk');

		self::$_subject = $subject . ' : ';
		self::$_message = $message;
		self::$_message = wordwrap($message, 70);

		$from = "Marketingpros.ng Team  <hello@marketingpros.ng>";
		self::$_headers = "From: {$from}\n";
		self::$_headers .= "Reply-To: {$from}\n";
		self::$_headers .= "MIME-Version: 1.0\n";
		self::$_headers .= "Content-Type: text/html; charset=UTF-8";

		$msgtext = str_replace("[message]", self::$_message, self::$_msg_template);
		// print_r($msgtext);
		if ($result = @mail(self::$_to, self::$_subject, $msgtext, self::$_headers)) {
			return True;
		} else {
			return False;
		}
	}

	public static function send($message, $subject, $to = null, $name = null, $from = "Mail Pigeon", $temp = false, $cover = false)
	{
		if (!$to) {
			self::$_to = self::ADMIN_EMAIL;
		} else {
			self::$_to = $to;
		}
		// spacify boundary
		//$boundary = uniqid('nsuk');

		self::$_subject = $subject . ' : ';
		self::$_message = $message;
		// self::$_message = wordwrap($message, 70);

		$from = "$from  <$from>";
		self::$_headers = "From: {$from}\n";
		self::$_headers .= "Reply-To: {$from}\n";
		self::$_headers .= "MIME-Version: 1.0\n";
		self::$_headers .= "Content-Type: text/html; charset=UTF-8";

		if ($temp) {
			$msgtext = str_replace(array("[message]", "[name]", "[img]"), array(self::$_message, $name,  $cover), self::$_msg_template);
		} else {
			$msgtext = $message;
		}

		if ($result = @mail(self::$_to, self::$_subject, $msgtext, self::$_headers)) {
			return True;
		} else {
			return False;
		}
	}

	public function data()
	{
		return $this->_data;
	}
}
