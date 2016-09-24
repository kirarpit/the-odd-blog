<?php
header("Content-type: application/json");
require_once('vendor/autoload.php');

$message = $_POST['message'];
$from = "iownuangels@gmail.com";
$user_id = $message['from_email'];
$user_name = $message['from_name'];
$subject = 'ThePeculiarBlog.com About Section';

$body = $message['body'];
$body ="<li>Name: $user_name</li></br><li>EmailID: $user_id</li></br><li>Body: $body</li>";
$mail_contents = file_get_contents('mail_template.html');
$body = str_ireplace("--body--", $body, $mail_contents);

$sendgrid = new SendGrid('kiarrpit', 'kira007!');
$email = new SendGrid\Email();
$email
    ->addTo('iarpitgarg@gmail.com')
    ->setFrom($from)
    ->setSubject($subject)
    ->setHtml($body)
;

$sendgrid->send($email);

$out = array("notice" => "Sent");
echo json_encode($out);

?>
