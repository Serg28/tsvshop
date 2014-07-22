<?php

	/*------------------------------------------------------------------------------------------------------*/
	//	Система построения сайтов "TANGO 2.0"
	//	Сласс разбора массива POST а также обеспечения общей безопасности приложения
	//	Версия: 1.0.0
	//	Автор: Камайкин Владимир Анатольевич
	//	Интеренет сайт: www.kamaikin.ru
	//	Email: kamaikin@gmail.com
	//	Date: 11.11.2006
	/*------------------------------------------------------------------------------------------------------*/
	/*------------------------------------МЕТОДЫ------------------------------------------------------*/
	//	
	/*------------------------------------------------------------------------------------------------------*/
	final class post_explode{
		static public $_post = array();
		static public $_get = array();
		public function __construct(){}
		static public function post_explode(){
			/*------------------------------------------------------------------------------------------------------*/
			//	Статическая функция обеспечения безопасности входящих данных
			/*------------------------------------------------------------------------------------------------------*/
			//	Добавим немного безопасности...

			//	Перегоняем массив POST в $_post
			foreach($_POST as $key=>$value)
			{
				$key=htmlspecialchars($key);
				if(is_array($value)){
					$value=$value;
					foreach($value as $key1=>$value1)
					{
						$key1=htmlspecialchars($key1);
						if(is_string($value1)){
							$value1=htmlspecialchars($value1);
						}elseif(is_int($value1)){
							$value1=(int)$value1;
						}
						self::$_post[$key][$key1]=$value1;
					}
				}elseif(is_string($value)){
					$value=htmlspecialchars($value);
					self::$_post[$key]=$value;
				}elseif(is_int($value)){
					$value=(int)$value;
					self::$_post[$key]=$value;
				}
			}

//---------

//	Перегоняем массив GET в $_get
			foreach($_GET as $key=>$value)
			{
				$key=htmlspecialchars($key);
				if(is_array($value)){
					$value=$value;
					foreach($value as $key1=>$value1)
					{
						$key1=htmlspecialchars($key1);
						if(is_string($value1)){
							$value1=htmlspecialchars($value1);
						}elseif(is_int($value1)){
							$value1=(int)$value1;
						}
						self::$_get[$key][$key1]=$value1;
					}
				}elseif(is_string($value)){
					$value=htmlspecialchars($value);
					self::$_get[$key]=$value;
				}elseif(is_int($value)){
					$value=(int)$value;
					self::$_get[$key]=$value;
				}
			}


//---------




			//	Убиваем POST и GET
			//$_POST=array();
			//$_GET=array();
		}
		public function __destruct(){}
	}
?>