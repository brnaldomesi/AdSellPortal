<?php

return [
	
	/*
	|--------------------------------------------------------------------------
	| Emails Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used by the Mail notifications.
	|
	*/
	
	// built-in template
	'Whoops!' => 'Возгласы!',
	'Hello!' => 'Привет!',
	'Regards' => 'С уважением',
	"If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\ninto your web browser: [:actionURL](:actionURL)" => "Если у вас возникли проблемы с нажатием кнопки \":actionText\", скопируйте и вставьте URL-адрес ниже\nв ваш веб-браузер: [:actionURL](:actionURL)",
	'All rights reserved.' => 'Все права защищены.',
	
	
	// custom mail_footer (unused)
	'mail_footer_content'            => 'Продавайте и покупайте с нами. Просто, быстро и эффективно.',
	
	
	// email_verification
	'email_verification_title'       => 'Пожалуйста подтвердите ваш адрес электронной почты.',
	'email_verification_action'      => 'Подтвердите адрес электронной почты',
	'email_verification_content_1'   => 'Здравствуйте :userName !',
	'email_verification_content_2'   => 'Нажмите кнопку ниже, чтобы подтвердить свой адрес электронной почты..',
	'email_verification_content_3'   => 'You’re Вы получили это письмо, потому что недавно вы создали новый:appName аккаунт или добавили новый адрес электронной почты. Если это не вы, пожалуйста, проигнорируйте это письмо.',
	
	
	// post_activated
	'post_activated_title'             => 'Ваше объявление активировано',
	'post_activated_content_1'         => 'Здравствуйте,',
	'post_activated_content_2'         => 'Ваше объявление <a href=":postUrl">:title</a> было активировано.',
	'post_activated_content_3'         => 'Вскоре оно будет рассмотрено одним из наших администраторов для его публикации на сайте.',
	'post_activated_content_4'         => 'Вы получили это письмо, потому что недавно разместили новое объявление на :appName. Если это не вы, пожалуйста, проигнорируйте это письмо.',
	
	
	// post_reviewed
	'post_reviewed_title'              => 'Ваше объявление сейчас в сети',
	'post_reviewed_content_1'          => 'Здравствуйте,',
	'post_reviewed_content_2'          => 'Ваше объявление <a href=":postUrl">:title</a> уже в сети.',
	'post_reviewed_content_3'          => 'Вы получили это письмо, потому что недавно разместили новое объявление на :appName. Если это не вы, пожалуйста, проигнорируйте это письмо.',
	
	
	// post_republished
	'post_republished_title'              => 'Your ad has been re-published',
	'post_republished_content_1'          => 'Hello,',
	'post_republished_content_2'          => 'Your ad <a href=":postUrl">:title</a> has been re-published successfully.',
	'post_republished_content_3'          => 'You\'re receiving this email because you recently created a new ad on :appName. If this wasn\'t you, please ignore this email.',
	
	
	// post_deleted
	'post_deleted_title'               => 'Ваше объявление было удалено',
	'post_deleted_content_1'           => 'Здравствуйте,',
	'post_deleted_content_2'           => 'Ваше объявление ":title"Было удалено с <a href=":appUrl">:appName</a> в :now.',
	'post_deleted_content_3'           => 'Спасибо за ваше доверие и скоро увидимся.',
	'post_deleted_content_4'           => 'PS: Это автоматическая электронная почта, пожалуйста, не отвечайте.',
	
	
	// post_seller_contacted
	'post_seller_contacted_title'      => 'Ваше объявление ":title" на :appName',
	'post_seller_contacted_content_1'  => '<strong>Контактная информация:</strong>
<br>Имя: :name
<br>Электронный адрес: :email
<br>Номер телефона: :phone',
	'post_seller_contacted_content_2'  => 'Это письмо было отправлено вам по поводу объявления ":title" you filed on :appName : <a href=":postUrl">:postUrl</a>',
	'post_seller_contacted_content_3'  => 'ПРИМЕЧАНИЕ: Лицо, связавшееся с вами, не знает вашу электронную почту, поскольку вы не будете отвечать.',
	'post_seller_contacted_content_4'  => 'Не забудьте всегда проверять информацию своего контактного лица (имя, адрес, ...), чтобы убедиться, что у вас есть контакт в случае открытия спора. По умолчанию, выберите поставку товара лично в руки.',
	'post_seller_contacted_content_5'  => 'Остерегайтесь заманчивых предложений! Будьте осторожны с запросами из-за рубежа, когда у вас есть только контактный адрес. Банковский перевод, предложенный Western Union или MoneyGram, может быть несуществующим.',
	'post_seller_contacted_content_6'  => 'Спасибо за ваше доверие и скоро увидимся.',
	'post_seller_contacted_content_7'  => 'PS: Это автоматическая электронная почта, пожалуйста, не отвечайте.',
	
	
	// user_deleted
	'user_deleted_title'             => 'Ваша учетная запись была удалена :appName',
	'user_deleted_content_1'         => 'Здравствуйте,',
	'user_deleted_content_2'         => 'Ваша учетная запись была удалена с <a href=":appUrl">:appName</a> at :now.',
	'user_deleted_content_3'         => 'Спасибо за ваше доверие и скоро увидимся.',
	'user_deleted_content_4'         => 'PS: Это автоматическая электронная почта, пожалуйста, не отвечайте.',
	
	
	// user_activated
	'user_activated_title'           => 'Добро пожаловать :appName !',
	'user_activated_content_1'       => 'Добро пожаловать :appName :userName !',
	'user_activated_content_2'       => 'Ваша учетная запись активирована.',
	'user_activated_content_3'       => '<strong>Помните : :appName Наша команда рекомендует чтоб Вы:</strong>
<br><br>1 - Всегда остерегались рекламодателей, которые отказываются показывать вам хорошее предложение для продажи или аренды,
<br>2 -Никогда не отправляйте деньги через Western Union или другой международный мандат.
<br><br>Если у вас есть сомнения относительно серьезности рекламодателя, немедленно свяжитесь с нами. Мы сделаем все возможное чтоб защитить вас чтоб вы не стали жертвой обмана.',
	'user_activated_content_4'       => 'Вы получаете это письмо, потому что недавно создали новый:appName акаунт. Если это не вы, пожалуйста, проигнорируйте это письмо.',
	
	
	// reset_password
	'reset_password_title'           => 'Сбросить пароль',
	'reset_password_action'          => 'Сбросить пароль',
	'reset_password_content_1'       => 'Забыли пароль?',
	'reset_password_content_2'       => 'Создайте новый пароль.',
	'reset_password_content_3'       => 'Если вы не запросили сброс пароля, никаких дополнительных действий не требуется.',
	
	
	// contact_form
	'contact_form_title'             => 'Новое сообщение - :appName',
	
	
	// post_report_sent
	'post_report_sent_title'           => 'Новый отчет о злоупотреблениях',
	'Post URL'                         => 'Вставьте URL',
	
	
	// post_archived
	'post_archived_title'              => 'Ваше объявление было заархивировано',
	'post_archived_content_1'          => 'Здравствуйте,',
	'post_archived_content_2'          => 'Ваше объявление ":title" было заархивировано с :appName в :now.',
	'post_archived_content_3'          => 'Вы можете отправить его, нажав здесь. : <a href=":repostUrl">:repostUrl</a>',
	'post_archived_content_4'          => 'Если вы ничего не сделаете, ваше объявление будет удалено навсегда :dateDel.',
	'post_archived_content_5'          => 'Спасибо за ваше доверие и скоро увидимся.',
	'post_archived_content_6'          => 'ПС: Это автоматическая электронная почта, пожалуйста, не отвечайте.',
	
	
	// post_will_be_deleted
	'post_will_be_deleted_title'       => 'Ваше объявление будет удалено через :days days',
	'post_will_be_deleted_content_1'   => 'Здравствуйте,',
	'post_will_be_deleted_content_2'   => 'Ваше объявление ":title" будет удалено через :days days с :appName.',
	'post_will_be_deleted_content_3'   => 'Вы можете отправить его, нажав здесь. : <a href=":repostUrl">:repostUrl</a>',
	'post_will_be_deleted_content_4'   => 'Если вы ничего не сделаете, ваше объявление будет удалено навсегда :dateDel.',
	'post_will_be_deleted_content_5'   => 'Спасибо за ваше доверие и скоро увидимся.',
	'post_will_be_deleted_content_6'   => 'PS: Это автоматическая электронная почта, пожалуйста, не отвечайте.',
	
	
	// post_notification
	'post_notification_title'          => 'Новое объявление опубликовано',
	'post_notification_content_1'      => 'Привет, Admin,',
	'post_notification_content_2'      => 'Пользователь :advertiserName только что опубликовал новое объявление.',
	'post_notification_content_3'      => 'Название объявления: <a href=":postUrl">:title</a><br>опубликовано на: :now at :time',
	
	
	// user_notification
	'user_notification_title'        => 'Регистрация нового пользователя',
	'user_notification_content_1'    => 'Привет, Admin,',
	'user_notification_content_2'    => ':name только что зарегистрировался.',
	'user_notification_content_3'    => 'Зарегистрировано: :now по :time<br>Электронному адресу: <a href="mailto::email">:email</a>',
	
	
	// payment_sent
	'payment_sent_title'             => 'Спасибо за ваш платеж!',
	'payment_sent_content_1'         => 'Здравствуйте,',
	'payment_sent_content_2'         => 'Мы получили оплату за объявление "<a href=":postUrl">:title</a>".',
	'payment_sent_content_3'         => 'Спасибо!',
	
	
	// payment_notification
	'payment_notification_title'     => 'Новый платеж отправлен',
	'payment_notification_content_1' => 'Привет, Admin,',
	'payment_notification_content_2' => 'Пользователь :advertiserName только что заплатил пакет за ее объявление "<a href=":postUrl">:title</a>".',
	'payment_notification_content_3' => 'ДЕТАЛИ ОПЛАТЫ
<br><strong>Причина оплаты:</strong> Объявление #:adId - :packageName
<br><strong>Сумма:</strong> :amount :currency
<br><strong>Способ оплаты:</strong> :paymentMethodName',
	
	
	// payment_approved (new)
	'payment_approved_title'     => 'Your payment has been approved!',
	'payment_approved_content_1' => 'Hello,',
	'payment_approved_content_2' => 'Your payment for the ad "<a href=":postUrl">:title</a>" has been approved.',
	'payment_approved_content_3' => 'Thank you!',
	'payment_approved_content_4' => 'THE PAYMENT DETAILS
<br><strong>Reason of the payment:</strong> Ad #:adId - :packageName
<br><strong>Amount:</strong> :amount :currency
<br><strong>Payment Method:</strong> :paymentMethodName',
	
	
	// reply_form
	'reply_form_title'               => ':subject',
	'reply_form_content_1'           => 'Здравствуйте,',
	'reply_form_content_2'           => '<strong>Вы получили ответ от: :senderName. Смотрите Сообщение ниже:</strong>',


];
