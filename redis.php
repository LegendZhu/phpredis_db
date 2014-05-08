<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/* -------------------------------------------------------------------
 * EXPLANATION OF VARIABLES
 * -------------------------------------------------------------------
 *
 * ['redis_host'] The hostname (and port number) of your redis-server
 * ['redis_port'] The port number of the redis-server
 * ['redis_auth'] The redis auth
 * ['redis_password'] The password used to auth to the redis
 * ['redis_pconnect'] The redis used to connect or pconnect
 */

if(ENVIRONMENT == 'development'){
  $config['default']['redis_host'] = 'localhost';
  $config['default']['redis_port'] = 6379;
  $config['default']['redis_auth'] = TRUE;
  $config['default']['redis_password'] = 'xxxxxx';
  $config['default']['redis_pconnect'] = TRUE;
}elseif(ENVIRONMENT == 'testing'){
  $config['default']['redis_host'] = 'localhost';
  $config['default']['redis_port'] = 6379;
  $config['default']['redis_auth'] = TRUE;
  $config['default']['redis_password'] = 'xxxxxx';
  $config['default']['redis_pconnect'] = TRUE;
}elseif(ENVIRONMENT == 'production'){
  $config['default']['redis_host'] = 'localhost';
  $config['default']['redis_port'] = 6379;
  $config['default']['redis_auth'] = TRUE;
  $config['default']['redis_password'] = 'xxxxxx';
  $config['default']['redis_pconnect'] = TRUE;
}
