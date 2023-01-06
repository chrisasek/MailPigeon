<?php

/**
 * This example shows how to extend PHPMailer to simplify your coding.
 * If PHPMailer doesn't do something the way you want it to, or your code
 * contains too much boilerplate, don't edit the library files,
 * create a subclass instead and customise that.
 * That way all your changes will be retained when PHPMailer is updated.
 */

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require SITE_ROOT . '/vendor/autoload.php';

/**
 * Use PHPMailer as a base class and extend it
 */
class Mailer extends PHPMailer
{
    /**
     * myPHPMailer constructor.
     *
     * @param bool|null $exceptions
     * @param string    $body A default HTML message body
     */
    public function __construct($exceptions = true)
    {
        //Don't forget to do this or other things may not be set correctly!
        parent::__construct($exceptions);
        //Set a default 'From' address
        $this->setFrom('contact@stakepadi.com', 'Stakepadi');
    }

    //Extend the send function
    /**
     * Mailer sendMessage.
     *
     * @param string    $nessage A default HTML message body
     * @param string    $subject Subject of the mail
     * @param array|object    $to Recipients
     * @param array|object    $from Sender
     */
    public function sendMessage(
        $message,
        $subject,
        $to = array('email' => 'chrisasek@gmail.com', 'first_name' => 'Chris', 'last_name' => 'Asek'),
        $from = array('email' => 'contact@stakepadi.com', 'name' => 'Stakepadi')
    ) {
        // Fetch template
        // $template = file_get_contents('../assets/templates/email.html');
        $template = file_get_contents(SITE_ROOT.'/assets/templates/email.html');
        $message = str_replace('[message]', $message, trim($template));

        //Set a default 'From' address
        if ($from) {
            $this->setFrom($from['email'], $from['name']);
        }

        // Set Subject 
        $this->Subject = $subject;
        $to_name = isset($to['name']) ? $to['name'] : $to['first_name'] . ' ' . $to['last_name'];
        $this->addAddress($to['email'], $to_name);
        // $this->addBCC($to['email'], $to_name);
        //Set an HTML and plain-text message, import relative image references
        $this->msgHTML($message, './assets/images/');

        // $this->Subject = '[Yay for me!] ' . $this->Subject;
        $r = parent::send();
        // echo 'I sent a message with subject ' . $this->Subject;
        // Clear Addresses
        $this->clearAddresses();
        // $this->clearBCCs()
        return $r;
    }
}

//Now creating and sending a message becomes simpler when you use this class in your app code
// try {
//     //Instantiate your new class, making use of the new `$body` parameter
//     $mail = new myPHPMailer(true, '<strong>This is the message body</strong>');
//     //Now you only need to set things that are different from the defaults you defined
//     $mail->addAddress('jane@example.com', 'Jane User');
//     $mail->Subject = 'Here is the subject';
//     $mail->addAttachment(__FILE__, 'myPHPMailer.php');
//     $mail->send(); //No need to check for errors - the exception handler will do it
// } catch (Exception $e) {
//     //Note that this is catching the PHPMailer Exception class, not the global \Exception type!
//     echo 'Caught a ' . get_class($e) . ': ' . $e->getMessage();
// }