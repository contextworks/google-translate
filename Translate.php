<?php
/**
 * Services_Google_Translate
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

require_once 'HTTP/Request2.php';
require_once 'Google_Translate/Languages.php';
require_once 'Google_Translate/Exception.php';

/**
 * Services_Google_Translate
 *
 * @package  Services_Google_Translate
 * @category Services
 * @author   Kerem Durmus <kerem@keremdurmus.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License  
 * @version  0.0.1
 * @link     http://github.com/krmdrms/google_translate/
 * @link     http://code.google.com/intl/en/apis/ajaxlanguage/documentation/#fonje
 */
class Services_Google_Translate
{
    /**
     * Google Translate API Url
     *
     * @var array $apiUrl
     */    
    private static $apiUrl = 'http://ajax.googleapis.com/ajax/services/language/';
    
    /**
     * Stores the available languages
     *
     * @see Google_Translate::loadLanguages()
     * @var array $availableLanguages
     */        
    private static $availableLanguages = array();
    
    /**
     * Instance of {@link HTTP_Request2}
     *
     * @var object $request
     */        
    private $request;
    
    /**
     * HTTP request method
     *
     * @var string $httpMethod
     */        
    protected $httpMethod = 'GET';
    
    /**
     * Stores language for translation
     *
     * @var array $language
     */            
    protected $language = array();

    /**
     * Stores text for translation
     *
     * @var array $text
     */            
    protected $text = array();

    /**
     * Google AJAX Search API key
     *
     * @var string $apiKey
     */        
    protected $apiKey;

    /**
     * Constructor
     */    
    public function __construct() 
    {
        $this->loadLanguages();
    }

    /**
     * Sets Google AJAX Search API key
     *
     * @param string $text
     * @return $this     
     */    
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }
    
    /**
     * Sets default http method. Default is GET
     *
     * @param string $method
     * @return $this     
     */      
    public function setMethod($method = 'GET')
    {
        $this->httpMethod = $method;
        return $this;
    }
    /**
     * Sets texts to be translated
     *
     * @param string $text
     * @return $this
     */    
    public function setText($text)
    {
        $this->text[] = array('q' => $text);
        return $this;
    }
    
    /**
     * Sets languages
     *
     * @param string $language
     */        
    public function translateTo($language)
    {
        if(isset(self::$availableLanguages[strtoupper($language)])) {
            $this->language[] = array('langpair' => '|'.self::$availableLanguages[strtoupper($language)]);
            return $this;
        }
        
        throw new Services_Google_Translate_Exception('Unsupported language');
    }

    /**
     * Translate given text(s) to given language(s)
     *
     * @see Google_Translate::execute()
     * @return object
     */        
    public function translate()
    {
        $queryString = '';
        $prefix = '&';
    
        foreach($this->text as $text) {
            foreach ($text as $k => $v) {
                $this->setQueryVariables($k, $v);
            }
        }
        
        foreach($this->language as $language) {
            foreach ($language as $k => $v) {
                $this->setQueryVariables($k, $v);
            }
        }        
        
        return $this->execute('translate', $this->queryString);
    }

    /**
     * Detects the language of given text
     *
     * @see Google_Translate::execute()
     * @return object
     */
    public function detect()
    {
        if(empty($this->text)) {
            throw new Services_Google_Translate_Exception('No text to translate');    
        }
        
        foreach($this->text as $text) {
            foreach ($text as $k => $v) {
                $this->setQueryVariables($k, $v);
            }
        }
        
        return $this->execute('detect', $this->queryString);
    }

    /**
     * Sends request
     *
     * @param string  $service
     * @param array   $params
     * @return array  json_decoded body
     **/
    
    private function execute($service, $queryString)
    {
        $request = new HTTP_Request2();
        try {
            $request->setMethod($this->httpMethod);
            $request->setHeader('Referer', $this->getHttpReferer());
            
            $url = self::$apiUrl . $service . '?v=1.0';
            
            if(isset($this->apiKey)) {
                $url .= '&key=' . $this->apiKey . '&';
            } else {
                $url .= '&';
            }
            
            $request->setUrl($url . substr($queryString,0, -1));
            $response = $request->send();
            
            if($response->getStatus() != 200) {
                throw new Services_Google_Translate_Exception('HTTP Error: ' . $response->getReasonPhrase());
            }
            
        } catch (HTTP_Request2_Exception $e) {
            throw new Services_Google_Translate_Exception($e->getMessage());
        }
        
        $decodedResponse = $this->decodeBody($request->send()->getBody());
        
        return $decodedResponse;
    }

    /**
     * Decodes json encoded string
     *
     * @param string $body
     * @return array json_decoded string
     */
    private function decodeBody($body)
    {
        return json_decode($body, true);
    }
    
    /**
     * Prepares query string 
     * Net_URL2 doesn't support multiple parameters with same name
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    private function setQueryVariables($name, $value)
    {
        $prefix = '&';
        $this->queryString .= "{$name}=" . urlencode($value) . "{$prefix}";    
    }
    
    /**
     * Loads available languages
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    private function loadLanguages()
    {
        self::$availableLanguages = Services_Google_Translate_Language::getLanguages();
    }
      
    private function getHttpReferer()
    {
        return isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';
    }
}