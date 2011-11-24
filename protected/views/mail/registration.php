<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Регистрация на проекте "Твои Законы"</title>
    </head>

    <body style="padding:0;margin:0;">
        <table cellpadding="0" cellspacing="0" width="100%" height="100%">
            <tbody>
                <tr>
                    <td>
                        <table align="center" bgcolor="ececec" cellpadding="0" cellspacing="0" width="700" summary="" style="padding-left:25px;padding-right:25px;padding-top:25px;">
                            <tbody>
                                <tr>
                                    <td>
                                        <table bgcolor="ffffff" cellpadding="0" cellspacing="0" width="650" summary="">
                                            <tbody>
                                                <tr>
                                                    <td><img src="http://www.prodomainer.ru/emails/header.jpg" alt="Твои Законы" width="650" height="172"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left:20px;padding-right:20px;">
                                                        <h2 style="font-family:Arial, Helvetica, sans-serif;font-size:24px;font-weight:lighter;">Здравствуйте, <?= $mail->data['user']->profile->firstname ?> <?= $mail->data['user']->profile->lastname ?></h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left:20px;padding-right:20px;font-family:Arial, Helvetica, sans-serif;font-size:12px;">
                                                        <p>Спасибо за регистрацию на нашем проекте <a href="http://www.tvoizakony.ru" style="color:#135687;">Твои Законы</a>.</p>
														<ul style="font-size:14px; color:#5c5c5c;padding-top:10px;padding-bottom:10px;">
															<li style="list-style:none;">Логин: <?= $mail->data['user']->username ?></li>
															<li style="list-style:none;">Пароль: тот который вы указали</li>
														</ul>
														<p>Если вы не регистрировались, то просто проигнорируйте это письмо.</p>
                                                        <p><strong>С уважением,</strong><br>
                                                            <strong>команда "Твои Законы"</strong><br>
                                                            <a href="http://www.tvoizakony.ru" style="color:#135687;">http://www.tvoizakony.ru</a></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table cellpadding="15" cellspacing="0" width="650">
                                            <tbody>
                                                <tr>
                                                    <td align="center"><img src="http://www.prodomainer.ru/emails/footer.jpg" alt="Твои Законы" width="260" height="40"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
