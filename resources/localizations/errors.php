<?php
return array(

	'ru' => [
		'http' => [
			'forbidden_acces' => "Доступ запрещён",
			'user_not_found'  => "Пользователь не найден",
		],
		'login_validation' => [
			'email'    => "Введите корректный email",
			'password' => "Длина пароля от 7 до 35, разрешены английские символы, цифры и знак нижнего подчёркивания",
		],
		'login_auth' => [
			'email'    => "Введённый email не существует",
			'password' => "Пароль не верен",
		],
		'register_validation' => [
			'email'    => "Введите корректный email",
			'nickname' => "Длина никнейма от 5 до 30, разрешены английские символы, цифры и знак нижнего подчёркивания",
			'password' => "Длина пароля от 7 до 35, разрешены английские символы, цифры и знак нижнего подчёркивания",
			'confirm_password' => "Пароли должны совпадать",
			'image' => [
				'load_fail' => "Во время загрузки изобаржения возникла ошибка",
				'unsupported_format' => "Разрешены изобаржения формата .png .jpg .jpeg .gif c разрешением не более 1280 на 768",
				'not_included' => "Необходимо загрузить изображение",
			],
			'email_exists' => "Введённый email уже существует",
		],
		'registration_fail' => "Ошибка регистрации",
	],

	'en' => [
		'http' => [
			'forbidden_acces' => "Access forbidden",
			'user_not_found'  => "User not found",
		],
		'login_validation' => [
			'email'    => "Enter correct email",
			'password' => "The password's length should have from 7 to 35 characters. English characters, digits and underscore are allowed",
		],
		'login_auth' => [
			'email'    => "The entered email does not exist",
			'password' => "Wrong password",
		],
		'register_validation' => [
			'email'    => "Enter correct email",
			'nickname' => "The nickname's length should have from 5 to 30 characters, english characters, digitals and underscore are allowed",
			'password' => "The password's length should have from 7 to 35 characters, english characters, digitals and underscore are allowed",
			'confirm_password' => "The passwords should be equal",
			'image' => [
				'load_fail' => "There was error occured during the image loading",
				'unsupported_format' => "The images of such formats as .png .jpg .jpeg .gif with less than 1280*768 resolution are allowed",
				'not_included' => "Image is required",
			],
			'email_exists' => "The entered email already exists",
		],
		'registration_fail' => "Registration Error",
	], 
);