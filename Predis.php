<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Redis simple Library
 * @category  Library
 * @package   CodeIgniter
 * @author    Legend <zcq.0@163.com>
 * @copyright 2014 Legend.
 * @license   MIT License http://www.opensource.org/licenses/mit-license.php
 * @version   bata: 0.1
 * @link      https://github.com/
 */
class predis
{

	/**
	 * CI instance.
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_ci;
	
	/**
	 * Config file.
	 * 
	 * @var string
	 * @access private
	 */
	private $_config_file = 'redis';
	
	/**
	 * Config file data
	 * 
	 * @var array
	 * @access private
	 */
	private $_config_data = array();
	
	/**
	 * Connection resource.
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_connection = NULL;
	
	/**
	 * Database handle.
	 * 
	 * @var resource
	 * @access private
	 */
	private $_dbhandle = NULL;
	
	/**
	 * Generated connection string.
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_connection_string = '';
	
	/**
	 * Database host.
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_host = array('localhost');

	/**
	 * Database port.
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_port = '6379';
	
	private $_is_auth = FALSE;
	/**
	 * Database user password.
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_pass = '';
	
	/**
	 * @var boolean
	 * @access private
	 */
	private $_pconnect = FALSE;


  public function __construct()
  {
      if (function_exists('get_instance')) {
          $this->_ci = get_instance();
      } else {
          $this->_ci = NULL;
      }

      $this->load();
  }

  public function load($config = 'default')
  {
      // Try and load a config file if CodeIgniter
      if ($this->_ci) {
          $this->_config_data = $this->_ci->config->load($this->_config_file);
      }

      if (is_array($config)) {
          $this->_config_data = $config;
      } elseif (is_string($config) && $this->_ci) {
          $this->_config_data = $this->_ci->config->item($config);
      } else {
          $this->_show_error('No config name passed or config variables', 500);
      }
      $this->_connection_string();
      $this->_connect();
  }

  private function _connect()
  {
      $options = array();

      if ($this->_persist === TRUE) {
          $options['persist'] = $this->_persist_key;
      }

      if ($this->_replica_set !== FALSE) {
          $options['replicaSet'] = $this->_replica_set;
      }

      try {
      		$redis = new Redis();
      		if($this->_pconnect){
  	        $this->_connection = $redis->connect($this->_host, $this->_port);
      		}else{
	          $this->_connection = $redis->pconnect($this->_host, $this->_port);      			
      		}

      		if($this->_is_auth){
      			$redis->auth($this->_pass);
      		}
      		
      		/*
      		$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_NONE);   // don't serialize data
					$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);    // use built-in serialize/unserialize
					$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_IGBINARY);   // use igBinary serialize/unserialize

					$redis->setOption(Redis::OPT_PREFIX, 'myAppName:'); // use custom prefix on all keys

					/* Options for the SCAN family of commands, indicating whether to abstract
					   empty results from the user.  If set to SCAN_NORETRY (the default), phpredis
					   will just issue one SCAN command at a time, sometimes returning an empty
					   array of results.  If set to SCAN_RETRY, phpredis will retry the scan command
					   until keys come back OR Redis returns an iterator of zero
					
					$redis->setOption(Redis::OPT_SCAN, Redis::SCAN_NORETRY);
					$redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);*/

          return $this;
      } catch (MongoConnectionException $exception) {
          if ($this->_config_data['mongo_suppress_connect_error']) {
              $this->_show_error('Unable to connect to MongoDB', 500);
          } else {
              $this->_show_error('Unable to connect to MongoDB: ' . $exception->getMessage(), 500);
          }
      }
  }

  private function _connection_string()
  {
      $this->_host = trim($this->_config_data['redis_host']);
      $this->_port = trim($this->_config_data['redis_port']);
      $this->_is_auth = trim($this->_config_data['redis_auth']);
      $this->_pass = trim($this->_config_data['redis_password']);
      $this->_dbname = trim($this->_config_data['redis_pconnect']);

      if (empty($this->_host)) {
          $this->_show_error('The Host must be set to connect to redis', 500);
      }

      if (empty($this->_port)) {
          $this->_show_error('The port must be set to connect to redis', 500);
      }

      if ($this->_is_auth AND empty($this->_pass)) {
          $this->_show_error('The password must be set to auth', 500);
      }
  }

}
// End of file predis.php