<?php

include_once('FConnect.php'); 

/**
 *Save the goods in the database table: 
 * if the product exist add ,else create a new item
 * params $link from FConnect
 * params $price и $init... from WarehApi.php
*/
 function saveGoods($link, $name, $quantity, $init, $price, $warehouseId){
	$query = 'SELECT*FROM goods WHERE name="'.$name.'"';
	
		$result = mysqli_query($link, $query)
		or die (mysqli_error($link));
		
	$queryResult = mysqli_fetch_assoc($result); 
		if (!empty($queryResult)) {
			$query = "UPDATE goods SET `quantity` = `quantity` + '".$quantity."' WHERE `name` = '".$name."'";
			mysqli_query ($link, $query)
			or die(mysqli_error($link));
			
		}else{
			$query = 'INSERT INTO goods'
			.'(name,quantity,init,price,warehouseId)'
			.' values '
		
		.'("'.addslashes($name).'",
		"'.addslashes($quantity).'",
		"'.addslashes($init).'",
		"'.addslashes($price).'",
		"'.addslashes($warehouseId).'")';
			mysqli_query ($link, $query)
			or die(mysqli_error($link));
		}
}

/**
 * Get items from database
 * returns array for WarehApi.php
*/
function getGoods($link, $warehouseId){
	$query = 'SELECT* FROM goods WHERE warehouseId='.$warehouseId*1;
	
		$queryResult = mysqli_query($link, $query)
		or die (mysqli_error($link));
		
		$result = array();
		
		$num = mysqli_num_rows($queryResult);
			for($i = 0; $i < $num; $i++){
				$result[] = mysqli_fetch_array($queryResult);
			}
			
	mysqli_free_result($queryResult);
		return $result;
}

/**
 *Delete items from database or reduce 

*/

function reduceInit($link, $remId, $quant){
	$query = 'SELECT quantity FROM goods  WHERE id='.$remId*1;
		$result = mysqli_query($link, $query)
		or die (mysqli_error($link));
	
		$num = mysqli_num_rows($result);
			for ($i = 0; $i < $num; $i++){
				$row = mysqli_fetch_array($result);
			}

	if($row['quantity'] == $quant || $row['quantity'] < $quant){
		$query = 'DELETE FROM goods WHERE id='.$remId*1;
		mysqli_query($link, $query)
		or die(mysqli_error($link));
		
	} else {
		$query = "UPDATE goods SET `quantity` = `quantity` - '".$quant."' WHERE `id` = '".$remId."'";
		mysqli_query($link, $query)
		or die(mysqli_error($link));
	}
}

/**
 *Get items from database specific select(Warehouse.php)
 * returns array for WarehApi.php
*/	
	
function getWarehouseList($link){
	$query = 'SELECT * FROM warehouses';
		$result = mysqli_query($link, $query);
		
	$num = mysqli_num_rows($result);
	$ar = array();
	
		for($i = 0; $i < $num; $i++){
			$ar[] = mysqli_fetch_array($result);
		}
		return $ar;
}	
	
	
	
	
	
	
	


















