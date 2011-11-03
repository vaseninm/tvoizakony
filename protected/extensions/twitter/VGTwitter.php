<?php
/**
 * Twitter API Class File
 *
 * @author Vadim Gabriel <vadimg88[at]gmail[dot]com>
 * @link http://www.vadimg.com/
 * @copyright Vadim Gabriel
 * @license http://www.yiiframework.com/license/
 *
 * Some of the codes here were taken from the Twitter class by Tijs Verkoyen <http://classes.verkoyen.eu/twitter/>
 *
 */

/**
 * This Class acts as a general full featured Twitter API Extension. 
 * It is capable of doing pretty much all API calls listed in the URI Below.
 * For easier Reference we have created a google code project hosting so
 * people could contribute, Report bugs and/or read the documentation.
 * The following examples demonstrates the usage of this extension.
 * 
 * 
 * {@link http://apiwiki.twitter.com/Twitter-API-Documentation}
 * For full reference and documentation please visit the URI above
 * 
 */
class VGTwitter extends CApplicationComponent
{
	/**
	 * @var Current class version
	 */
	const TWITTER_CLASS_VERSION = '1.0.0';
	/**
	 * @var Twitter API URL
	 */
	const TWITTER_API_URL = 'http://twitter.com';
	/**
	 * @var Twitter API Port
	 */
	const TWITTER_API_PORT = 80;
	/**
	 * @var Unique Identifier of the cached content
	 */
	const CACHE_KEY = 'Yii.Twitter.Class.Cache.';
	/**
	 * @var Twitter Login username
	 */
	public $username = '';
	/**
	 * @var Twitter Login password
	 */
	public $password = '';
	/**
	 * @var Default response format
	 */
	public $format = 'xml';
	/**
	 * @var Default post params that will be attached to the request
	 */
	public $postParams = array();
	/**
	 * @var string the ID of the cache application component that is used to cache the parsed response data.
	 * Defaults to 'cache' which refers to the primary cache application component.
	 * Set this property to false if you want to disable caching URL rules.
	 * @since 1.0.0
	 */
	public $cacheID = 'cache';
	/**
	 * @var integer the time in seconds that the messages can remain valid in cache.
	 * Defaults to 60 seconds valid in cache.
	 */
	public $cachingDuration = 60;
	/**
	 * @var Set true/false if you want to throw exceptions when error
	 * Occurs. If you set this to false you can still know the error
	 * Returned by accessing the methods getErrorNumber() and getErrorMessage()
	 * And you can access the headers returned to see if there is an error there as well
	 * By using the method getHeaders().
	 */
	public $throwExceptions = true;
	/**
	 * @var Use post request or get request? Default is GET
	 */
	public $usePost = false;
	/**
	 * @var use member authentication or not. Defaults to false. If an API call needs a member to authenticate
	 * You need to either set this property to true in the application configuration or pass in a value of true
	 * to the second argument in the get() method
	 */
	public $authenticate = false;
	/**
	 * @var boolean - Set this property to true if you want to return the JSON response 
	 * As a PHP array instead of a JSON string. This is here just for the people who like to use JSON
	 * Since the returned data will be much smaller and then use it in a PHP array fashion.
	 */
	public $returnAsArray = false;
	/**
	 * @var int - Timeout in seconds
	 */
	public $timeOut = 10;
	/**
	 * @var string - the default API call to perform
	 */
	public $apiCallType = 'statuses/user_timeline';
	/**
	 * @var Allowd formats for the calls. Note that not all API calls allow each of those
	 * Formats. Some support them all while others not.
	 */
	protected $allowedFormats = array( 'xml', 'json', 'rss', 'atom' );
	/**
	 * @var Returned response before being parsed
	 */
	protected $response = array();
	/**
	 * @var returned response after being parsed
	 */
	protected $responseData = array();
	/**
	 * @var The returned response headers array
	 */
	protected $headers = array();
	/**
	 * @var Error number if any. By default this is set to 0, meaning there is no error.
	 */
	protected $errorNumber = 0;
	/**
	 * @var Error message if any. By default this is empty, meaning there is no error. 
	 */
	protected $errorMessage = '';
	/**
	 * @var Response header codes. This is the codes returned from twitter
	 * Just with the corresponding error message for each code for easier understanding of the
	 * type of error that occurred. You should visit {@link http://apiwiki.twitter.com/HTTP-Response-Codes-and-Errors}
	 * To full understand what type of error returned and what should be done in order to fix it.
	 */
	public $aStatusCodes = array(
									100 => 'Continue',
									101 => 'Switching Protocols',
									200 => 'OK',
									201 => 'Created',
									202 => 'Accepted',
									203 => 'Non-Authoritative Information',
									204 => 'No Content',
									205 => 'Reset Content',
									206 => 'Partial Content',
									300 => 'Multiple Choices',
									301 => 'Moved Permanently',
									301 => 'Status code is received in response to a request other than GET or HEAD, the user agent MUST NOT automatically redirect the request unless it can be confirmed by the user, since this might change the conditions under which the request was issued.',
									302 => 'Found',
									302 => 'Status code is received in response to a request other than GET or HEAD, the user agent MUST NOT automatically redirect the request unless it can be confirmed by the user, since this might change the conditions under which the request was issued.',
									303 => 'See Other',
									304 => 'Not Modified',
									305 => 'Use Proxy',
									306 => '(Unused)',
									307 => 'Temporary Redirect',
									400 => 'Bad Request',
									401 => 'Unauthorized',
									402 => 'Payment Required',
									403 => 'Forbidden',
									404 => 'Not Found',
									405 => 'Method Not Allowed',
									406 => 'Not Acceptable',
									407 => 'Proxy Authentication Required',
									408 => 'Request Timeout',
									409 => 'Conflict',
									411 => 'Length Required',
									412 => 'Precondition Failed',
									413 => 'Request Entity Too Large',
									414 => 'Request-URI Too Long',
									415 => 'Unsupported Media Type',
									416 => 'Requested Range Not Satisfiable',
									417 => 'Expectation Failed',
									500 => 'Internal Server Error',
									501 => 'Not Implemented',
									502 => 'Bad Gateway',
									503 => 'Service Unavailable',
									504 => 'Gateway Timeout',
									505 => 'HTTP Version Not Supported'
								);
								
	
	/**
	 * Component initializer
	 *
	 * @throws CException on missing CURL PHP Extension
	 */
	public function init()
	{
		// Make sure we have CURL enabled
		if( !function_exists('curl_init') )
		{
			throw new CException(Yii::t('VGTwitter', 'Sorry, Buy you need to have the CURL extension enabled in order to be able to use the twitter class.'), 500);
		}
		
		// Run parent
		parent::init();
	}
	
	/**
	 * 
	 * 
	 * 
	 * @param string - the API method to call {@link http://apiwiki.twitter.com/Twitter-API-Documentation}
	 * @param boolean - Use authentication or not, Defaults to false.
	 * @param string - Format of the returned response, Defaults to XML but it supports Json, RSS, Atom as well.
	 * For full documentation about the API calls available and their params {@link http://apiwiki.twitter.com/Twitter-API-Documentation}
	 * BE CAREFUL!! not all API calls allow all of those formats {@link http://apiwiki.twitter.com/Twitter-API-Documentation} 
	 * to know which call can return what formats. The default is xml as it supported by all calls.
	 * @param array - Array of key=>value pairs to add to the API Call, Each call has different parameters.
	 * @param boolean - User POST for this call? Defaults to false meaning use GET.
	 * @return VGTwitter object reference
	 */
	public function get( $type=null, $authenticate=false, $format=null, $postParams=array(), $usePost=false )
	{	
		$this->format = ( ( $format !== false ) && in_array( $format, $this->allowedFormats ) ) ? $format : $this->format;
		$this->usePost = ( $usePost === true ) ? true : false;
		$this->postParams = ( is_array( $postParams ) && count( $postParams ) ) ? $postParams : $this->postParams;
		$this->authenticate = ( ( $authenticate ) && ( $authenticate != $this->authenticate ) ) ? $authenticate : $this->authenticate;
		$this->apiCallType = ( $type !== null ) ? $type : $this->apiCallType;
		
		// We first check and see if cache is enabled
		// If it is then see if we have something that is valid in the cache already
		if($this->cacheID!==false && ($cache=Yii::app()->getComponent($this->cacheID))!==null)
		{
			if(($data=$cache->get( self::CACHE_KEY . $this->apiCallType . $this->format ))!==false)
			{
				$this->setResponseData($data);
				return $this;
			}
		}
		
		// Make the call
		$this->doCall( $this->apiCallType . '.' . $this->format );
		
		// We store it in the cache if we need to
		if(isset($cache) && $cache !== null)
		{
			$cache->set(self::CACHE_KEY . $this->apiCallType . $this->format, $this->getResponseData(), $this->cachingDuration);
		}
		
		return $this;
	}
	
	/**
	 *  
	 * @param string - The API Call to load {@link http://apiwiki.twitter.com/Twitter-API-Documentation}
	 * @throws CException if the property throwExceptions evaluates to true 
	 * @return VGTwitter object reference
	 */
	protected function doCall($url)
	{
		// build url
		$url = self::TWITTER_API_URL .'/'. $url;

		// rebuild url if we don't use post
		if(count( $this->postParams ) && !$this->usePost)
		{
			// init var
			$queryString = '';

			// loop parameters and add them to the queryString
			foreach($this->postParams as $key => $value) 
			{
				$queryString .= '&'. $key .'='. urlencode(utf8_encode($value));
			}	

			// cleanup querystring
			$queryString = trim($queryString, '&');

			// append to url
			$url .= '?'. $queryString;
		}

		// set options
		$options[CURLOPT_URL] = $url;
		$options[CURLOPT_PORT] = self::TWITTER_API_PORT;
		$options[CURLOPT_FOLLOWLOCATION] = true;
		$options[CURLOPT_RETURNTRANSFER] = true;
		$options[CURLOPT_TIMEOUT] = $this->timeOut;

		// should we authenticate?
		if($this->authenticate)
		{
			$options[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
			$options[CURLOPT_USERPWD] = $this->username .':'. $this->password;
		}

		// are there any parameters?
		if(!empty($this->postParams) && $this->usePost)
		{
			$var = '';

			// rebuild parameters
			foreach($this->postParams as $key => $value) 
			{
				$var .= '&'. $key .'='. urlencode($value);
			}	
				
			// set extra options
			$options[CURLOPT_POST] = true;
			$options[CURLOPT_POSTFIELDS] = trim($var, '&');

			// Probaly Twitter's webserver doesn't support the Expect: 100-continue header. So we reset it.
			$options[CURLOPT_HTTPHEADER] = array('Expect:');
		}

		// init
		$curl = curl_init();

		// set options
		curl_setopt_array($curl, $options);

		// execute
		$this->response = curl_exec($curl);
		$this->headers = curl_getinfo($curl);

		// fetch errors
		$this->errorNumber = curl_errno($curl);
		$this->errorMessage = curl_error($curl);

		// close
		curl_close($curl);

		// validate body
		if( $this->format == 'xml' )
		{
			$xml = @simplexml_load_string($this->response);
			if( ( $xml !== false && isset($xml->error) ) && $this->throwExceptions ) 
			{
				throw new CException($xml->error);
			}
			
			$this->setResponseData( $this->simplexml2array($xml) );
		}
		else if ( ( $this->format == 'json' ) && ( $this->returnAsArray ) )
		{
			$this->setResponseData(CJSON::decode($this->response));
		}
		else
		{
			$this->setResponseData( $this->response );
		}
		
		// invalid headers
		if(!in_array($this->headers['http_code'], array(0, 200)))
		{
			// throw error
			if( $this->throwExceptions )
			{
				throw new CException($this->headers['http_code']);
			}
		}

		// error?
		if( ($this->errorNumber != '' ) && ( $this->throwExceptions ) ) 
		{
			throw new CException($this->errorMessage, $this->errorNumber);
		}

		// return
		return $this;
	}
	
	/**
	 * Set the response data property
	 *
	 * @param mixed - the data to store in the responseData property
	 * @return void
	 */
	public function setResponseData( $data )
	{
		$this->responseData = $data;
	}
	
	/**
	 * @return mixed - Return the default CURL response
	 */
	public function getResponse()
	{
		return $this->response;
	}
	
	/**
	 * @return mixed - Return the response code after being parsed
	 */
	public function getResponseData()
	{
		return $this->responseData;
	}
	
	/**
	 * @return array - Return the CURL HTTP headers
	 */
	public function getHeaders()
	{
		return $this->headers;
	}
	
	/**
	 * @return int - If error occurs while performing the CURL
	 * Request then the error code will be retrieved by this method
	 */
	public function getErrorNumber()
	{
		return $this->errorNumber;
	}
	
	/**
	 * @return string - If error occurs while performing the CURL 
	 * Request then the error code will be retrieved by this method
	 */
	public function getErrorMessage()
	{
		return $this->errorMessage;
	}
	
	/**
	 * @return array - Convert a SimpleXML object to an array so we
	 * Could safely store it in the cache and retrieve it when needed.
	 */
	protected function simplexml2array($xml) 
	{
		if (get_class($xml) == 'SimpleXMLElement') 
		{
			$attributes = $xml->attributes();
			foreach($attributes as $k=>$v) 
			{
				if ($v) $a[$k] = (string) $v;
			}
			$x = $xml;
			$xml = get_object_vars($xml);
		}
		if (is_array($xml)) 
		{
			if (count($xml) == 0) return (string) $x; // for CDATA
			foreach($xml as $key=>$value) 
			{
				$r[$key] = $this->simplexml2array($value);
			}
			if (isset($a)) $r['@attributes'] = $a;    // Attributes
			return $r;
		}
		return (string) $xml;
	}	
}