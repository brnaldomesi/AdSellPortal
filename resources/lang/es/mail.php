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
	'Whoops!' => 'Whoops!',
	'Hello!' => 'Hola!',
	'Regards' => 'Saludos',
	"If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\ninto your web browser: [:actionURL](:actionURL)" => "Si tienes problemas para hacer clic en el botón \":actionText\", copia y pega la URL a continuación\nen tu navegador web: [:actionURL](:actionURL)",
	'All rights reserved.' => 'Todos los derechos reservados.',
	
	
	// custom mail_footer (unused)
	'mail_footer_content'            => 'Vende y compra cerca de ti. Simple, rápido y eficiente.',
	
	
	// email_verification
	'email_verification_title'       => 'Por favor verifique su dirección de correo electrónico.',
	'email_verification_action'      => 'Confirme su dirección de correo electrónico',
	'email_verification_content_1'   => 'Hola :userName !',
	'email_verification_content_2'   => 'Haga clic en el botón de abajo para verificar su dirección de correo electrónico.',
	'email_verification_content_3'   => 'Has recibido este correo electrónico porque recientemente has creado una cuenta en :appName o agregaste una nueva dirección de correo electrónico. Si no fue usted, ignore este correo electrónico.',
	
	
	// post_activated
	'post_activated_title'             => 'Tu anuncio ha sido activado',
	'post_activated_content_1'         => 'Hola,',
	'post_activated_content_2'         => 'Tu anuncio <a href=":postUrl">:title</a> ha sido activado.',
	'post_activated_content_3'         => 'Pronto será examinado por uno de nuestros administradores para su publicación.',
	'post_activated_content_4'         => 'Has recibido este correo electrónico porque recientemente has creado una cuenta en :appName o agregaste una nueva dirección de correo electrónico. Si no fue usted, ignore este correo electrónico.',
	
	
	// post_reviewed
	'post_reviewed_title'              => 'Tu anuncio ya está activado',
	'post_reviewed_content_1'          => 'Hola,',
	'post_reviewed_content_2'          => 'Tu anuncio <a href=":postUrl">:title</a> ha sido activado.',
	'post_reviewed_content_3'          => 'Has recibido este correo electrónico porque recientemente has creado una cuenta en :appName o agregaste una nueva dirección de correo electrónico. Si no fue usted, ignore este correo electrónico.',
	
	
	// post_republished
	'post_republished_title'              => 'Your ad has been re-published',
	'post_republished_content_1'          => 'Hello,',
	'post_republished_content_2'          => 'Your ad <a href=":postUrl">:title</a> has been re-published successfully.',
	'post_republished_content_3'          => 'You\'re receiving this email because you recently created a new ad on :appName. If this wasn\'t you, please ignore this email.',
	
	
	// post_deleted
	'post_deleted_title'               => 'Tu anuncio ha sido eliminado',
	'post_deleted_content_1'           => 'Hola,',
	'post_deleted_content_2'           => 'Tu anuncio ":title" ha sido eliminado de <a href=":appUrl">:appName</a> hoy :now.',
	'post_deleted_content_3'           => 'Gracias por su confianza y hasta pronto.',
	'post_deleted_content_4'           => 'PS: Este es un correo electrónico automatizado, por favor no responda.',
	
	
	// post_seller_contacted
	'post_seller_contacted_title'      => 'Tu anuncio ":title" en :appName',
	'post_seller_contacted_content_1'  => '<strong>Información de contacto:</strong>
<br>Nombre: :name
<br>Correo electrónico: :email
<br>Número de teléfono: :phone',
	'post_seller_contacted_content_2'  => 'Este correo electrónico se le envió acerca del anuncio ":title" que usted tiene en :appName : <a href=":postUrl">:postUrl</a>',
	'post_seller_contacted_content_3'  => 'NOTE: La persona que contactó con usted no sabe su correo electrónico ya que no responderá.',
	'post_seller_contacted_content_4'  => 'Recuerde verificar siempre los detalles de la persona de contacto (nombre, dirección, ...) para asegurarse de tener un contacto en caso de disputa. En general, elija la entrega del artículo en la mano.',
	'post_seller_contacted_content_5'  => '¡Tenga cuidado con las ofertas atractivas! Tenga cuidado con las solicitudes del exterior cuando solo tiene un correo electrónico de contacto. La transferencia bancaria por Western Union o MoneyGram propuesta puede ser artificial.',
	'post_seller_contacted_content_6'  => 'Gracias por su confianza y hasta pronto.',
	'post_seller_contacted_content_7'  => 'PS: Este es un correo electrónico automatizado, por favor no responda.',
	
	
	// user_deleted
	'user_deleted_title'             => 'Tu cuenta ha sido eliminada de :appName',
	'user_deleted_content_1'         => 'Hola,',
	'user_deleted_content_2'         => 'Tu cuenta ha sido eliminada de <a href=":appUrl">:appName</a> hoy :now.',
	'user_deleted_content_3'         => 'Gracias por su confianza y hasta pronto.',
	'user_deleted_content_4'         => 'PS: Este es un correo electrónico automatizado, por favor no responda.',
	
	
	// user_activated
	'user_activated_title'           => 'Bienvenido a :appName !',
	'user_activated_content_1'       => 'Bienvenido a :appName :userName !',
	'user_activated_content_2'       => 'Tu cuenta ha sido activada.',
	'user_activated_content_3'       => '<strong>Nota: El equipo de :appName te recomienda:</strong>
<br><br>1 - Siempre tenga cuidado con los anunciantes que se niegan a hacerle ver lo bueno que se ofrece para la venta o alquiler,
<br>2 - Nunca envíe dinero por Western Union u otro mandato internacional.
<br><br>Si tiene alguna duda sobre la seriedad de un anunciante, contáctenos inmediatamente. Luego podemos neutralizar lo más rápido posible y evitar que alguien menos informado se convierta en la víctima.',
	'user_activated_content_4'       => 'Has recibido este correo electrónico porque recientemente has creado una cuenta en :appName o agregaste una nueva dirección de correo electrónico. Si no fue usted, ignore este correo electrónico.',
	
	
	// reset_password
	'reset_password_title'           => 'Restablecer su contraseña',
	'reset_password_action'          => 'Restablecer contraseña',
	'reset_password_content_1'       => '¿Olvidaste tu contraseña?',
	'reset_password_content_2'       => 'Vamos a darte una nueva.',
	'reset_password_content_3'       => 'Si no solicitó un restablecimiento de contraseña, no se requiere ninguna acción adicional.',
	
	
	// contact_form
	'contact_form_title'             => 'Nuevo mensaje de :appName',
	
	
	// post_report_sent
	'post_report_sent_title'           => 'Nuevo informe de abuso',
	'Post URL'                         => 'Enlace del anuncio',
	
	
	// post_archived
	'post_archived_title'              => 'Tu anuncio ha sido archivado',
	'post_archived_content_1'          => 'Hola,',
	'post_archived_content_2'          => 'Tu anuncio ":title" ha sido archivado en :appName hoy :now.',
	'post_archived_content_3'          => 'Puede volver a publicar el anuncio, haciendo clic aquí: <a href=":repostUrl">:repostUrl</a>',
	'post_archived_content_4'          => 'Si no haces nada, tu anuncio se eliminará permanentemente el :dateDel.',
	'post_archived_content_5'          => 'Gracias por su confianza y hasta pronto.',
	'post_archived_content_6'          => 'PS: Este es un correo electrónico automatizado, por favor no responda.',
	
	
	// post_will_be_deleted
	'post_will_be_deleted_title'       => 'Su anuncio será eliminado en :days dias',
	'post_will_be_deleted_content_1'   => 'Hola,',
	'post_will_be_deleted_content_2'   => 'Tu anuncio ":title" será eliminado de :appName en :days dias.',
	'post_will_be_deleted_content_3'   => 'Puede volver a publicar el anuncio, haciendo clic aquí: <a href=":repostUrl">:repostUrl</a>',
	'post_will_be_deleted_content_4'   => 'Si no haces nada, tu anuncio se eliminará permanentemente el :dateDel.',
	'post_will_be_deleted_content_5'   => 'Gracias por su confianza y hasta pronto.',
	'post_will_be_deleted_content_6'   => 'PS: Este es un correo electrónico automatizado, por favor no responda.',
	
	
	// post_notification
	'post_notification_title'          => 'Un nuevo anuncio ha sido publicado',
	'post_notification_content_1'      => 'Hola Admin,',
	'post_notification_content_2'      => 'El usuario :advertiserName acaba de publicar un anuncio nuevo.',
	'post_notification_content_3'      => 'El título del anuncio: <a href=":postUrl">:title</a><br>Publicado: :now a :time',
	
	
	// user_notification
	'user_notification_title'        => 'Registro de nuevo usuario',
	'user_notification_content_1'    => 'Hola Admin,',
	'user_notification_content_2'    => ':name acaba de registrarse.',
	'user_notification_content_3'    => 'Registrado: :now a :time<br>Correo electrónico: <a href="mailto::email">:email</a>',
	
	
	// payment_sent
	'payment_sent_title'             => 'Gracias por su pago!',
	'payment_sent_content_1'         => 'Hola,',
	'payment_sent_content_2'         => 'Hemos recibido el pago por el anuncio "<a href=":postUrl">:title</a>".',
	'payment_sent_content_3'         => 'Gracias!',
	
	
	// payment_notification
	'payment_notification_title'     => 'Se ha hecho un nuevo pago',
	'payment_notification_content_1' => 'Hola Admin,',
	'payment_notification_content_2' => 'El usuario :advertiserName acaba de pagar un paquete por el anuncio "<a href=":postUrl">:title</a>".',
	'payment_notification_content_3' => 'LOS DETALLES DEL PAGO
<br><strong>Motivo del pago:</strong> Anuncio #:adId - :packageName
<br><strong>Cantidad:</strong> :amount :currency
<br><strong>Método de pago:</strong> :paymentMethodName',
	
	
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
	'reply_form_content_1'           => 'Hola,',
	'reply_form_content_2'           => '<strong>Has recibido una respuesta de: :senderName. Vea el mensaje a continuación:</strong>',


];