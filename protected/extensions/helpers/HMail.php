<?php

/**
 * Description of HMail
 *
 * @author vaseninm
 */
class HMail {

    public function send($subject, $view, $email, $data = array()) {
        $message = new YiiMailMessage;
        $message->subject = $subject;
        $message->view = $view;
        $message->data = $data;
        $message->setBody();
        $message->addTo($email);
        $message->setContentType('text/html');
        $message->from = Yii::app()->params['adminEmail'];
        Yii::app()->mail->send($message);
    }

}

?>
