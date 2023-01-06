<?php
require_once('../config/init.php');

$User = new User();
$constants = new Constants();
$Mailer = new Mailer();

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
            'from_name' => array(
                'required' => true,
            ),
            'from_email' => array(
                'required' => true,
                'min' => 2,
                'max' => 80,
                'validemail' => true,
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
                $from = Input::get('from_name') && Input::get('from_email') ? array(
                    'name' => Input::get('from_name'),
                    'email' => Input::get('from_email'),
                ) : null;
                $receivers = explode(',', trim(Input::get('receivers')));
                $message = trim(Input::get('message'));

                if ($receivers) {
                    $Mailer->sendMessage(
                        $message,
                        $subject,
                        $receivers,
                        $from,
                        true,
                    );
                    // foreach ($receivers as $email) {
                    //     if (Helpers::isEmail($email)) {
                    //         // Messages::send($message, $subject, $email, $email, $from, true);
                    //         $Mailer->sendMessage(
                    //             $message,
                    //             $subject,
                    //             array(
                    //                 'email' => $email,
                    //                 'name' => $email,
                    //             ),
                    //             $from
                    //         );
                    //     }
                    // }

                    Session::delete('form_data');
                    Session::put('success', "Sent Successfully");
                }

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

Redirect::to('../');
