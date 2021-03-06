<?php
/**
 * Site class
 *
 * @author Mikhail Miropolskiy <the-ms@ya.ru>
 * @package Lib
 * @copyright (c) 2012. Mikhail Miropolskiy. All Rights Reserved.
 */
class Utils {

	/**
	 * @param $array
	 * @return mixed Random element of given array
	 */
	static function arrayRandomElement($array) {
		$i = rand(0, count($array)-1);
		return $array[$i];
	}

	/**
	 * @param string $dir Path to dir
	 * @return array Files of dir
	 */
	static function readDir($dir)	{
		$files = array();
		$dh = @opendir($dir);
		if (!$dh) exit('Невозможно прочитать директорию ' . $dir);

		while (false !== ($filename = readdir($dh)))
			if ($filename != '.' && $filename != '..') $files[] = $filename;

		sort($files);

		return $files;
	}

	/**
	 * Wrapper for preg_match_all
	 * @param string $regexp
	 * @param string $source Text to parse
	 * @param string $mod Regexp modifier
	 * @return array|bool Array of matches or false
	 */
	static function matchAll($regexp, $source, $mod = 'sU') {
		$num = preg_match_all('/' . $regexp . '/' . $mod, $source, $matches);
		return ($num) ? $matches[1] : false;
	}

	/**
	 * @return string Password
	 */
	static function generatePassword() {
		$password = array();
		for ($i=1; $i<=5; $i++) $password[] = chr(rand(65, 90));
		for ($i=1; $i<=3; $i++) $password[] = chr(rand(97, 122));
		for ($i=1; $i<=5; $i++) $password[] = chr(rand(48, 57));

		shuffle($password);

		return implode('', $password);
}

	/**
	 * Convert phones to common format
	 * @param string $userPhones
	 * @return string Converted phones
	 */
	static function preparePhones($userPhones) {
		if ($userPhones == '' || strlen($userPhones) < 7) return $userPhones;
		$result = array();
		$phonesMultiline = str_replace(array(',', ';'), "\n", $userPhones);
		$phones_array = explode("\n", $phonesMultiline);
		foreach ($phones_array as $user_phone) {
			$phone = preg_replace('/\D/', '', $user_phone);
			$firstDigit = substr($phone, 0, 1);
			if ($firstDigit == '7' || $firstDigit == '8') $phone = substr($phone, 1);
			if (strpos($phone, '383') === 0) $phone = substr($phone, 3);
			switch (strlen($phone)) {
				case 7:
					$phone = '(383) ' . substr($phone, 0, 3) . '-' . substr($phone, 3, 2) . '-' . substr($phone, -2);
					break;
				case 10:
					if (strpos($phone, '800') === 0) {
						$phone = '8 800 ' . substr($phone, 3, 3) . '-' . substr($phone, -4, 2) . '-' . substr($phone, -2);
					} else {
						$phone = '+7 ' . substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . '-' . substr($phone, -4, 2) . '-' . substr($phone, -2);
					}
					break;
				default: $phone = $user_phone;
			}
			$result[] = $phone;
		}
		return implode(", ", $result);
	}
}