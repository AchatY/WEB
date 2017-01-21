function ring()
{
	if (!document.querySelector('#fire_ring'))
	{
	    var now = new Date();
	    var minutes = now.getMinutes();
	    minutes += (now.getHours() * 60);
	    var img = "";    
	    if (minutes >= 0 && minutes <= 359)
	    {
		img = "wind";
	    }
	    else if (minutes >= 360 && minutes <= 719)
	    {
		img = "earth";
	    }
	    else if (minutes >= 720 && minutes <= 1079)
	    {
		img = "fire";
	    }
	    else if (minutes >= 1020 && minutes <= 1439)
	    {
		img = "water";
	    }
	    
	    $("h1").after($("<div id='fire_ring'><img src='img/" + img +".png'></div>"))
	    $("#fire_ring img").css("marginLeft", "38%");
	    $("#fire_ring img").css("marginTop", "5%");
	    $("#fire_ring img").css("position", "relative");
	    $("#fire_ring img").css("zIndex", "1");
	    var rotation = function (){
		regex = /[\d]*/;
		if (regex.exec($("#fire_ring img").css("width"))[0] < 400)
		    $("#fire_ring img").animate({width: "+=200px"});
		else
		    connexion();

		$("#fire_ring img").rotate({
		    angle:0,
		    animateTo:360,
		    callback: rotation,
		    duration: 1000,
		    easing: function (x,t,b,c,d){return c*(t/d)+b;}
		});
	    }
	    rotation();
	}
} 

function connexion()
{
    var secret = $("#secret");

    if (!document.querySelector("#Connexion"))
    {
	var form = $("<div id='Connexion' name='connexion'></form>");
	var login = $("<input type='text' name='login' placeholder='Username' autocomplete='off'/>");
	var pass = $("<input type='password' name='pass' placeholder='Password' autocomplete='off'/>");
	var connect = $("<button name='submit'>Log In</button>");
	$(form).append(login);
	$(form).append(pass);
	$(form).append(connect);
	$('h1').after(form);
	$(form).css("position", "absolute");
	$(form).css("zIndex", "4");
	$(form).css("left", "41%");
	$(form).css("top", "44%");
    }
    
    regex = /[a-z]{2,6}_[a-z0-9]/;
    var connect = $("button[name='submit']");
    var login = $("input[name='login']");
    var pass = $("input[name='pass']");
    $(connect).click(function(){
	if ($(login).val().match(regex) && $(login).val().length >= 4 && $(login).val().length <= 8  && check_pass($(pass).val()))
	{
	    var now = new Date();
	    var minutes = now.getMinutes();
	    minutes += (now.getHours() * 60);
	    var expires = new Date();
	    
	    if (minutes >= 0 && minutes <= 359)
	    {
		expires.setHours(5); 
		expires.setMinutes(59); 
	    }
	    else if (minutes >= 360 && minutes <= 719)
	    {
		expires.setHours(11); 
		expires.setMinutes(59); 
	    }
	    else if (minutes >= 720 && minutes <= 1079)
	    {
		expires.setHours(17); 
		expires.setMinutes(59); 
	    }
	    else if (minutes >= 1020 && minutes <= 1439)
	    {
		expires.setHours(23); 
		expires.setMinutes(59); 
	    }
	    
	    document.cookie = "student=" + $(login).val() + ";expires=" + expires.toUTCString();
	    document.location.href="index.html";
	}
	else
	{
	    if (!document.querySelector('h5'))
	    {
		var err = $('<h5>Login Or password is incorrect you can retry after</h5>');
		$(err).css("color", "red");
		$(form).append(err);
	    }
	    var now = new Date();
	    var minutes = now.getMinutes();
	    minutes += (now.getHours() * 60);
	    var expires = new Date();
	    
	    if (minutes >= 0 && minutes <= 359)
	    {
		expires.setHours(5); 
		expires.setMinutes(59); 
	    }
	    else if (minutes >= 360 && minutes <= 719)
	    {
		expires.setHours(11); 
		expires.setMinutes(59); 
	    }
	    else if (minutes >= 720 && minutes <= 1079)
	    {
		expires.setHours(17); 
		expires.setMinutes(59); 
	    }
	    else if (minutes >= 1020 && minutes <= 1439)
	    {
		expires.setHours(23); 
		expires.setMinutes(59); 
	    }
	    
	    document.cookie = "forbidden=true;expires=" + expires.toUTCString();
	}
    });
	$(login).change(function(){
	    if ($(login).val().match(regex) && $(login).val().length >= 4 && $(login).val().length <= 8)
	    {
		$(login).css("border", "2px groove green");
		$(login).css("background", "rgba(31, 156, 8, 0.42)");
	    }
	    else
	    {
		$(login).css("border", "2px groove red");
		$(login).css("background", "rgba(183, 9, 9, 0.42");
	    }
	});
	$(pass).change(function(){
	    if (check_pass($(pass).val()))
	    {
		$(pass).css("border", "2px groove green");
		$(pass).css("background", "rgba(31, 156, 8, 0.42)");
	    }
	    else
	    {
		$(pass).css("border", "2px groove red");
		$(pass).css("background", "rgba(183, 9, 9, 0.42");
	    }
	});
} 

function check_pass(pass)
{
    var now = new Date();
    var minutes = now.getMinutes();
    minutes += (now.getHours() * 60);
    var now_pass = "";
    
    if (minutes >= 0 && minutes <= 359)
	 now_pass = "Air";
    else if (minutes >= 360 && minutes <= 719)
	 now_pass = "Earth";
    else if (minutes >= 720 && minutes <= 1079)
	 now_pass = "Fire";
    else if (minutes >= 1020 && minutes <= 1439)
	now_pass = "Water";

    if (pass == now_pass)
	return 1;
    else
	return 0;
}


function is_logged()
{
    var cookie = document.cookie;
    regex_login = /[ ;]?student=[a-z]{2,6}_[a-z0-9][;]?/;
    regex_forbidden = /[ ;]?forbidden=true[;]?/;

    if (!cookie.match(regex_forbidden))
    {
	if (cookie.match(regex_login))
	    document.location.href="schedule.html";
    }	
}

function animate ()
{
    var secret = $("#secret");
    $(secret).click(function(){
	var width = $(window).width();
	var height = $(window).height();
	if (!document.querySelector("#animation"))
	{
	    var animation = $("<div id='animation' ></div>");
	    var img1 = $("<img src='img/1.png' />"); 
	    var img2 = $("<img src='img/2.png' />");
	    var img3 = $("<img src='img/3.png' />");
	    var img4 = $("<img src='img/4.png' />");
	    var img5 = $("<img src='img/5.png' />");
	    var img6 = $("<img src='img/6.png' />");
	}
	
	$(img1).css("position", "absolute");
	$(img1).css("left", "0");
	$(img2).css("position", "absolute");
	$(img2).css("left", "30%");
	$(img2).css("bottom", "35%");
    
	$(img3).css("position", "absolute");
	$(img3).css("right", "30%");
	$(img3).css("bottom", "35%");

	$(img4).css("position", "absolute");
	$(img4).css("left", "30%");
	$(img4).css("bottom", "5%");

	$(img5).css("position", "absolute");
	$(img5).css("right", "30%");
	$(img5).css("bottom", "5%");
	
	$(img6).css("position", "absolute");
	$(img6).css("right", "0");
	
	$("h1").after(animation);
	$(animation).append(img1, img2, img3, img4, img5, img6);
	
	$(img1).animate({left: width/2-170 + "px"}, "slow");
	$(img6).animate({right: width/2-170 + "px"}, "slow");
	$(img1).animate({bottom:  "0"}, "slow");
	$(img6).animate({bottom:  "0"}, "slow");
	
	$(img4).animate({left: "0"}, "slow");
	$(img5).animate({right: "0"}, "slow");
	$(img4).animate({bottom: height/2+162 + "px"}, "slow");
	$(img5).animate({bottom: height/2+162 + "px"}, "slow");
	
	$(img2).animate({left: "0"}, "slow");
	$(img3).animate({right: "0"}, "slow");
	
	$(img1).animate({left: "0"}, "slow");
	$(img6).animate({right: "0"}, "slow");

	$(img2).animate({left: "30%"}, "slow");
	$(img3).animate({right: "30%"}, "slow");
	
	$(img2).animate({bottom: "0"}, "slow");
	$(img3).animate({bottom: "0"}, "slow");
	ring();
    });	
}
