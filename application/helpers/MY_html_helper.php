<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Heading
 *
 * Generates an HTML heading tag.  First param is the data.
 * Second param is the size of the heading tag.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @return	string
 */

	function heading($data = '', $h = '1', $attributes = '')
	{
		$attributes = ($attributes != '') ? ' '.$attributes : $attributes;
        
        if ($h == 1):
		    return "<div class=\"page-header\"><h".$h.$attributes.">".$data."</h".$h."></div>";
		else:
    		    return "<h".$h.$attributes.">".$data."</h".$h.">";
		endif;
		
	} 