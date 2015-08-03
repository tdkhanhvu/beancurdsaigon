<?php

class SendMail {
    private $mail;

    // Construction
    public function __construct() {
        $this->mail = new Mail;

        $this->mail->setFrom('tdkhanhvu@gmail.com');
        $this->mail->setSender('tdkhanhvu@gmail.com');
        $this->mail->setText('cool');
        $this->mail->username = 'tdkhanhvu@gmail.com';
        $this->mail->password = 'Knight1990';
        $this->mail->hostname = 'smtp.gmail.com';
        $this->mail->port = 587;
    }


    private function sendMail($to, $subject, $html) {
        $this->mail->setHtml($html);
        $this->mail->setTo($to.',tdkhanhvu@gmail.com');
        $this->mail->setSubject($subject);
        $this->mail->send();
    }

    public function sendOrderPlaceMail($name, $email, $phone, $address, $date_schedule, $deliver_cost,
                                       $discount_cost, $total_cost, $orders) {
        $html = file_get_contents('./email/orderplaced.html');
        $order = file_get_contents('./email/order.html');

        $html = str_replace('{{name}}',$name, $html);

        $order = str_replace('{{phone}}',$phone, $order);
        $order = str_replace('{{address}}',$address, $order);

        $order = str_replace('{{delivery_cost}}',$deliver_cost, $order);
        $order = str_replace('{{discount_cost}}',$discount_cost, $order);
        $order = str_replace('{{total_cost}}',$total_cost, $order);

        $orderTemplate = file_get_contents('./email/product.html');
        $orderHtml = '';

        foreach($orders as $order) {
            $temp = $orderTemplate;

            foreach(array('quantity', 'name', 'image', 'price', 'total') as $attr)
                $temp = str_replace('{{'.$attr.'}}', $order[$attr], $temp);
            $orderHtml = $orderHtml.$temp;
        }

        $order = str_replace('{{products}}', $orderHtml, $order);
        $html = str_replace('{{order}}', $order, $html);
        $html = str_replace('{{date_schedule}}',$date_schedule, $html);

        $this->sendMail($email, 'Order has been placed', $html);
    }

    // Destruction
    public function __destruct() {
        $this->mail = null;
    }
}
?>