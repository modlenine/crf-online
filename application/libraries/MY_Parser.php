<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Overrides the CI Template Parser to allow for multiple occurrences of the
 * same variable pair
 *
 */
class MY_Parser extends CI_Parser {
 // --------------------------------------------------------------------
 /**
  * Parse a template
  *
  * Parses pseudo-variables contained in the specified template view,
  * replacing them with the data in the second param
  *
  * @param string
  * @param array
  * @param bool
  * @return string
  */
 public function parse($template, $data, $return = FALSE)
 {
  $template = $this->CI->load->view($template, $data, TRUE);
  $results = $this->_parse_double($template, $data);
  $results = $this->_parse($results, $data, TRUE);
  if ($return === FALSE)
  {
   $this->CI->output->append_output($results);
  }
    return $results;
 }
  // --------------------------------------------------------------------
 /**
  * Parse a single key/value
  *
  * @param string
  * @param string
  * @param string
  * @return string
  */
 protected function _parse_double($results, $data)
 {
  $replace = array();
  preg_match_all("/\{\{(.*?)\}\}/si", $results, $matches);
    foreach ($matches[1] as $match)
  {
   $key = '{{'.$match.'}}';
   $replace[$key] = isset($data[$match]) ? $data[$match] : $key;
  }
  $results = strtr($results, $replace);
  return $results;
 }
}
// END Parser Class
/* End of file MY_Parser.php */
/* Location: ./application/libraries/MY_Parser.php */