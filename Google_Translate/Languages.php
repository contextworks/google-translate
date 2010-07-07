<?php
/**
 * Services_Google_Translate_Language
 *
 * PHP Version 5
 *
 * Copyright (c) 2010, Kerem Durmus
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice, 
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice, 
 *   this list of conditions and the following disclaimer in the documentation 
 *   and/or other materials provided with the distribution.
 * - Neither the name of the Digg, Inc. nor the names of its contributors 
 *   may be used to endorse or promote products derived from this software 
 *   without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package  Services_Google_Translate
 * @category Services
 * @author   Kerem Durmus <kerem@keremdurmus.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License  
 * @version  0.0.1
 * @link     http://github.com/krmdrms/google_translate/
 * @link     http://code.google.com/intl/en/apis/ajaxlanguage/documentation/#fonje
 */

/**
 * Services_Google_Translate_Language
 *
 * @package  Services_Google_Translate
 * @category Services 
 * @author   Kerem Durmus <kerem@keremdurmus.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License  
 * @version  0.0.1
 * @link     http://github.com/krmdrms/google_translate/
 * @link     http://code.google.com/intl/en/apis/ajaxlanguage/documentation/#fonje
 */
class Services_Google_Translate_Language
{
	private static $availableLanguages = array(
		'AFRIKAANS' => 'af',
		'ALBANIAN' => 'sq',
		'AMHARIC' => 'am',
		'ARABIC' => 'ar',
		'ARMENIAN' => 'hy',
		'AZERBAIJANI' => 'az',
		'BASQUE' => 'eu',
		'BELARUSIAN' => 'be',
		'BENGALI' => 'bn',
		'BIHARI' => 'bh',
		'BRETON' => 'br',
		'BULGARIAN' => 'bg',
		'BURMESE' => 'my',
		'CATALAN' => 'ca',
		'CHEROKEE' => 'chr',
		'CHINESE' => 'zh',
		'CHINESE_SIMPLIFIED' => 'zh-CN',
		'CHINESE_TRADITIONAL' => 'zh-TW',
		'CORSICAN' => 'co',
		'CROATIAN' => 'hr',
		'CZECH' => 'cs',
		'DANISH' => 'da',
		'DHIVEHI' => 'dv',
		'DUTCH' => 'nl',  
		'ENGLISH' => 'en',
		'ESPERANTO' => 'eo',
		'ESTONIAN' => 'et',
		'FAROESE' => 'fo',
		'FILIPINO' => 'tl',
		'FINNISH' => 'fi',
		'FRENCH' => 'fr',
		'FRISIAN' => 'fy',
		'GALICIAN' => 'gl',
		'GEORGIAN' => 'ka',
		'GERMAN' => 'de',
		'GREEK' => 'el',
		'GUJARATI' => 'gu',
		'HAITIAN_CREOLE' => 'ht',
		'HEBREW' => 'iw',
		'HINDI' => 'hi',
		'HUNGARIAN' => 'hu',
		'ICELANDIC' => 'is',
		'INDONESIAN' => 'id',
		'INUKTITUT' => 'iu',
		'IRISH' => 'ga',
		'ITALIAN' => 'it',
		'JAPANESE' => 'ja',
		'JAVANESE' => 'jw',
		'KANNADA' => 'kn',
		'KAZAKH' => 'kk',
		'KHMER' => 'km',
		'KOREAN' => 'ko',
		'KURDISH' => 'ku',
		'KYRGYZ' => 'ky',
		'LAO' => 'lo',
		'LATIN' => 'la',
		'LATVIAN' => 'lv',
		'LITHUANIAN' => 'lt',
		'LUXEMBOURGISH' => 'lb',
		'MACEDONIAN' => 'mk',
		'MALAY' => 'ms',
		'MALAYALAM' => 'ml',
		'MALTESE' => 'mt',
		'MAORI' => 'mi',
		'MARATHI' => 'mr',
		'MONGOLIAN' => 'mn',
		'NEPALI' => 'ne',
		'NORWEGIAN' => 'no',
		'OCCITAN' => 'oc',
		'ORIYA' => 'or',
		'PASHTO' => 'ps',
		'PERSIAN' => 'fa',
		'POLISH' => 'pl',
		'PORTUGUESE' => 'pt',
		'PORTUGUESE_PORTUGAL' => 'pt-PT',
		'PUNJABI' => 'pa',
		'QUECHUA' => 'qu',
		'ROMANIAN' => 'ro',
		'RUSSIAN' => 'ru',
		'SANSKRIT' => 'sa',
		'SCOTS_GAELIC' => 'gd',
		'SERBIAN' => 'sr',
		'SINDHI' => 'sd',
		'SINHALESE' => 'si',
		'SLOVAK' => 'sk',
		'SLOVENIAN' => 'sl',
		'SPANISH' => 'es',
		'SUNDANESE' => 'su',
		'SWAHILI' => 'sw',
		'SWEDISH' => 'sv',
		'SYRIAC' => 'syr',
		'TAJIK' => 'tg',
		'TAMIL' => 'ta',
		'TATAR' => 'tt',
		'TELUGU' => 'te',
		'THAI' => 'th',
		'TIBETAN' => 'bo',
		'TONGA' => 'to',
		'TURKISH' => 'tr',
		'UKRAINIAN' => 'uk',
		'URDU' => 'ur',
		'UZBEK' => 'uz',
		'UIGHUR' => 'ug',
		'VIETNAMESE' => 'vi',
		'WELSH' => 'cy',
		'YIDDISH' => 'yi',
		'YORUBA' => 'yo',
		'UNKNOWN' => ''
	);
	
	public static function getLanguages()
	{
		return self::$availableLanguages;
	}
}