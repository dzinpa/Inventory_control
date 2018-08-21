<?php
include_once('FConnect.php');
include_once('WarehFunc.php');

/**
 *Get request from Warehouse.php and call function from WarehFunc
 */

if(!isset($_REQUEST['action'])){
	die('Action not find');
}

switch($_REQUEST ['action']){
	case 'warehouseList':
		$warehouseList=getWarehouseList($link);
		echo json_encode($warehouseList);
		break;
	
	case 'save':  
	
		if(isset($_POST['name']) &&
		isset($_POST['quantity']) &&
		isset($_POST['init']) &&
		isset($_POST['price']) &&
		isset($_POST['warehouseId'])){
			saveGoods($link,$_POST['name'],$_POST['quantity'],$_POST['init'],$_POST['price'],$_POST['warehouseId']);// вызываем функцию и передаем параметры в функцию из файла WarehFunc
		}
		break;
		
	case 'get': 
		$goods=getGoods($link,$_POST['warehouseId']);
		echo json_encode($goods);
		break;
		
	case 'reduce':	
		reduceInit($link,$_POST['remId'],$_POST['quant']);
		break;
		
	default:die('Inncorect action');
}