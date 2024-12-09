<?php
    include "../config/base_url.php";
    include "../config/db.php";

    if(isset($_POST["name"],$_POST["phone"]) && strlen($_POST["name"]) > 0 && intval($_POST["phone"])) {
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        
        $prep = mysqli_prepare($con, "INSERT INTO applications (name, phone) VALUES (?,?)");
        mysqli_stmt_bind_param($prep, "si", $name, $phone);
        mysqli_stmt_execute($prep);
        /////
        require_once('phpmailer/PHPMailerAutoload.php');
        $mail = new PHPMailer;
        $mail->CharSet = 'utf-8';
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.mail.ru';  																							// Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'econur-applications@mail.ru'; // Ваш логин от почты с которой будут отправляться письма
        $mail->Password = 'SYw8AeJk2wXBdfxjdrAw'; // Ваш пароль от почты с которой будут отправляться письма
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465; // TCP port to connect to / этот порт может отличаться у других провайдеров

        $mail->setFrom('econur-applications@mail.ru'); // от кого будет уходить письмо?
        $mail->addAddress('econur2011@mail.ru');     // Кому будет уходить письмо 
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Заявка с сайта ЭкоНур';
        $mail->Body    = '' .$name . ' оставил заявку, его телефон ' .$phone;
        $mail->AltBody = '';

        if(!$mail->send()) {
            echo 'Error';
        }
        /////
        header("Location:$BASE_URL/index.php?success=1");
    }
    else {
        header("Location:$BASE_URL/index.php?error=1");
    }


?>