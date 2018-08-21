<!DOCTYPE html>
<html>
<head>
<title>Склад</title>
<link rel="stylesheet" href="WarehCSS.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
<script>
//Load table with goods
function loadGoods(){
	$.post('WarehApi.php',{action:'get', warehouseId:$('.warehouseList').val()}, function(data){//request for WarehApi.php
		obj = $.parseJSON(data);// save JSON format
		
		//generate table caption
		caption = '<tr>'
		+'<th>Kods</th>'
		+'<th>Nosaukums</th>'
		+'<th>Daudzums</th>'
		+'<th>Merv.</th>'
		+'<th>Cena</th>'
		+'<th>Summa</th>'
		+'</tr>';
		
		//generate table with items
		result = '';//string
		$.each(obj, function(key, value) {
			result+= '<tr>';
			result+= '<td>'+value.id+'</td> ';
			result+= '<td>'+value.name +'</td>';
			result+= '<td data-id="'+value.id+'" ';
			result+= 'class="vq">'+value.quantity +'</td>';
			result+= '<td>'+value.init +'</td>';
			result+= '<td class="pr">'+value.price +'</td>';
			resultSumm = value.quantity * value.price;//get summ
			result+= '<td class="sum">'+resultSumm.toFixed(2) +'</td>';
			result+= '</tr>';
		});

//Print table with data	
$('.addGoods').html(caption+result);

//Delete items
	$('.remove').click(function(){
		
	remId = $('.remId').val();
	quant = $('.quant').val();
	elems = $('td.vq');
	elemsTotal = elems.length;
	
		for( var i = 0; i < elemsTotal; i++){
			if($(elems[i]).attr('data-id') == remId ){
				elemsQuant = $(elems[i]).html();
				if(elemsQuant*1 < quant){
					alert("Nedrikst norakstit vairak neka ir noliktava");
					break;
					
				} else {
					data = {
					action:'reduce',
					remId:$('.remId').val(),
					quant:$('.quant').val()
					};
					
					$('.remId').val('');//remove value
					$('.quant').val('');
					$.post('WarehApi.php', data, function(){//send data to WarehApi.php
					
					loadGoods();
					});	
				};
				break;
			}
		}
	});
	});
	
};

$(function(){
//when changing the select value значения reload table 
	$('.warehouseList').change(function(){
		loadGoods();
	});
	
//get select value
	$.post('WarehApi.php', {action:'warehouseList'}, function(data){
		obj = $.parseJSON(data);
		
		result='';
		
		$.each(obj, function(key,value){
			result+= '<option value="'+value.id+'">';
			result+= value.warehName;
			result+= '</option>';
		});
			$('.warehouseList').html(result);
			loadGoods();
	});

//Send data to Warehapi.php for saving database
	$('.goodsForm').submit(function(event){
		event.preventDefault();
		
		data = {
			action:'save',
			name:$('.name').val(),
			quantity:$('.quantity').val(),
			init:$('.init').val(),
			price:$('.price').val(),
			warehouseId:$('.warehouseList').val()
		};
		
		$('.name').val('');
		$('.quantity').val('');
		$('.price').val('');
		$.post('WarehApi.php', data, function(){
			loadGoods();
		});
	});
});

//current date at the top of the page
function go(){
	Data = new Date();
	Year = Data.getFullYear();
	Month = Data.getMonth();
	Day = Data.getDate();

switch (Month){ 
	case 0: fMonth="janvari"; break;
	case 1: fMonth="februari"; break;
	case 2: fMonth="маrtu"; break;
	case 3: fMonth="аprili"; break;
	case 4: fMonth="maiju"; break;
	case 5: fMonth="juniju"; break;
	case 6: fMonth="juliju"; break;
	case 7: fMonth="аugustu"; break;
	case 8: fMonth="septembri"; break;
	case 9: fMonth="oktobri"; break;
	case 10: fMonth="novembri"; break;
	case 11: fMonth="decembri"; break;
}
	var date = document.getElementById("tDate");
		date.innerHTML= "Atlikumi uz "+Day+" "+fMonth+" "+Year+" gada";
}

</script>
</head>
<body onload="go()">
	<div class="tableBox">
		<span id="tDate"></span>
		<h4> NOLIKTAVA:<select class="warehouseList"> </select></h4>
		<table class="addGoods" >
		</table>
	</div>
	<div class="form">
		<h3>Pievienot preci uz noliktavas uzskaiti</h3>
		
		<form action="Warehouse.php" method="POST" class="goodsForm">
			<p><span class="size">Nosaukums:</span><input type="text" name="name" class="name"></p>
			<p><span class="size">Daudzums:</span><input type="text" name="quantity" class="quantity">
			Merveniba:<select type="text" name="init" class="init">
			<option>kg</option>
			<option>gab</option>
			</select>
			</p>
			<p><span class="size">Cena:</span><input type="text" name="price" class="price"></p>
			<p><input type="submit" value="Pievienot" class="subm"></p>
		</form>
		
		<h3>Norakstit</h3>
			<p><span class="size"> Preces numurs</span><input type="text" name="remId" class="remId"></p>
			<p><span class="size"> Daudzums</span><input type="text" name="quant" class="quant"></p>
				<button class="remove">Norakstit</button>
	</div>
	
</body>
</html>
