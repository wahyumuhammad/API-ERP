<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('join_param'))
{
	/**
	 * @param string $table       Table name
	 * @param string $foreign_key Collumn name having the Foreign Key
	 * @param string $references  Table and column reference. Ex: users(id)
	 * @param string $on_delete   RESTRICT, NO ACTION, CASCADE, SET NULL, SET DEFAULT
	 * @param string $on_update   RESTRICT, NO ACTION, CASCADE, SET NULL, SET DEFAULT
	 *
	 * @return string SQL command
	 */
	function join_param($params)
	{
        $param = [];
        foreach($params as $key=>$val){
            $param[]= $key."=".urlencode($val);
        }
        return implode("&",$param);
	}
}

