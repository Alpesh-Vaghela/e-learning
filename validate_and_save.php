<?php

$response = array();
$errors = array();
$post_data = !empty($_REQUEST) ? $_REQUEST : array();

if (empty($post_data)):
    if (empty($post_data['first_name'])):
        $errors['first_name'] = "Please enter your first name.";
    endif;
    if (empty($post_data['last_name'])):
        $errors['last_name'] = "Please enter your last name.";
    endif;
    if (empty($post_data['phone_number'])):
        $errors['phone_number'] = "Please enter a phone number.";
    endif;
    if (empty($post_data['email_address'])):
        $errors['email_address'] = "Please enter a valid email address.";
    endif;
    if (empty($post_data['number_of_learners'])):
        $errors['number_of_learners'] = "Please endter Number of Students / Learners (Maximum).";
    endif;
    if (empty($post_data['organization'])):
        $errors['organization'] = "Please enter your organization name.";
    endif;
    if (empty($post_data['message'])):
        $errors['message'] = "Please enter message.";
    endif;
    if (empty($post_data['captcha'])):
        $errors['captcha'] = "Invalid Captcha.";
    endif;
else:
endif;
if (!empty($errors)):
    $message = '<div class="alert alert-danger" role="alert"><h4>Validation Failed, Please solve below errors to continue.</h4><ul>';
    foreach ($errors as $error):
        $message.='<li>' . $error . '</li>';
    endforeach;
    $message.='</ul></div>';
    $response['success'] = false;
    $response['message'] = $message;
else:
    $response['success'] = true;
    $response['message'] = '<div class="alert alert-success" role="alert"><h4>Your request is submitted successfully.</h4>';
endif;
echo json_encode($response);
exit;

