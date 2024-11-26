<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $msg = '';
    $msgClass = '';
    if(filter_has_var(INPUT_POST, 'submit')){
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        //validation
        if(!empty($name) && !empty($email) && !empty($message)){
            if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                $msg = 'Please use a valid email.';
                $msgClass = 'alert-danger';
            }else{
            $mail = new PHPMailer(true);
            try {
                    // SMTP Configuration
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = 'abidul.haque@samarth.ac.in'; // Your Gmail address
                    $mail->Password = 'xxxx xxxx xxxx'; // Your Gmail app password (not your main password)
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS
                    $mail->Port = 587;

                    // Email Content
                    $mail->setFrom('abidul.haque@samarth.ac.in', 'Abidul Haque'); // Sender info
                    $mail->addAddress($email, $name); // Recipient info

                    $mail->isHTML(true);
                    $mail->Subject = 'Contact Request from ' . $name;
                    $mail->Body = '
                        <h2>Contact Request</h2>
                        <h4>Name</h4><p>' . $name . '</p>
                        <h4>Email</h4><p>' . $email . '</p>
                        <h4>Message</h4><p>' . $message . '</p>
                    ';
                    $mail->AltBody = strip_tags($mail->Body);

                    // Send the email
                    $mail->send();
                    $msg = 'Your email has been sent';
                    $msgClass = 'alert-success';
                } catch (Exception $e) {
                    $msg = 'Your email could not be sent. ' . $mail->ErrorInfo;
                    $msgClass = 'alert-danger';
                }
            }
        }else{
            $msg = 'Please fill in all the fields.';
            $msgClass = 'alert-danger';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Contact Form</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">My Website</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
            <a class="nav-link active" href="#">Home
                <span class="visually-hidden">(current)</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
            </li>
        </ul>
        <form class="d-flex">
            <input class="form-control me-sm-2" type="search" placeholder="Search">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>
        </div>
    </div>
    </nav>
    <div class="container">
        <?php if($msg != ''): ?>
            <div class="alert <?= $msgClass ?> mt-2">
                <?= $msg ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label>Name</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    value="<?= isset($_POST['name']) ? $name : '' ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input 
                    type="text" 
                    name="email" 
                    class="form-control" 
                    value="<?= isset($_POST['email']) ? $email : '' ?>">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" class="form-control"><?= isset($_POST['message']) ? $message : '' ?></textarea>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">
                Submit
            </button>
        </form>
    </div>

</body>
</html>