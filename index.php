<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Tuber Boy">
    <title>Automatically Solve Invisible ReCaptcha V2\3 - CaptchaSOLVER</title>
    <meta name="msapplication-TileColor" content="#786fff">
    <meta name="theme-color" content="#786fff">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<div class="header"><a href="">CaptchaSOLVER - (TUBER BOY)</a></div>
    <div class="box">
    <div class="title">CAPTCHA TOKEN GENERATOR</div>
    <div class="box">Copy and paste your targeted site captcha <b>Anchor</b> url and click on get token button.</div>
    <form method="post">
        <input type="url" name="anchor_url" placeholder="Enter Anchor URL *" autocomplete="off" required>
        <button name="get">GET TOKEN</button>
    </form>
    </div>
<?php
/**
 * mcCS - ReCaptcha V3 Invisible Solver
 *
 * @author Masud Rana
 * @version 0.01
 */
require_once __DIR__ . '/Captcha/solveCAPTCHA.php';

use mcCS\Captcha\solveCAPTCHA;

if(isset($_POST['get']))
{
    $anchor_url = $_POST['anchor_url'];
    preg_match('/k=(.+?)\&/', $anchor_url, $key);
    $captcha_key = $key[1];
    
    $mc = new solveCAPTCHA($anchor_url, $captcha_key);
    $token = $mc->getToken();
    $res = [
        'status' => 'success',
        'rresp' => $token
    ];
    
    echo '<div class="box"><div class="title">CAPTCHA TOKEN</div><textarea type="text">'.$token.'</textarea></div><div class="box"><div class="title">JSON DATA</div><textarea type="text">'.json_encode($res).'</textarea></div>';
}
?>
<div class="footer">&copy; Copyright <?php echo date('Y'); ?> - <a href="https://github.com/tuberboy">Tuber Boy</a> || <a href="https://tuberboy.com">TuberBoy.Com</a></div>
</body>
</html>