<?php

$container = $app->getContainer();

//add logging function to container
$container['logger'] =function($c) {
	$logger = new \Monolog\Logger('my_logger');
	$file_handler = new \Monolog\Handler\StreamHandler("logs/app.log");
	$logger->pushHandler($file_handler);
	return $logger;
};

//add pdo to container
$container['db'] = function ($c) {
	$db = $c['settings']['db'];
	$pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['name'], $db['username'], $db['password']);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	return $pdo;
};

$container['Mailer'] = function ($c) {
	$mailer = new PHPMailer;

	$mailer->IsSMTP();
	$mailer->Host = 'smtp.gmail.com';
	$mailer->SMTPAuth = true;
	$mailer->SMTPSecure = 'ssl';
	$mailer->SMTPDebug = 2;
	$mailer->Debugoutput = 'html';
	$mailer->Port = '465';
	$mailer->Username = 'msqueeg@gmail.com';
	$mailer->Password = '########';
	$mailer->isHTML(true);
	$mailer->setFrom('msqueeg@gmail.com');

	return new \HRM\Classes\Mailer($c->view,$mailer, $c->logger);
};