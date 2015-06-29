<?php
if (!defined('BASEPATH')) die('Hadi Canım Başka Kapıya !!');

/**
 * 
 * 
 */
if (!function_exists('sql_get_where'))
{
		
	function sql_get_where($table, $where = array(), $order = array(), $limit = 24, $return = 'result')
	{
		if (empty($table) || $table == '' || count($where) <= 0)	
		{
			return '';
		}
		
		$ci =& get_instance();
		
		$sql = "SELECT * FROM $table";
		
		if (count($where) > 0 )
		{
			$sql .= ' WHERE ';
			
			foreach ($where as $k )
			{				
				$sql .= $k .' AND ';
						
			}
			
			$sql = substr($sql, 0, -4);
		}
				
		if (count($order) > 0)
		{
			$sql .= ' ORDER BY '. $order[0] .' '. $order[1];
		}

		if ($limit > 0)
		{
			$sql .= ' LIMIT 0, '.$limit;	
		}
		
		$q = $ci->db->query($sql);
		

		if ($q->num_rows() > 0)
		{
			if ($return == 'result')
			{
				return $q->result();
			}
			else
			{
				return $q;
			}
			
		}
		else
		{
			return FALSE;
		}

		
	}
	
}