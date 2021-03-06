<?php
function convDateFromDb($date) 
{
	if(empty($date) || !isset($date)) { return ''; }

	$arr = explode('-', $date);
	
	return $arr[2]. '/' .$arr[1]. '/' .$arr[0];
}

function convDateToDb($date) 
{
	if(empty($date) || !isset($date)) { return ''; }

	$arr = explode('/', $date);
	
	return $arr[0]. '-' .$arr[1]. '-' .$arr[2];
}

function convDbToThDate($date) 
{
	if(empty($date) || !isset($date)) { return ''; }

	$arr = explode('-', $date);
	$year = (int)$arr[0] + 543;
	
	return $arr[2]. '/' .$arr[1]. '/' .$year;
}

function convThDateToDb($date) 
{
	if(empty($date) || !isset($date)) { return ''; }

	$arr = explode('/', $date);
	$year = (int)$arr[2] - 543;
	
	return $year. '-' .$arr[1]. '-' .$arr[0];
}