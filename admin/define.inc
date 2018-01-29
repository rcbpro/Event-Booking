<?php

defined('PS') ? NULL : define('PS', '/');
defined('DS') ? NULL : define('DS', '/');
defined('DOT') ? NULL : define('DOT', '.');
defined('EXT') ? NULL : define('EXT', '.php');
defined('WEB_PATH') ? NULL : define('WEB_PATH', 'http://'.$_SERVER['HTTP_HOST'].PS.'event_booking'.PS.'admin'.PS);
defined('LOCAL_WEB_PATH') ? NULL : define('LOCAL_WEB_PATH', 'http://'.$_SERVER['HTTP_HOST'].PS.'event_booking'.PS);
defined('DOC_ROOT') ? NULL : define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT'].'event_booking'.DS.'admin');
defined('LIBRARY_PATH') ? NULL : define('LIBRARY_PATH', DOC_ROOT.'library'.DS);
defined('CONTROLLER_PATH') ? NULL : define('CONTROLLER_PATH', DOC_ROOT.DS.'controllers'.DS);
defined('VIEW_PATH') ? NULL : define('VIEW_PATH', DOC_ROOT.DS.'views'.DS);
defined('PUBLIC_PATH') ? NULL : define('PUBLIC_PATH', DOC_ROOT.DS.'public'.DS);
defined('LAYOUT_PATH') ? NULL : define('LAYOUT_PATH', PUBLIC_PATH.'layouts'.DS);
defined('IMAGE_UPLOADED_PATH') ? NULL : define('IMAGE_UPLOADED_PATH', PUBLIC_PATH.'uploaded'); 
defined('IMAGE_UPLOADED_URL_PATH') ? NULL : define('IMAGE_UPLOADED_URL_PATH', WEB_PATH.'public'.PS.'uploaded'.PS); 
defined('DB_HOST') ? NULL : define('SERVER', 'localhost');
defined('DB_USER') ? NULL : define('USER', 'root');
defined('DB_PASSWORD') ? NULL : define('PWORD', '');
defined('DB_NAME') ? NULL: define('DBASE', 'coldplay_db');