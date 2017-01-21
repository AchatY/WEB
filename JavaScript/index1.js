
$.get("http://40.115.42.10/api/achat_y/393cc998-9229-4bfb-a2ed-7e9d5c209588/schedule" , function ( data )
{
    regex = /student=(.*)[;]?/;
    var student = regex.exec(document.cookie);

    $('h2').after("<h4>" + student[1] + "</h4>");
    var i = 0;
    regex = /[0-9]*-[0-9]*-[0-9]*/;
    var date = regex.exec(data[1]['date']);
    var new_div = document.createElement('div');
    new_div.textContent =  "Today :" + date;
    new_div.setAttribute("id", "today");
    document.body.appendChild(new_div);
    
    var emploi_du_temps = document.createElement('table');
    emploi_du_temps.setAttribute("id", "collection");
    document.body.appendChild(emploi_du_temps);
    var TR = document.createElement('TR');
    emploi_du_temps.appendChild(TR);
    var TD = document.createElement('Th');
    TD.textContent = "Name";
    TR.appendChild(TD);
    TD = document.createElement('Th');
    TD.textContent = "Heure";
    TR.appendChild(TD);


    while (i < data.length - 1)
    {
	var new_date = new Date(data[i]['date']);
	var after_date = new Date(data[i + 1]['date']);
	if (new_date.getHours() > after_date.getHours())
	{
	    var swap = data[i];
	    data[i] = data[i + 1];
	    data[i + 1] = swap;
	}
	i = i + 1;
    }
    
    i = 0;
    while (i < data.length)
    {
	var TR = document.createElement('TR');
	emploi_du_temps.appendChild(TR);
	var TD = document.createElement('TD');
	TD.textContent =  data[i]['name'];
	TR.appendChild(TD);
	var TD = document.createElement('TD');
	regex = /[0-9]*:[0-9]*/;
	var heure = regex.exec(data[i]['date']);
	TD.textContent = heure;
	TR.appendChild(TD);
	i = i + 1;
    }
    
});

function prepar_2 ()
{
    document.location.href="schedule.html";
}

function onclick_tomorrow()
{
    document.getElementById('tomorrow').addEventListener("click",prepar);
    document.getElementById('active').addEventListener("click",prepar_2);
}

function prepar()
{
    var  div1 = document.getElementById('collection');
    div1.remove();
    if (!document.getElementById("zone_tableau"))
    {
	$.get("http://40.115.42.10/api/achat_y/393cc998-9229-4bfb-a2ed-7e9d5c209588/classes" , function ( data )
	  {
	      regex = /[0-9]*-[0-9]*-[0-9]*/;
	      var date = regex.exec(data[1]['date']);
	      document.getElementById('today').textContent = "Tomorrow : " + date;
	      $('#active').css("background-color", "inherit");
	      $('#tomorrow').css("background-color", "green");

	      var div = document.createElement('div');
	      div.setAttribute("id" , "zone_tableau");
	      document.body.appendChild(div);
	      var i = 0;
	      while (i < data.length - 1)
	      {
		  var new_date = new Date(data[i]['date']);
		  var after_date = new Date(data[i + 1]['date']);
		  if (new_date.getHours() > after_date.getHours())
		  {
		      var swap = data[i];
		      data[i] = data[i + 1];
		      data[i + 1] = swap;
		  }
		  i = i + 1;
	      }
	      
	      var emploi_du_temps = document.createElement('table');
	      div.appendChild(emploi_du_temps);
	      var cours_dispo = $('<tr><td colspan=2>Cours Enregistre</td></tr>');
	      $(emploi_du_temps).append(cours_dispo);
	      var TR = document.createElement('TR');
	      emploi_du_temps.appendChild(TR);
	      var TD = document.createElement('Th');
	      TD.textContent = "Name";
	      TR.appendChild(TD);
	      TD = document.createElement('Th');
	      TD.textContent = "Heure";
	      TR.appendChild(TD);

	      var emploi_du_temps1 = document.createElement('table');
	      div.appendChild(emploi_du_temps1);
	      var cours_dispo = $('<tr><td colspan=2>Cours Non Enregistre</td></tr>');
	      $(emploi_du_temps1).append(cours_dispo);
	      var TR = document.createElement('TR');
	      emploi_du_temps1.appendChild(TR);
	      var TD = document.createElement('Th');
	      TD.textContent = "Name";
	      TR.appendChild(TD);
	      TD = document.createElement('Th');
	      TD.textContent = "Heure";
	      TR.appendChild(TD);
	      i = 0;

	      var button = $("<button id = 'valider'>Validate</button>");
	      $(document.body).append(button);

	      var e = [];
	      var non_e = [];
	      while (i < data.length)
	      {
		  if (data[i]['registered'] == true)
		  {
		      e.push = i;
		      var TR = document.createElement('TR');
		      emploi_du_temps.appendChild(TR);
		      var TD = document.createElement('TD');
		      TD.textContent =  data[i]['name'];
		      TR.appendChild(TD);
		      click_registered(TR, emploi_du_temps, TD, emploi_du_temps1);
		      var TD = document.createElement('TD');
		      regex = /[0-9]*:[0-9]*/;
		      var heure = regex.exec(data[i]['date']);
		      TD.textContent = heure;
		      TR.appendChild(TD);
		  }
		  else
		  {
		      non_e.push = i;
		      var TR = document.createElement('TR');
		      emploi_du_temps1.appendChild(TR);
		      var TD = document.createElement('TD');
		      TD.textContent =  data[i]['name'];
		      TR.appendChild(TD);
		      click_nonregistered(TR, emploi_du_temps, TD, emploi_du_temps1);
		      var TD = document.createElement('TD');
		      regex = /[0-9]*:[0-9]*/;
		      var heure = regex.exec(data[i]['date']);
		      TD.textContent = heure;
		      TR.appendChild(TD);
		  }
		  i = i + 1;
	      }
	      console.log(e);
	      console.log(non_e);
	      console.log(data[0]['registered']);
	      console.log(data[1]['registered']);
	      
	      data[0]['registered'] = false;
	      data[1]['registered'] = false;
	      console.log(data[0]['registered']);
	      console.log(data[1]['registered']);
	      var requete = new XMLHttpRequest();
	      var url = 'http://40.115.42.10/api/achat_y/393cc998-9229-4bfb-a2ed-7e9d5c209588/classes';
	      requete.open('POST', url, true);
	      requete.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	      requete.send(JSON.stringify({ registered : [{name: t[name], date: "2016-11-16 15:30", registered: stmt}]}));
	  });
    }
}

function click_registered(TR, emploi_du_temps, TD, emploi_du_temps1)
{
    TD.addEventListener("click",function()
			{
	emploi_du_temps.appendChild(TR);
	click_nonregistered(TR, emploi_du_temps, TD, emploi_du_temps1);
    });
}

function click_nonregistered(TR, emploi_du_temps, TD, emploi_du_temps1)
{
    TD.addEventListener("click",function()
			{
	emploi_du_temps1.appendChild(TR);
	click_registered(TR, emploi_du_temps, TD, emploi_du_temps1);
    });
}

function is_logged()
{
    var cookie = document.cookie;
    regex_login = /[ ;]?student=[a-z]{2,6}_[a-z0-9][;]?/;
    regex_forbidden = /[ ;]?forbidden=true[;]?/;

    if ((cookie.match(regex_forbidden)) || (!cookie.match(regex_login)))
	document.location.href="index.html";
}


