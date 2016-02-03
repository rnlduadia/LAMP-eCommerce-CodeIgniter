defaultPageSettings = {
    site: location.origin//window.site//location.hostname
};

manDom = {
    alignTop : function(){
        var buttonPos   = Math.floor($(".left").offset().left);
        var buttonWidth = $(".left").width();
        var menuPos     = Math.floor($("#menu ul").offset().left);
        var menuWidth   = Math.floor($("#menu ul").width());

        var newLeft = 0;

        var menuLeft    = menuPos + menuWidth;
        var buttonLeft  = buttonPos + buttonWidth;
        if(buttonLeft > menuLeft){
            dif = buttonLeft - menuLeft;
            newLeft += (dif + 10);
        }
        if(newLeft){
            $("#menu ul").css("left", newLeft+"px");
        }
    },
    alignBtmH : function(){
        var sects   = $(".footSections");
        var first;
        var second;
        var dif;

        for(i=0;i<sects.length;i++){
            first   = $(".footSections").eq(i).find("span").eq(0).offset().left;
            second  = $(".footSections").eq(i).find("span").eq(1).offset().left;
            dif     = second - first;
            $(".footSections").eq(i).find("h3").width(Math.ceil(dif)+"px");
        }
    },
    alignMember : function(){
        winWidth    = $(window).width();
        winWidth    = parseInt(winWidth);
        memberWidth = $("#memberLogin").width();
        memberWidth = parseInt(memberWidth);
        memberOffset= (winWidth > memberWidth) ? (winWidth - memberWidth) : 0;
        memberLeft  = (memberOffset) ? (memberOffset / 2) : 0;
        $("#memberLogin").css("left", memberLeft+"px");
        $("#forgotPass").css("left", memberLeft+"px");
    },
    setColumnHeight : function(){
        getHeight = $(".howColumn").eq(1).css("height");
        $("#howColumnFirst").css("height",getHeight);
        $("#howColumnLast").css("height", getHeight);
    }
};

function load(){
    manDom.alignTop();
    manDom.alignBtmH();
    manDom.alignMember();
    manDom.setColumnHeight();
    /*$("#submitLogin").on("click", function(){
        memberLogin();
    });*/
    $("#forgotPassword").on("click", function(){

    });
}
window.addEventListener("resize", function(){
    manDom.alignTop();
    manDom.alignMember();
    manDom.setColumnHeight();
});


$("#submitLogin").on("click", function(){
    var userName    = $("#name").val();
    var password        = $("#pass").val();
    var csrf = $("#csrf").val();
    if(!userName || !password){
        alert("You left required fields blank.");
    }
    else{
       		$.post( defaultPageSettings.site +"/user/login",{name:userName,pass:password,csrf:csrf}, function(result){
		var  convert = JSON.parse(result);
	            if(convert.result == 1)
	            {
                        $("#frmLogin").attr("action", defaultPageSettings.site+"/user/login_and_refresh" + extra_url);
                        $("#frmLogin").submit();
                        //$(window.event).attr('returnValue',false);
                        //$(window.location).attr('href', defaultPageSettings.site +"/buyer");//redirect to the user page

                    }
	            else
	            {
	                // $('.custom-message-box').fadeIn('slide');
	                // $('.custom-message-box').delay(1500).fadeOut();
	                alert(convert.message);
	            }
		});
    }
    });

function response(data){
    if(data){
        $("#memberLogin").hide();
        $("#cover").hide();
    }
    else{
        alert("There was a problem logging in.");
    }
}
$("#memberClick").on("click", function(){
    $("#cover").show();
    $("#memberLogin").show();
    $("#name").focus();
});

$("#memberClick").on("show", function(){
    $("#name").focus();
});

$("#forgotPasswordPop").on("click", function(){
    $("#cover").show();
    $("#memberLogin").hide();
    $("#forgotPass").show();
});
$("#cover").on("click", function(){
    document.getElementById("memberLogin").style.display = "none";
    document.getElementById("cover").style.display = "none";
    document.getElementById("forgotPass").style.display = "none";
});
$("#sendMessage").on("click", function(){
    name = $("#contactName").val();
    email = $("#contactEmail").val();
    phone = $("#contactPhone").val();
    message = $("#contactMessage").val();
    $.post("script/sendContact.php", {
        contactName : name,
        contactEmail : email,
        contactPhone : phone,
        contactMessage : message
    }, function(data){
        if(data == "success"){
            $("#popupConfirm").html("<p id='contactMessage' class='success'>Thank you! Somebody will get back to you as soon as possible.</p>");
            $("#popupConfirm").fadeToggle(700).delay(1800).fadeToggle(1200);
        }
        else{
            $("#popupConfirm").html("<p id='contactMessage' class='failed'>There was a problem sending your message.</p>");
            $("#popupConfirm").fadeToggle(700).delay(1800).fadeToggle(1200);
        }
    });
});

$('#submitForgotPass').click(function(){
		var email = $('#forgotPassEmail').val();
    	var csrf = $("#csrf").val();
		$.post( defaultPageSettings.site +"/user/forgot",{email:email,csrf:csrf},function(result){
			//alert(result);
			//return false;
			var  convert = JSON.parse(result);
			//alert()
			$('.result-pass').hide();
			$('.result-pass').html(convert.message);
			$('.result-pass').show();

                        if (convert.status == 1)
			{
				$('#forgotPassEmail').val("");
			}
		});
	});
