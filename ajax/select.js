function find()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			document.getElementById('uid').innerHTML=
			xmlhttp.responseText;
		}
	}
	var c = document.getElementById('id').value;
	//alert(c);
	xmlhttp.open("get","ajax/name.php?utype="+c,true);
	xmlhttp.send();
}



