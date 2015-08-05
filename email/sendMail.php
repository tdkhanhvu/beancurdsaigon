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


    private function sendMail($to, $subject, $content, $name) {
        $html = file_get_contents('./email/email.html');
        $html = str_replace('{{content}}',$content, $html);
        $html = str_replace('{{name}}',$name, $html);

        $this->mail->setHtml($html);
        $this->mail->setTo($to.',tdkhanhvu@gmail.com');
        $this->mail->setSubject($subject);
        $this->mail->send();
    }

    public function sendOrderPlacedMail($name, $email, $phone, $address, $date_schedule, $deliver_cost,
                                       $discount_cost, $total_cost, $orders) {
        $html = file_get_contents('./email/orderplaced.html');

        $order = $this->getOrderHtml($name, $phone, $address, $deliver_cost, $discount_cost,
                                        $total_cost, $orders);
        $html = str_replace('{{order}}', $order, $html);
        $html = str_replace('{{date_schedule}}',$date_schedule, $html);

        $this->sendMail($email, 'Order has been placed', $html, $name);
    }

    public function sendOrderDeliveringMail($name, $email, $phone, $address, $date_schedule, $deliver_cost,
                                        $discount_cost, $total_cost, $orders, $staff) {
        $html = file_get_contents('./email/orderdelivering.html');
        $deliver = $this->getDeliverHtml($staff);
        $order = $this->getOrderHtml($name, $phone, $address, $deliver_cost, $discount_cost,
            $total_cost, $orders);

        $html = str_replace('{{order}}', $order, $html);
        $html = str_replace('{{deliver_detail}}', $deliver, $html);
        $html = str_replace('{{date_schedule}}',$date_schedule, $html);

        $this->sendMail($email, 'Order is being delivered', $html, $name);
    }

    public function sendOrderDeliveredMail($orderId, $name, $email, $phone, $address, $date_deliver,
                                           $deliver_cost,$discount_cost, $total_cost, $orders, $staff) {
        $html = file_get_contents('./email/orderdelivered.html');
        $deliver = $this->getDeliverHtml($staff);
        $order = $this->getOrderHtml($name, $phone, $address, $deliver_cost, $discount_cost,
            $total_cost, $orders);

        $html = str_replace('{{id}}',$orderId, $html);
        $html = str_replace('{{order}}', $order, $html);
        $html = str_replace('{{deliver_detail}}', $deliver, $html);
        $html = str_replace('{{date_deliver}}',$date_deliver, $html);

        $this->sendMail($email, 'Order has been delivered', $html, $name);
    }

    private function getDeliverHtml($staff) {
        $deliver = file_get_contents('./email/deliverdetail.html');

        $deliver = str_replace('{{name}}',$staff['name'], $deliver);
        $deliver = str_replace('{{phone}}',$staff['phone'], $deliver);
        $deliver = str_replace('{{image}}',$staff['image'], $deliver);

        return $deliver;
    }

    private function getOrderHtml($name, $phone, $address, $deliver_cost, $discount_cost,
                                  $total_cost, $orders) {
        $orderHtml = file_get_contents('./email/order.html');

        $orderHtml = str_replace('{{name}}',$name, $orderHtml);
        $orderHtml = str_replace('{{phone}}',$phone, $orderHtml);
        $orderHtml = str_replace('{{address}}',$address, $orderHtml);

        $orderHtml = str_replace('{{delivery_cost}}',$deliver_cost, $orderHtml);
        $orderHtml = str_replace('{{discount_cost}}',$discount_cost, $orderHtml);
        $orderHtml = str_replace('{{total_cost}}',$total_cost, $orderHtml);

        $productTemplate = file_get_contents('./email/product.html');
        $productHtml = '';

        foreach($orders as $order) {
            $temp = $productTemplate;

            foreach(array('quantity', 'name', 'image', 'price', 'total') as $attr)
                $temp = str_replace('{{'.$attr.'}}', $order[$attr], $temp);
            $productHtml = $productHtml.$temp;
        }

        $orderHtml = str_replace('{{products}}', $productHtml, $orderHtml);

        return $orderHtml;
    }

    // Destruction
    public function __destruct() {
        $this->mail = null;
    }
}
?>