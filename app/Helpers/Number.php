<?php
/**
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Helpers;

class Number
{
	/**
	 * Converts a number into a short version, eg: 1000 -> 1k
	 *
	 * @param $number
	 * @param int $precision
	 * @return string
	 */
	public static function short($number, $precision = 1)
	{
		if ($number < 900) {
			// 0 - 900
			$numberFormat = number_format($number, $precision);
			$suffix = '';
		} else if ($number < 900000) {
			// 0.9k-850k
			$numberFormat = number_format($number / 1000, $precision);
			$suffix = 'K';
		} else if ($number < 900000000) {
			// 0.9m-850m
			$numberFormat = number_format($number / 1000000, $precision);
			$suffix = 'M';
		} else if ($number < 900000000000) {
			// 0.9b-850b
			$numberFormat = number_format($number / 1000000000, $precision);
			$suffix = 'B';
		} else {
			// 0.9t+
			$numberFormat = number_format($number / 1000000000000, $precision);
			$suffix = 'T';
		}
		
		// Remove unnecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
		// Intentionally does not affect partials, eg "1.50" -> "1.50"
		if ($precision > 0) {
			$dotZero = '.' . str_repeat('0', $precision);
			$numberFormat = str_replace($dotZero, '', $numberFormat);
		}
		
		return $numberFormat . $suffix;
	}
	
	/**
	 * Transform the given number to display it using the Currency format settings
	 * NOTE: Doesn't transform non-numeric value
	 *
	 * @param $number
	 * @return int|mixed|string
	 */
	public static function transform($number)
	{
		if (!is_numeric($number)) {
			return $number;
		}
		
		$number = self::format($number);
		
		return $number;
	}
	
	/**
	 * Transform the given number to display it using the Currency format settings
	 * NOTE: Transform non-numeric value
	 *
	 * @param $number
	 * @return mixed|string
	 */
	public static function format($number)
	{
		// Convert string to numeric
		$number = self::getFloatRawFormat($number);
		
		// Currency format - Ex: USD 100,234.56 | EUR 100 234,56
		$number = number_format(
			$number,
			(int)config('selectedCurrency.decimal_places', 2),
			config('selectedCurrency.decimal_separator', '.'),
			config('selectedCurrency.thousand_separator', ',')
		);
		
		return $number;
	}
	
	/**
	 * Get Float Raw Format
	 *
	 * @param $number
	 * @return mixed|string
	 */
	public static function getFloatRawFormat($number)
	{
		if (is_numeric($number)) {
			return $number;
		}
		
		$number = trim($number);
		$number = strtr($number, [' ' => '']);
		$number = preg_replace('/ +/', '', $number);
		$number = str_replace(',', '.', $number);
		$number = preg_replace('/[^0-9\.]/', '', $number);
		
		return $number;
	}
	
	/**
	 * @param $number
	 * @return int|mixed|string
	 */
	public static function money($number)
	{
		$number = self::applyCurrencyRate($number);
		
		if (config('settings.other.decimals_superscript')) {
			return static::moneySuperscript($number);
		}
		
		$number = self::transform($number);
		
		// In line current
		if (config('selectedCurrency.in_left') == 1) {
			$number = config('selectedCurrency.symbol') . $number;
		} else {
			$number = $number . ' ' . config('selectedCurrency.symbol');
		}
		
		// Remove decimal value if it's null
		$defaultDecimal = str_pad('', (int)config('selectedCurrency.decimal_places', 2), '0');
		$number = str_replace(config('selectedCurrency.decimal_separator', '.') . $defaultDecimal, '', $number);
		
		return $number;
	}
	
	/**
	 * @param $number
	 * @return int|mixed|string
	 */
	public static function moneySuperscript($number)
	{
		$number = self::transform($number);
		
		$tmp = explode(config('selectedCurrency.decimal_separator', '.'), $number);
		
		if (isset($tmp[1]) && !empty($tmp[1])) {
			if (config('selectedCurrency.in_left') == 1) {
				$number = config('selectedCurrency.symbol') . $tmp[0] . '<sup>' . $tmp[1] . '</sup>';
			} else {
				$number = $tmp[0] . '<sup>' . config('selectedCurrency.symbol') . $tmp[1] . '</sup>';
			}
		} else {
			if (config('selectedCurrency.in_left') == 1) {
				$number = config('selectedCurrency.symbol') . $number;
			} else {
				$number = $number . ' ' . config('selectedCurrency.symbol');
			}
			
			// Remove decimal value if it's null
			$defaultDecimal = str_pad('', (int)config('selectedCurrency.decimal_places', '2'), '0');
			$number = str_replace(config('selectedCurrency.decimal_separator', '.') . $defaultDecimal, '', $number);
		}
		
		return $number;
	}
	
	/**
	 * @param $number
	 * @return float|int
	 */
	public static function applyCurrencyRate($number)
	{
		if (is_numeric($number) || is_float($number)) {
			try {
				$number = $number * config('selectedCurrency.rate', 1);
			} catch (\Exception $e) {
				// Debug
			}
		}
		
		return $number;
	}
	
	/**
	 * @param null $locale
	 * @return array
	 */
	public static function getSeparators($locale = null)
	{
		if (empty($locale)) {
			$locale = config('app.locale');
		}
		
		$separators = [];
		$separators['thousand'] = (starts_with($locale, 'fr')) ? ' ' : ',';
		$separators['decimal'] = (starts_with($locale, 'fr')) ? ',' : '.';
		
		return $separators;
	}
	
	/**
	 * @param null $locale
	 * @return \Illuminate\Config\Repository|mixed|null
	 */
	public static function setLanguage($locale = null)
	{
		if (empty($locale)) {
			$locale = config('app.locale');
		}
		
		// Set locale
		setlocale(LC_ALL, $locale);
		
		return $locale;
	}
	
	/**
	 * @param $int
	 * @param $nb
	 * @return string
	 */
	public static function leadZero($int, $nb)
	{
		$diff = $nb - strlen($int);
		if ($diff <= 0) {
			return $int;
		} else {
			return str_repeat('0', $diff) . $int;
		}
	}
	
	/**
	 * @param $number
	 * @param $limit
	 * @return mixed
	 */
	public static function zeroPad($number, $limit)
	{
		return (strlen($number) >= $limit) ? $number : self::zeroPad("0" . $number, $limit);
	}
	
	/**
	 * @param $number
	 * @param int $decimals
	 * @return string
	 */
	public static function localeFormat($number, $decimals = 2)
	{
		self::setLanguage();
		
		$locale = localeconv();
		$number = number_format($number, $decimals, $locale['decimal_point'], $locale['thousands_sep']);
		
		return $number;
	}
	
	/**
	 * Clean Float Value
	 * Fixed: MySQL don't accept the comma format number
	 *
	 * This function takes the last comma or dot (if any) to make a clean float,
	 * ignoring thousand separator, currency or any other letter.
	 *
	 * Example:
	 * $num = '1.999,369€';
	 * var_dump(Number::toFloat($num)); // float(1999.369)
	 * $otherNum = '126,564,789.33 m²';
	 * var_dump(Number::toFloat($otherNum)); // float(126564789.33)
	 *
	 * @param $number
	 * @return float
	 */
	public static function toFloat($number)
	{
		$dotPos = strrpos($number, '.');
		$commaPos = strrpos($number, ',');
		$sepPos = (($dotPos > $commaPos) && $dotPos) ? $dotPos : ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
		
		if (!$sepPos) {
			$number = preg_replace('/[^0-9]/', '', $number);
			$number = floatval($number);
			
			return $number;
		}
		
		$integer = preg_replace('/[^0-9]/', '', substr($number, 0, $sepPos));
		$decimal = preg_replace('/[^0-9]/', '', substr($number, $sepPos + 1, strlen($number)));
		$number = intval($integer) . '.' . $decimal;
		
		return $number;
	}
}
