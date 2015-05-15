<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2015-05-14 21:12:48 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: google_href ~ APPPATH/views/login.php [ 6 ] in /home/anikulchin/git/n.sharein.ru/application/views/login.php:6
2015-05-14 21:12:48 --- DEBUG: #0 /home/anikulchin/git/n.sharein.ru/application/views/login.php(6): Kohana_Core::error_handler(8, 'Undefined varia...', '/home/anikulchi...', 6, Array)
#1 /home/anikulchin/git/n.sharein.ru/system/classes/Kohana/View.php(62): include('/home/anikulchi...')
#2 /home/anikulchin/git/n.sharein.ru/system/classes/Kohana/View.php(359): Kohana_View::capture('/home/anikulchi...', Array)
#3 /home/anikulchin/git/n.sharein.ru/system/classes/Kohana/View.php(236): Kohana_View->render()
#4 /home/anikulchin/git/n.sharein.ru/application/views/template.php(30): Kohana_View->__toString()
#5 /home/anikulchin/git/n.sharein.ru/system/classes/Kohana/View.php(62): include('/home/anikulchi...')
#6 /home/anikulchin/git/n.sharein.ru/system/classes/Kohana/View.php(359): Kohana_View::capture('/home/anikulchi...', Array)
#7 /home/anikulchin/git/n.sharein.ru/system/classes/Kohana/Controller/Template.php(44): Kohana_View->render()
#8 /home/anikulchin/git/n.sharein.ru/system/classes/Kohana/Controller.php(87): Kohana_Controller_Template->after()
#9 [internal function]: Kohana_Controller->execute()
#10 /home/anikulchin/git/n.sharein.ru/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Welcome))
#11 /home/anikulchin/git/n.sharein.ru/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#12 /home/anikulchin/git/n.sharein.ru/system/classes/Kohana/Request.php(997): Kohana_Request_Client->execute(Object(Request))
#13 /home/anikulchin/git/n.sharein.ru/index.php(118): Kohana_Request->execute()
#14 {main} in /home/anikulchin/git/n.sharein.ru/application/views/login.php:6