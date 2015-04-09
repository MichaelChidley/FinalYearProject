var SITE_URL = "http://" + location.hostname + "/Uni/FinalYearProject/";

$(document).ready(function()
{
	handleLogin();

    handleProjectPageActivityPolling();

});


$(window).resize(function()
{
	handleLoginStyle();

});

function handleLogin()
{
	handleLoginStyle();
	handleLoginFunctionality();
}

function handleLoginStyle()
{
	var windowHeight = $(window).height();
	var windowWidth = $(window).width();


	var xOffset = windowWidth/2 - $("#loginContent").width()/2;
    var yOffset = windowHeight/2 - $("#loginContent").height()/2;

	$("#loginContent").css("left", ""+xOffset+"px");
    $("#loginContent").css("top", ""+yOffset+"px");


    var logoOffset = $("#loginContent").width()/2 - $("#loginLogo").width()/2;

    $("#loginLogo").css("left", logoOffset+"px");


}

function handleLoginFunctionality()
{
	$("#loginUser").click(function()
    {
          $(this).val("");
    });
    $("#loginPass").click(function()
    {
          $(this).val("");
    });


    $("[name='username']").focus();


     $('#loginBox').keypress(function(e)
     {
        if(e.which == 13)
        {
                checkLogin();
        }
    });
}

function checkLogin()
{
	//check login stuff through ajax
	var username = $("#loginUser").val();
	var password = $("#loginPass").val();

	$.ajax({
            url:            SITE_URL+"/includes/lib/authenticateLogin.php",
            type:           "post",
            data:           "user="+username+"&pass="+password,
            dataType:       "text",
            success:        function(html)
            {
            		console.log(html);
                    if(html == "true")
                    {
                            $("#loginBox").fadeOut(800, function()
                            {
                                    window.location=SITE_URL;
                            });
                    }
                    else
                    {
                            $("#loginresultholder").text("Incorrect login, please try again");

                            $("#loginUser").val('');
                            $("#loginPass").val('');

                            $("#loginUser").focus();


                            $("#loginresultholder").fadeIn().delay(5000).fadeOut();
                    }
            }
    });
}



function handleProjectPageActivityPolling()
{
    setInterval(handleProjectPageActivityPolling,60000);
    if($("#projectPageActivityPolling").length > 0)
    {
        var projectID = $("#projectID").text();

        $.ajax({
            url:            SITE_URL+"/includes/lib/projectpolling.php",
            type:           "post",
            data:           "projectID="+projectID,
            dataType:       "text",
            success:        function(html)
            {
                    if(html)
                    {
                            $("#projectPageActivityPolling").html(html)
                    }
                    else
                    {
                            console.log("FAILED");
                    }
            }
        });
    }
}