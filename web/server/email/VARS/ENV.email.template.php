<?php

// Remember to rename this file to "ENV.email.secret.php"!

// system@ender.ing
global $__SMTP_SYSTEM_SERVER__, $__SMTP_SYSTEM_APP_PASSWORD__, $__SMTP_SYSTEM_ADDRESS__, $__SMTP_SYSTEM_NAME__;

$__SMTP_SYSTEM_SERVER__ = "mx.example.net";
$__SMTP_SYSTEM_APP_PASSWORD__ = 'XXXXXXXXXXXXXXXX';
$__SMTP_SYSTEM_ADDRESS__ = 'do-not-reply@ender.ing';
$__SMTP_SYSTEM_NAME__ = 'Ender (ender.ing)';


// NOTE: Move the code below to "ENV.email.php"
// System Mail Footer
global $__SMTP_HTML_START__, $__SMTP_HTML_END__;

$__SMTP_HTML_START__ = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Noto+Sans+Display:ital,wght@0,100..900;1,100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap");

        @font-face {
            font-family: "SansFallback";
            src: local("Noto Sans"),
                local("Arial"),
                local("Helvetica"),
                local("sans-serif");
        }

        :root {
            --message-width: 500px;
            --message-height: 300px;
        }

        .content {
            display: flex;
            font-size: 16px;
            text-align: center;
            width: fit-content;
            height: fit-content;
            padding: 12px 12px;
            border: solid 1px black;
            margin: 12px auto;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: var(--message-width);
            min-height: var(--message-height);
        }

        .title {
            font-family: "Noto Sans Display", "SansFallBack";
            font-size: 18px;
            font-weight: bold;
        }

        .text {
            font-family: "Noto Sans", "SansFallBack";
            font-size: 16px;
            font-weight: normal;
        }

        .footer {
            text-align: center;
            margin: 10px auto;
            font-size: 12px;
            font-family: "Noto Sans", "SansFallBack";
            opacity: .8;
            width: var(--message-width);
        }

        .footer p {
            display: block;
            margin: 4px auto;
        }
    </style>
</head>

<body>
    <div class="content">
';
$__SMTP_HTML_END__ = '
    </div>
    <footer class="footer">
        <p>This message has been sent through <b><a href="https://ender.ing/" target="_blank">ender.ing</a></b>!</p>
        <p>To manage your email preferences, you can visit your <a
                href="https://links.ender.ing/account/email-preferences" target="_blank">Account Console</a>.</p>
        <p>If you suspect abuse of our mailing system, please contact us at <a href="mailto:abuse@ender.ing"
                target="_blank">abuse@ender.ing</a></p>
    </footer>
</body>

</html>
';

?>