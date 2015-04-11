var SITE_URL = "http://" + location.hostname + "/Uni/FinalYearProject/";

$(document).ready(function()
{
	handleLogin();

    handleProjectPageActivityPolling();
    handleCreateNewProjectClient();
    handleCreateProjectNextButtons();
    handleCreateAdditionalSprintBacklogItem();
    handleCreateProjectToggles();
    handleToggleXPMethodologies();

    handleCreateProjectCreate();


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
    //setInterval(handleProjectPageActivityPolling,60000);
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



function handleCreateNewProjectClient()
{
    $("[name=projectCreateNewClientCb]").click(function()
    {
        if($(".projectOwnerDetails").css("display") == "none")
        {
            $(".projectOwnerDetails").fadeIn();
        }
        else
        {
            $(".projectOwnerDetails").hide();
        }
    });
}




function handleCreateProjectNextButtons()
{
    $("#createProjectNextStepOne").click(function()
    {
        handleSprintDateDifference();
        handleSprintCalculation();
        $("#createProjectBlockOne").slideUp("slow", function()
        {
            $("#createProjectBlockTwo").slideDown("slow");
        });
    });


    $("#createProjectNextStepTwo").click(function()
    {
        $("#createProjectBlockTwo").slideUp("slow", function()
        {
            $("#createProjectBlockThree").slideDown("slow");
        });
    });

    return false;
}


function handleCreateProjectToggles()
{
    $("#createProjectToggleBlockOne").click(function()
    {
        $("#createProjectBlockOne").slideToggle("slow");
    });


    $("#createProjectToggleBlockTwo").click(function()
    {
        $("#createProjectBlockTwo").slideToggle("slow");
    });


    $("#createProjectToggleBlockThree").click(function()
    {
        $("#createProjectBlockThree").slideToggle("slow");
    });


}


function handleCreateAdditionalSprintBacklogItem()
{
    $("#createSprintInfoAddBacklogItem").click(function()
    {
        var count = parseInt($(".createSprintInfoBacklogItem").length);
        //alert(count);
        var x = $(".createSprintInfoBacklogItem_1").clone().attr("class","createSprintInfoBacklogItem createSprintInfoBacklogItem_"+(count+1)).appendTo(".createSprintInfo");

        var input = $(".createSprintInfoBacklogItem_"+(count+1)).find("[name=backlogItem_1]").attr("name","backlogItem_"+(count+1));
        var moscow = $(".createSprintInfoBacklogItem_"+(count+1)).find("[name=projectSprintMoscow_1]").attr("name","projectSprintMoscow_"+(count+1));
        var comment = $(".createSprintInfoBacklogItem_"+(count+1)).find("[name=backlogComment_1]").attr("name","backlogComment_"+(count+1));

        var planningPoker = $(".createSprintInfoBacklogItem_"+(count+1)).find("[name=createSprintInfoSprintPokerVal_1]").attr("name","createSprintInfoSprintPokerVal_"+(count+1));
    });
}



function handleSprintDateDifference()
{

    var prjStart = $("[name=projectStartDate]").val();
    var prjEnd = $("[name=projectEndDate]").val();

    var dayDifference = showDays(prjEnd,prjStart);

    $("#createSprintInfoTotalPrjDays").text(dayDifference);

}

function handleSprintCalculation()
{
    var totalDays = parseInt($("#createSprintInfoTotalPrjDays").text());
    var totalSprints = parseInt($("[name=projectSprints]").find(":selected").text());

    console.log("Total Days" + totalDays);
    console.log("Total Sprints" + totalSprints);

    var totalSprintDays = Math.floor(totalDays/totalSprints);

    $("#createSprintInfoTotalSprintDays").text(totalSprintDays);
    $("#createSprintInfoTotalSprints").text(totalSprints);

    handleCreatingSprintGoals();
    handleCreateSprintDates();
    //alert(totalSprintDays);
}

function handleCreatingSprintGoals()
{
    var totalSprints = $("#createSprintInfoTotalSprints").text();

    for (i = 2; i <= totalSprints; i++)
    {
        var x = $(".createSprintInfoSprintGoal_1").clone().attr("class","createSprintInfoSprintGoal createSprintInfoSprintGoal_"+i).appendTo(".createSprintInfoDetails");
        var input = $(".createSprintInfoSprintGoal_"+i).find(".createSprintInfoSprintGoalText").text("Sprint "+i+" Goal: ");
        var textarea = $(".createSprintInfoSprintGoal_"+i).find("textarea").attr("class","createSprintInfoSprintDesc_"+i);


        var sprintStart = $(".createSprintInfoSprintGoal_"+i).find(".createSprintInfoSprintStart").attr("class","createSprintInfoSprintStart_"+i);
        var sprintFinish = $(".createSprintInfoSprintGoal_"+i).find(".createSprintInfoSprintFinish").attr("class","createSprintInfoSprintFinish_"+i);
        //var select = $(".createSprintInfoSprintGoal_"+i).find("select").attr("name","createSprintInfoSprintPokerVal_"+i);

    }
}

function handleCreateSprintDates()
{
    var prjStart = $("[name=projectStartDate]").val();

    var totalDays = parseInt($("#createSprintInfoTotalPrjDays").text());
    var totalSprints = parseInt($("[name=projectSprints]").find(":selected").text());

    var totalSprintDays = Math.floor(totalDays/totalSprints);

    var text = returnSprintDates(prjStart,totalSprintDays);

    $(".createSprintInfoSprintStart_1").text(prjStart);
    $(".createSprintInfoSprintFinish_1").text(text);


    //Get the total number of sprint elements
    var totalNumberOfSprintItems = $(".createSprintInfoSprintGoal").length;


    //get the first date to start from within the iteration
    //this date is populated in the few lines above
    //we start from this date as the initial offset
    //Basically is end date of first sprint
    var startIterationDate = $(".createSprintInfoSprintFinish_1").text();

    //start loop offset at 2, go until max number of elements
    for(i = 2; i <= totalNumberOfSprintItems; i++)
    {
        //find the current start element
        //createSprintInfoSprintGoal_2
        //etc
        //find the start date in the element
        //createSprintInfoSprintStart_2
        //set the start date to be the finish date of the previous element
        //createSprintInfoSprintFinish_1

        var previousEndDate = $(".createSprintInfoSprintGoal_"+(i-1)).find(".createSprintInfoSprintFinish_"+(i-1)).text();
        $(".createSprintInfoSprintGoal_"+i).find(".createSprintInfoSprintStart_"+i).text(previousEndDate);

        var newFinishDate = returnSprintDates(previousEndDate,totalSprintDays);
        $(".createSprintInfoSprintGoal_"+i).find(".createSprintInfoSprintFinish_"+i).text(newFinishDate);

    }

}

function showDays(firstDate,secondDate)
{

    var startDay = new Date(firstDate);
    var endDay = new Date(secondDate);
    var millisecondsPerDay = 1000 * 60 * 60 * 24;

    var millisBetween = startDay.getTime() - endDay.getTime();
    var days = millisBetween / millisecondsPerDay;

    // Round down.
    return Math.floor(days);

}

function returnSprintDates(startDate,days)
{
    var startDay = new Date(startDate);
    var endDate = new Date(startDay);

    endDate.setDate(startDay.getDate()+days);


    return endDate.toLocaleDateString("en-US");
}


function handleToggleXPMethodologies()
{
    $("[name=createProjectUseXP]").click(function()
    {
        $(".createSprintInfoXP").slideToggle("slow");

        handleGetTeamMembersForPP();
    });
}


function handleGetTeamMembersForPP()
{
    var teamID = $("[name=projectTeam]").find(":selected").attr("id");

    $.ajax({
            url:            SITE_URL+"/includes/lib/projectreturnteammembers.php",
            type:           "post",
            data:           "teamID="+teamID,
            dataType:       "text",
            success:        function(html)
            {
                    if(html)
                    {
                            $(".createSprintInfoXP").append(html);
                    }
                    else
                    {
                            console.log("FAILED");
                    }
            }
        });
}

function handleCreateProjectCreate()
{

    $("#create").click(function()
    {
        var dataset = {};
        $('#createProjectForm').find('input, textarea, select, span').each(function(i, field) {

            if(field.type == "checkbox")
            {
                dataset[field.name] = 1;
            }
            else
            {
                dataset[field.name] = field.value;
            }
        });


        var totalSprints = $("#createSprintInfoTotalSprints").text();
        for(i = 1; i <= totalSprints; i++)
        {
            var name = "createSprintInfoSprintStart_"+i;
            var value = $(".createSprintInfoSprintStart_"+i).text();
            dataset[name] = value;

            var name = "createSprintInfoSprintFinish_"+i;
            var value = $(".createSprintInfoSprintFinish_"+i).text();
            dataset[name] = value;

        }

        var totalProjectDays = $("#createSprintInfoTotalPrjDays").text();
        dataset['totalProjectDays'] = totalProjectDays;

        var totalDaysPerSprint = $("#createSprintInfoTotalSprintDays").text();
        dataset['totalDaysPerSprint'] = totalDaysPerSprint;


        dataset = JSON.stringify(dataset);

        $.ajax({
            url:            SITE_URL+"/includes/lib/createproject.php",
            type:           "post",
            data:           "data="+dataset,
            dataType:       "text",
            success:        function(html)
            {
                console.log(html);
                    if(html)
                    {
                            //$("#projectPageActivityPolling").html(html)
                    }
                    else
                    {
                            console.log("FAILED");
                    }
            }
        });
        //console.log(data);
    });

}