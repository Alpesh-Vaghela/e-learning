<?php
ini_set("display_errors", 1);
ini_set('session.use_trans_sid', '0');
require 'rand.php';
session_start();
$_SESSION['captcha_id'] = $str;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>E-Learning</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
        <script type="text/javascript" src="lib/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="dist/jquery.validate.min.js"></script>
        <noscript>Your browser does not support JavaScript!</noscript>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="no-page-header" id="errorSummary"></div>
                    <div class="panel">
                        <div class="panel-body"> 
                            <div class="loader" style="display:none;"></div>
                            <form id="eLearningForm" method="post" class="form-horizontal" action="">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="first_name">First name&nbsp;<span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control alpha" id="first_name" name="first_name" placeholder="First name"  autofocus/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="last_name">Last name&nbsp;<span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control alpha" id="last_name" name="last_name" placeholder="Last name" />
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="email_address">Email Address&nbsp;<span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="email_address" name="email_address" placeholder="Email Address" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="phone_number">Phone Number&nbsp;<span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="organization">Organization&nbsp;<span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="organization" name="organization" placeholder="Organization" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="number_of_learners">Number of Students / Learners (Maximum)&nbsp;<span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control numeric" id="number_of_learners" name="number_of_learners" placeholder="Number of Students / Learners (Maximum)" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="message">Message&nbsp;<span class="required">*</span></label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control" id="message" name="message" placeholder="Message" ></textarea>
                                    </div>
                                </div>
                                <div class="form-group">                                                                        
                                    <label class = "col-sm-4 control-label" for="captchaimage">&nbsp;</label>
                                    <div class = "col-sm-5">
                                        <div id="captchaimage"><a href="<?php echo htmlEntities($_SERVER['PHP_SELF'], ENT_QUOTES); ?>" id="refreshimg" title="Click to refresh image"><img src="images/image.php?<?php echo time(); ?>" width="132" height="46" alt="Captcha image"></a></div>
                                    </div>
                                </div>
                                <div class="form-group">                                                                        
                                    <label class = "col-sm-4 control-label" for="captcha">Captcha&nbsp;<span class="required">*</span></label>
                                    <div class = "col-sm-5">
                                        <input class="form-control" placeholder="Captcha" type="text" maxlength="6" name="captcha" id="captcha">
                                        <br />
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <div class = "col-sm-9 col-sm-offset-4">
                                        <button type = "submit" class = "btn btn-primary" name = "submit" value = "Sumbit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type = "text/javascript">
            $.validator.setDefaults({
                submitHandler: function () {
                    $("#errorSummary").html("");
                    $(".loader").show();
                    $.ajax({
                        url: 'validate_and_save.php',
                        type: 'POST',
                        dataType: 'JSON',
                        data: $("#eLearningForm").serialize(),
                        success: function (response) {
                            if (response.success == true) {
                                $("#errorSummary").html(response.message);
                                $("#eLearningForm").trigger("reset");
                                $("#refreshimg").trigger("click");
                                $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
                            } else {
                                $("#errorSummary").html(response.message);
                            }
                        },
                        error: function (response, error) {
                            alert("Failed to load data.");
                        },
                        complete: function () {
                            $(".loader").hide();
                        }
                    });
                }
            });
            $(document).ready(function () {
                $("#eLearningForm").validate({
                    rules: {
                        first_name: "required",
                        last_name: "required",
                        email_address: {
                            required: true,
                            email: true
                        },
                        phone_number: {
                            required: true
                        },
                        number_of_learners: {
                            required: true
                        },
                        organization: {
                            required: true
                        },
                        message: {
                            required: true
                        },
                        captcha: {
                            required: true,
                            remote: "process.php"
                        }
                    },
                    messages: {
                        first_name: "Please enter your first name.",
                        last_name: "Please enter your last name.",
                        phone_number: "Please enter a phone number.",
                        email_address: "Please enter a valid email address.",
                        number_of_learners: "Please endter Number of Students / Learners (Maximum).",
                        organization: "Please enter your organization name.",
                        message: "Please enter message.",
                        captcha: "Correct captcha is required. Click the captcha to generate a new one."
                    },
                    errorElement: "em",
                    errorPlacement: function (error, element) {
                        // Add the `help-block` class to the error element
                        error.addClass("help-block");
                        if (element.prop("type") === "checkbox") {
                            error.insertAfter(element.parent("label"));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).parents(".col-sm-5").addClass("has-error").removeClass("has-success");
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).parents(".col-sm-5").addClass("has-success").removeClass("has-error");
                    }
                });
                $("body").on("click", "#refreshimg", function () {
                    $.post("newsession.php");
                    $("#captchaimage").load("image_req.php");
                    $("#captcha").val("");
                    return false;
                });
                $('.alpha').on('keypress', function (event) {
                    var inputValue = event.which;
                    if (!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) {
                        if (inputValue != 8 && inputValue != 13) {
                            event.preventDefault();
                        }
                    }
                });
                $('.numeric').on("keypress", function (event) {
                    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && event.which != 0 && event.which != 8 && (event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }
                });
            });
        </script>
        <style type="text/css">
            span.required{color:#ff0000;}
            .loader {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background: url('images/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
                opacity: .8;
            }
        </style>
    </body>
</html>