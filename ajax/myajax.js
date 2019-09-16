function name()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			document.getElementById('error').innerHTML=
			xmlhttp.responseText;
		}
	}
	var c = document.getElementById('name').value;
	xmlhttp.open("get","ajax/admin.php?cid="+c,true);
	xmlhttp.send();
}

function username()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			document.getElementById('error').innerHTML=
			xmlhttp.responseText;
		}
	}
	var c = document.getElementById('name').value;
	xmlhttp.open("get","ajax/manager.php?cid="+c,true);
	xmlhttp.send();
}



function affiliate()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			document.getElementById('error').innerHTML=
			xmlhttp.responseText;
		}
	}
	var c = document.getElementById('name').value;
	xmlhttp.open("get","ajax/affiliate.php?afid="+c,true);
	xmlhttp.send();
}

