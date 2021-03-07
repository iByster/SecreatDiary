$("#sign-in-switch").click(function(){
    $("#sign-in").css("display", "block");
    $("#login").css("display", "none");

});


$("#login-switch").click(function(){
    $("#sign-in").css("display", "none");
    $("#login").css("display", "block");
});





/* $('#sign-in-btn').click(function(){
    $.ajax({
        url: '../index.php' , 
        type: 'POST'
     });   
     return false;     
  });
 */


/* $("#login-panel").submit(function(e){
    e.preventDefault();

    var err = "";

    if($("#email-login").val() == ""){
        err += "<p>The email address field is required!</p>";
    }

    if($("#password-login").val() == ""){
        err += '<p>The password field is required!</p>';
    }

    if(err.length != ""){
        $("#login-errors").html('<div class="alert alert-danger" role="alert"><p><strong>There were error(s) in your form:</strong></p>' + err + '</div>')
        return false;
    } else {
        $("#login-panel").unbind("submit").submit();
        return true;
    }
    
});


$("#signup-panel").submit(function(e){
    e.preventDefault();
    
    var err = "";

    if($("#email-sign-up").val() == ""){
        err += "<p>The email address field is required!</p>";
    }

    if($("#password-sign-in").val() == ""){
        err += '<p>The password field is required!</p>';
    }

    if($("#repassword-sign-in").val() == ""){
        err += '<p>The password field is required!</p>';
    }

    if($("#password-sign-in").val() != $("#repassword-sign-in").val()) {
        err += '<p>The passwords do not match!</p>';
    }

    if(err.length != ""){
        $("#sign-in-errors").html('<div class="alert alert-danger" role="alert"><p><strong>There were error(s) in your form:</strong></p>' + err + '</div>')
        return false;
    } else {
        $("#signup-panel").unbind("submit").submit();
        return true;
    }
}); */
