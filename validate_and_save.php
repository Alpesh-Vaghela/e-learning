<?php

$response = array();
$errors = array();
$post_data = !empty($_REQUEST) ? $_REQUEST : array();
$first_name = (!empty($post_data['first_name'])) ? $post_data['first_name'] : "";
$last_name = (!empty($post_data['last_name'])) ? $post_data['last_name'] : "";
$phone_number = (!empty($post_data['phone_number'])) ? $post_data['phone_number'] : "";
$email_address = (!empty($post_data['email_address'])) ? $post_data['email_address'] : "";
$number_of_learners = (!empty($post_data['number_of_learners'])) ? $post_data['number_of_learners'] : "";
$organization = (!empty($post_data['organization'])) ? $post_data['organization'] : "";
$message = (!empty($post_data['message'])) ? $post_data['message'] : "";
$captcha = (!empty($post_data['captcha'])) ? $post_data['captcha'] : "";

if (!empty($post_data)):
    if (empty($first_name)):
        $errors['first_name'] = "Please enter your first name.";
    endif;
    if (empty($last_name)):
        $errors['last_name'] = "Please enter your last name.";
    endif;
    if (empty($email_address)):
        $errors['email_address'] = "Please enter a valid email address.";
    endif;
    if (empty($phone_number)):
        $errors['phone_number'] = "Please enter a phone number.";
    endif;
    if (empty($number_of_learners)):
        $errors['number_of_learners'] = "Please endter Number of Students / Learners (Maximum).";
    endif;
    if (empty($organization)):
        $errors['organization'] = "Please enter your organization name.";
    endif;
    if (empty($message)):
        $errors['message'] = "Please enter message.";
    endif;
    if (empty($captcha)):
        $errors['captcha'] = "Invalid Captcha.";
    endif;
else:
    $errors['invalid'] = 'No data submitted.';
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
    $request = array("success" => true, "data" => array("first_name" => $clientContact->firstname, "last_name" => $clientContact->lastname, "email_address" => $model->email, "organization" => $model->company_name, "message" => $model->comments, "number_of_learners" => $model->number_of_learners));
    $params = json_encode($request);
    $url = "http://192.168.0.146/yiipms/webservice/elearningsave";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $responseFromERP = curl_exec($ch);
    curl_close($ch);
    $responseFromERPArr = json_decode($responseFromERP, true);
    if (!empty(!empty($responseFromERPArr['success']))) {
        $response['success'] = true;
        $response['message'] = '<div class="alert alert-success" role="alert"><h4>Your request is submitted successfully.</h4>';
    } else {
        //Error handling of repsponse from ERP
    }
endif;
echo json_encode($response);
exit;

