<?php


$url = 'https://www.impfportal-niedersachsen.de/portal/rest/appointments/findVaccinationCenterListFree/38126?stiko=&count=1&birthdate=600001200000';

$response = file_get_contents($url);
$response = json_decode($response, true);


if (isset($response['resultList'][0]['outOfStock'])) {
    if ($response['resultList'][0]['outOfStock'] != 1) {
        echo "Termin vorhanden! \n";
        sendEmail();
    } else {
        // sendEmailError();
    }
} else {
    // sendEmailError();
}



function sendEmail()
{
    $to = "fraqqy@gmail.com";
    $subject = "Impftermin verfügbar";
    $txt = "Go!go! go! Schnapp ihn dir!";
    $headers = "From: fraqqy@gmail.com";

    mail($to, $subject, $txt, $headers);
}


function sendEmailError()
{
    $to = "fraqqy@gmail.com";
    $subject = "Impftermin nicht verfügbar";
    $txt = "Abwarten und Tee trinken!";
    $headers = "From: fraqqy@gmail.com";

    mail($to, $subject, $txt, $headers);
}

function writeLog($msg) {
    // TODO: 
}