var SITE_URL = "http://" + location.hostname + "/Uni/FinalYearProject/";


//when the page is ready, call all of the functions listed within this block
$(document).ready(function()
{
	handleLogin();

    handleMessageBoxStyle();

    handleProjectPageActivityPolling();
    handleCreateNewProjectClient();
    handleCreateProjectNextButtons();
    handleCreateAdditionalSprintBacklogItem();
    handleCreateProjectToggles();
    handleToggleXPMethodologies();

    handleCreateProjectCreate();
    handleProjectClickView();
    handleBugClick();
    handleBugMarkFixed();
    handleBugCreateClick();
    handleDeleteEmployee();

    handleDeleteProject();

    handleEmployeeViewClick();
    handleEmployeeAddClick();

    handleTeamCreateClick();

    handleFooter();

    $('.pie_progress, .pie_progress_bug').asPieProgress({
            'namespace': 'pie_progress'
    });


});

//when all elemtsn have loaded on the page, call all functions within this block
$(window).load(function()
{
     $('.pie_progress').asPieProgress('start');
     handleHomePageProjectProgressSwitching();
})

//when the window is resized, call all functions within this block
$(window).resize(function()
{
	handleLoginStyle();
    handleMessageBoxStyle();

});


/*
    Overview: route login request
    In:
    Out:
*/
function handleLogin()
{
	handleLoginStyle();
	handleLoginFunctionality();
}

/*
    Overview: Change the style of the login page, depending on the size of the viewport
    In:
    Out:
*/
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

/*
    Overview: Center the message box to the viewport
    In:
    Out:
*/
function handleMessageBoxStyle()
{
    var windowHeight = $(window).height();
    var windowWidth = $(window).width();


    var xOffset = windowWidth/2 - $(".messageBox").width()/2;
    var yOffset = windowHeight/2 - $(".messageBox").height()/2;

    $(".messageBox").css("left", ""+xOffset+"px");
    //$(".messageBox").css("top", ""+yOffset+"px");

}

/*
    Overview: Set the message box contents alongside the redirect address once complete
    In: text - text to display in the message box
        redirect - address to redirect to
    Out:
*/
function handleMessageBoxEffect(text,redirect)
{
    $(".messageBox").text(text);
    handleMessageBoxStyle();
    $(".messageBox").fadeIn(500).delay(2000).fadeOut(500, function()
        {
            if(redirect !== "")
            {
                window.location = redirect;
            }
        });
}

/*
    Overview: handle the login operation and route the request to the ajax function
    In:
    Out:
*/
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

/*
    Overview: Perform ajax request to external library to determine authenticity of login request
    In:
    Out:
*/
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


/*
    Overview: Return all activity elemenets every 60 seconds and display to the screen
    In:
    Out:
*/
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


/*
    Overview: Handle the button used to create an additional client
    In:
    Out:
*/
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


/*
    Overview: Handle buttons that appear in the project creation stage, buttons flow the page to the next section
    In:
    Out:
*/
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


/*
    Overview: Handle the toggle buttons found in the project creation stage
    In:
    Out:
*/
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

/*
    Overview: Function to add more backlog items
    In:
    Out:
*/
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


/*
    Overview: Method to return the day difference between two sprint dates
    In:
    Out:
*/
function handleSprintDateDifference()
{

    var prjStart = $("[name=projectStartDate]").val();
    var prjEnd = $("[name=projectEndDate]").val();

    var dayDifference = showDays(prjEnd,prjStart);

    $("#createSprintInfoTotalPrjDays").text(dayDifference);

}

/*
    Overview: Method to calculate the total number of sprints and days per each
    In:
    Out:
*/
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

/*
    Overview: Handle itterations to output the correct amount of input boxes to support the total number of sprints to be undertaken
    In:
    Out:
*/
function handleCreatingSprintGoals()
{
    var totalSprints = $("#createSprintInfoTotalSprints").text();

    for (i = 2; i <= totalSprints; i++)
    {
        var x = $(".createSprintInfoSprintGoal_1").clone().attr("class","createSprintInfoSprintGoal createSprintInfoSprintGoal_"+i).appendTo(".createSprintInfoDetails");
        var input = $(".createSprintInfoSprintGoal_"+i).find(".createSprintInfoSprintGoalText").text("Sprint "+i+" Goal: ");
        var textarea = $(".createSprintInfoSprintGoal_"+i).find("textarea").attr("class","createSprintInfoSprintDesc_"+i);
        var textareaname = $(".createSprintInfoSprintGoal_"+i).find("textarea").attr("name","createSprintInfoSprintDesc_"+i);

        var sprintStart = $(".createSprintInfoSprintGoal_"+i).find(".createSprintInfoSprintStart").attr("class","createSprintInfoSprintStart_"+i);
        var sprintFinish = $(".createSprintInfoSprintGoal_"+i).find(".createSprintInfoSprintFinish").attr("class","createSprintInfoSprintFinish_"+i);

    }
}

/*
    Overview: Handle the dates for each sprint. Each start date will the finish date of the sprint before
    In:
    Out:
*/
function handleCreateSprintDates()
{
    //get project start date
    var prjStart = $("[name=projectStartDate]").val();

    //get total project days and total sprints
    var totalDays = parseInt($("#createSprintInfoTotalPrjDays").text());
    var totalSprints = parseInt($("[name=projectSprints]").find(":selected").text());

    //divide the total days by the number of sprints and round down to return the total
    //number of days for each sprint
    var totalSprintDays = Math.floor(totalDays/totalSprints);

    //generate the initial sprint dates
    var text = returnSprintDates(prjStart,totalSprintDays);

    //set sprint dates
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
        //find the start date in the element
        //createSprintInfoSprintStart_2
        //set the start date to be the finish date of the previous element
        //createSprintInfoSprintFinish_1

        //find the previous end date set as start date for next sprint
        var previousEndDate = $(".createSprintInfoSprintGoal_"+(i-1)).find(".createSprintInfoSprintFinish_"+(i-1)).text();
        $(".createSprintInfoSprintGoal_"+i).find(".createSprintInfoSprintStart_"+i).text(previousEndDate);

        //add total sprint days to start date to get new end date
        var newFinishDate = returnSprintDates(previousEndDate,totalSprintDays);
        $(".createSprintInfoSprintGoal_"+i).find(".createSprintInfoSprintFinish_"+i).text(newFinishDate);

    }

}

/*
    Overview: Calculate the number of days between two days
    In:
    Out:
*/
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

/*
    Overview: Return the total sprint dates
    In:
    Out:
*/
function returnSprintDates(startDate,days)
{
    var startDay = new Date(startDate);
    var endDate = new Date(startDay);

    endDate.setDate(startDay.getDate()+days);


    return endDate.toLocaleDateString("en-US");
}

/*
    Overview:Handle checkbox to toggle XP methodologies in project creation stage
    In:
    Out:
*/
function handleToggleXPMethodologies()
{
    $("[name=createProjectUseXP]").click(function()
    {
        $(".createSprintInfoXP").slideToggle("slow");
        $(".createUnitTesting").slideToggle("slow");

        handleGetTeamMembersForPP();
    });
}

/*
    Overview: Method to return all the teams members for the current selected team on the project creation page
    In:
    Out:
*/
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

/*
    Overview: Function to pass all the project information to an external PHP library using ajax
    In:
    Out:
*/
function handleCreateProjectCreate()
{

    $("#create").click(function()
    {
         if(!handleFormSubmit())
        {
            return false;
        }

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


        var teamID = $("select[name=projectTeam]").find("option:selected").attr("id");
        dataset['teamID'] = teamID;



        //find all the checked users for PP and add them to the dataset array
        ///count number of elements begining with createSprintInfoXPPP_
        var XPUsers = $("input[name^='createSprintInfoXPPP_'").length;
       // alert(XPUsers);
        for(i = 1; i <= XPUsers; i++)
        {
            //alert("LOOP " + i);
            if($("input[name=createSprintInfoXPPP_"+i+"]").is(':checked'))
            {
                    //alert("CHECKED "+i);
                dataset["PPUsers_"+i] = $("input[name=createSprintInfoXPPP_"+i+"]").attr("id");
            }
        }

        if($("input[name=createProjectUseXP]").is(":checked"))
        {
            dataset["useXP"] = "true";
        }

        if($("input[name=createUnitTesting]").is(":checked"))
        {
            dataset['useUnitTesting'] = "true";
        }

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
                            handleMessageBoxEffect("Project Successfully Created", SITE_URL+"project/");
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


/*
    Overview: Handle button to view project information
    In:
    Out:
*/
function handleProjectClickView()
{
    $(".projectHomeClick").click(function()
    {
        var id = $(this).attr("id");

        window.location = SITE_URL + "project/view/" + id;
    });
}

/*
    Overview: Handle button to view individial bugs
    In:
    Out:
*/
function handleBugClick()
{
    $(".bugHomeClick").click(function()
    {
        var id = $(this).attr("id");

        window.location = SITE_URL + "bug/view/" + id;
    })
}

/*
    Overview: Handle button to view individial employees
    In:
    Out:
*/
function handleEmployeeViewClick()
{
    $(".employeeClick").click(function()
    {
        var id = $(this).attr("id");

        window.location = SITE_URL + "employee/view/" + id;
    });
}

/*
    Overview: Function to fade between different project upon the home page
    In:
    Out:
*/
function handleHomePageProjectProgressSwitching()
{
    setTimeout("handleHomepageProgress('.projectProgress');",5000);
    setTimeout("handleHomepageProgress('.bugProgress');", 5000);
    setTimeout("handleHomepageProgress('.projectBacklogProgress');", 5000);
}

/*
    Overview: Fade different elements that have been passed into the function call
    In: element - class of element to fade between
    Out:
*/
function handleHomepageProgress(element)
{
    var maxElements = $(element).length;

    //console.log("Max Element in >>"+element+"<< : "+ maxElements);
    $(element).each(function(i)
    {
        if($(this).is(":visible"))
        {
            var currentItemID = parseInt($(this).attr("id"));
            //console.log("Current Element in >>"+element+"<< : "+ currentItemID);
            var newElementID = parseInt(currentItemID + 1);

            //console.log("Max Elements : " + maxElements);

            if(newElementID > parseInt(maxElements))
            {
                newElementID = 1;
            }
            //console.log("newElementID Element in >>"+element+"<< : "+ newElementID);

            //console.log("New Element ID: " + newElementID);

            $(this).fadeOut(2000,function()
            {
                //console.log(element+"#"+newElementID);
                $(element).asPieProgress('reset');
                $(element).filter("#"+newElementID).fadeIn(1000, function()
                {
                    $(element).asPieProgress('start');
                    handleHomePageProjectProgressSwitching();
                }).dequeue();


            }).dequeue();
        }
    });
}

/*
    Overview: Function to call external PHP library using ajax to mark a bug as either fixed or unfixed
    In:
    Out:
*/
function handleBugMarkFixed()
{
    $("#bugMarkOption").click(function()
    {
        var bugID = $("#bugID").text();

        var method = "fixed";
        if($(".projectBugsStatus").text() == "Fixed")
        {
            method = "unfix";
        }
        $.ajax({
            url:            SITE_URL+"/includes/lib/handlebug.php",
            type:           "post",
            data:           "method="+method+"&id="+bugID,
            dataType:       "text",
            success:        function(html)
            {
                console.log(html);
                if(html)
                {
                        handleMessageBoxEffect("Bug Successfully Updated", location);
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


function handleTeamCreateClick()
{
    $(".btnCreateTeam").click(function()
    {
        if(!handleFormSubmit())
        {
            return false;
        }

        var dataset = {};
        $('#createTeamForm').find('input, textarea, select, span').each(function(i, field)
        {
            dataset[field.name] = field.value;
        });

        //console.log(dataset);

        dataset = JSON.stringify(dataset);

        $.ajax({
            url:            SITE_URL+"/includes/lib/createteam.php",
            type:           "post",
            data:           "data="+dataset,
            dataType:       "text",
            success:        function(html)
            {
                console.log(html);
                    if(html)
                    {
                            handleMessageBoxEffect("Team Successfully Created", SITE_URL+"team/");
                            //$("#projectPageActivityPolling").html(html)
                           $("#createTeamForm :input").prop("disabled", true);
                    }
                    else
                    {
                            console.log("FAILED");
                    }
            }
        });

    });
}

/*
    Overview: Function to return all bug information to be sent of ajax for creation
    In:
    Out:
*/
function handleBugCreateClick()
{
    $("#btnCreateBug").click(function()
    {
        if(!handleFormSubmit())
        {
            return false;
        }

        var dataset = {};
        $('#createBugForm').find('input, textarea, select, span').each(function(i, field)
        {
            dataset[field.name] = field.value;
        });

        dataset['bugProjectID'] = $("select[name=bugProjectID]").find(":selected").attr("name");


        console.log(dataset);

        dataset = JSON.stringify(dataset);

        $.ajax({
            url:            SITE_URL+"/includes/lib/createbug.php",
            type:           "post",
            data:           "data="+dataset,
            dataType:       "text",
            success:        function(html)
            {
                console.log(html);
                    if(html)
                    {
                            handleMessageBoxEffect("Bug Successfully Created", SITE_URL+"bug/");
                            //$("#projectPageActivityPolling").html(html)
                            $("#createBugForm :input").prop("disabled", true);
                    }
                    else
                    {
                            console.log("FAILED");
                    }
            }
        });

    });
}

/*
    Overview: handle all the employee information when they are created and send using ajax
    In:
    Out:
*/
function handleEmployeeAddClick()
{
    $("#addEmployee").click(function()
    {
        if(!handleFormSubmit())
        {
            return false;
        }

        var dataset = {};
        $('#addEmployeeForm').find('input, textarea, select, span').each(function(i, field)
        {
            dataset[field.name] = field.value;
        });

        dataset['employeeTeam'] = $("select[name=employeeTeam]").find(":selected").attr("name");

        dataset['employeeAccountLevel'] = $("select[name=employeeAccountLevel]").find(":selected").attr("name");

        console.log(dataset);

        dataset = JSON.stringify(dataset);

        $.ajax({
            url:            SITE_URL+"/includes/lib/addemployee.php",
            type:           "post",
            data:           "data="+dataset,
            dataType:       "text",
            success:        function(html)
            {
                    console.log(html);
                    if(html)
                    {
                            handleMessageBoxEffect("Employee Successfully Created", SITE_URL+"employee/");

                            $("#addEmployeeForm :input").prop("disabled", true);
                    }
                    else
                    {
                            console.log("FAILED");
                    }
            }
        });

    });

}

/*
    Overview: handle operation that appears when the user requests to delete an employee
    In:
    Out:
*/
function handleDeleteEmployee()
{
    $(".deleteEmployee").click(function()
    {
        if(confirm("Are you sure you want to delete this employee?"))
        {
            return true;
        }
        return false;
    });

}

function handleDeleteProject()
{
    $(".deleteProject").click(function()
    {
        if(confirm("Are you sure you want to delete this project?"))
        {
            return true;
        }
        return false;
    });

}


/*
    Overview: Verification method that checks all the form elements for validity
    In:
    Out:
*/
function handleFormSubmit()
{
    var has_empty = false;
    var numberErrors = 0;
    var strFields = "";

    $("form").find('input,select,textarea').each(function ()
    {
        if($(this).attr("skipvalidation") != "true")
        {
            var currentMaxLength = $(this).attr("formMaxLength")

            var currentDataType = "string";
            if($(this).attr("formDataType") !== "")
            {
                currentDataType = $(this).attr("formDataType");
            }

            if($(this).val().length > currentMaxLength)
            {
                numberErrors++;
                strFields += $(this).attr("name") +" over maximum allowed length\n";
            }

            if(currentDataType == "number")
            {
                if(!$.isNumeric($(this).val()))
                {
                    numberErrors++;
                    strFields += $(this).attr("name") +" is not the correct data type\n";
                }
            }

            if(currentDataType == "email")
            {
                if(!isValidEmailAddress($(this).val()))
                {
                    numberErrors++;
                    strFields += " Email Address Is Invalid";
                }
            }

            if ($(this).val().trim() == "")
            {
                numberErrors++;
                strFields += $(this).attr("name") + "\n is empty!";

            }
        }
    });

    if(numberErrors > 0)
    {
        handleMessageBoxEffect("ERROR: "+strFields,"");
        return false;
    }

    return true;

}

/*
    Overview: Regular expression to check for a valid email address
    In:
    Out:
*/
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};



function handleFooter()
{

}