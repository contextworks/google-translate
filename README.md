Google Translate API wrapper for PHP
====================================

This package uses HTTP_Request2 PEAR library

    $ sudo pear install Net_URL2-0.3.1
    $ sudo pear install HTTP_Request2-0.5.2

### Detect language of a given text

    require_once 'Translate.php';
    try {        
        $translate = new Services_Google_Translate();
        $translate->setApiKey('google_search_api_key');
        $response = $translate->detect('Hello World');
        
        var_dump($response);
    } catch (Services_Google_Translate_Exception $e) {
        echo $e->getMessage();
    }
    
### Translate

    require_once 'Translate.php';
    try {
    $translate = new Services_Google_Translate();
    $translate->setApiKey('google_search_api_key');
    $translate->setText('Hello World')
              ->translateTo('Spanish');
              
    $response = $translate->translate();
    
    var_dump($response);
    } catch (Services_Google_Translate_Exception $e) {
        echo $e->getMessage();
    }
    
### Batch translate

    require_once 'Translate.php';
    try {    
    $translate = new Services_Google_Translate();
    $translate->setApiKey('google_search_api_key');
    $translate->setText('Hello World')
              ->setText('Goodbye')
              ->translateTo('Spanish')
              ->translateTo('French');
              
    $response = $translate->translate();
    
    var_dump($response);
    } catch (Services_Google_Translate_Exception $e) {
        echo $e->getMessage();
    }

More info @ <http://code.google.com/intl/en/apis/ajaxlanguage/documentation/#fonje>