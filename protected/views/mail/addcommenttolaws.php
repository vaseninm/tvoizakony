<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Получен комментарий на ваш законопроект</title>
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
                                                        <h2 style="font-family:Arial, Helvetica, sans-serif;font-size:24px;font-weight:lighter;">Здравствуйте, <?= $mail->data['model']->owner->profile->firstname ?> <?= $mail->data['model']->owner->profile->lastname ?></h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left:20px;padding-right:20px;font-family:Arial, Helvetica, sans-serif;font-size:12px;">
                                                        <p>Пользователь <a href="<?= Yii::app()->createAbsoluteUrl('user/profile', array('username'=>$mail->data['comment']->owner->username)); ?>" style="color:#135687;"><?= $mail->data['comment']->owner->profile->firstname ?> <?= $mail->data['comment']->owner->profile->lastname ?></a> добавил комментарий к вашему законопроекту на проекте "Твои Законы".</p>
                                                        <p style="font-size:14px;font-style:oblique; color:#5c5c5c;padding-top:10px;padding-bottom:10px;"><?= $mail->data['comment']->text ?></p>
                                                        <p>Чтобы ответить на комметарий перейдите по <a href="<?= Yii::app()->createAbsoluteUrl('laws/view', array('id'=>$mail->data['model']->id)); ?>#comment-<?=$mail->data['comment']->id ?>" style="color:#135687;">этой ссылке</a>.</p>
                                                        <p>Вы получили это электронное сообщение, так как являетесь зарегестрированным пользователем проекта "Твои Законы".</p>
                                                        <p>
														    <strong>С уважением,</strong><br>
                                                            <strong>команда "Твои Законы"</strong><br>
                                                            <a href="http://www.tvoizakony.ru" style="color:#135687;">http://www.tvoizakony.ru</a>
														</p>
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
