
$(document).ready(function myFunction() {
	var url = "/scripts/ReadNews.php";
	
	$.ajax(
	{
		type : 'post',
		url : url,
		dataType : 'json',
		success : function(data)
		{
			var SingleEntry = new Array(data.length);
			
			for(var i = 0; i < data.length; i++)
			{
				SingleEntry.push("<div class='basic-wrapper'><div class='Newsauthor'>" +  data[i]['benutzername'] + "</div><div class='Newsdate'>" + data[i]['zeit'] + "</div><br><div class='Newstopic'>" + data[i]['betreff'] +"</div><div class='Newsmessage'>" + data[i]['nachricht'] + "</div></div>");
			}
			
			var AllEntries = SingleEntry.join('');
			document.getElementById("newsdata").innerHTML = AllEntries;
		}
	});
});