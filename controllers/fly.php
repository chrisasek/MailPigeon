<?php
require_once('../config/init.php');

$user = new User();
$constants = new Constants();

if (!empty($_POST)) {
    Session::put('form_data', $_POST);
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        //echo "I have been ran <br />";
        $validate = new Validate();
        // validate
        $validation = $validate->check($_POST, array(
            'subject' => array(
                'required' => true,
            ),
            'from' => array(
                'required' => true,
                'min' => 2,
                'max' => 50,
                'validemail' => true,
                'unique' => 'users'
            ),
            'receivers' => array(
                'required' => true,
            ),
            'message' => array(
                'required' => true,
            ),
        ));


        if ($validation->passed()) {
            try {
                $subject = trim(Input::get('subject'));
                $from = trim(Input::get('from'));
                $receivers = explode(',', trim(Input::get('receivers')));
                $message = trim(Input::get('message'));

                foreach ($receivers as $email) {
                    if (Helpers::isEmail($email)) {
                        Messages::send($message, $subject, $email, $email, $from, true);
                    }
                }

                Session::put('success', "Sent Successfully");
                Redirect::to_js('../');
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
            }
        } else {
            Session::flash('error', $validation->errors());
        }
    } else {
        Session::flash('error', $constants->getText('INVALID_TOKEN'));
    }
} else {
    Session::flash('error', $constants->getText('INVALID_ACTION'));
}

Redirect::to('../register');
