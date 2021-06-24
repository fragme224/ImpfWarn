<?php

$parameters = [
    'chat_id' => '921746690',
    'text' => 'Es gibt einen IMPFTERMIN!!!'
];

while (true) {
    $url = 'https://www.impfportal-niedersachsen.de/portal/rest/appointments/findVaccinationCenterListFree/38126?stiko=&count=1&birthdate=600001200000';

    $response = file_get_contents($url);
    $response = json_decode($response, true);


    if (isset($response['resultList'][0]['outOfStock'])) {
        if ($response['resultList'][0]['outOfStock'] != 1) {
            echo "Termin vorhanden! \n";
            // sendEmail();
            sendTelegramMessage('sendMessage', $parameters);
        } else {
            // sendEmailError();
            // sendTelegramMessage('sendMessage', $parameters);
        }
    } else {
        // sendEmailError();
        // sendTelegramMessage('sendMessage', $parameters);
    }

    sleep(30);
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


function writeLog($msg)
{
    // TODO: 
}


function sendTelegramMessage($method, $parameters)
{
    $botToken = '1858527465:AAH8gGuTXFQohDkYHK8j0Gyu5jxCHyqIdz8';
    $url = 'https://api.telegram.org/bot' . $botToken . '/' . $method;

    if (!$curl = curl_init()) {
        exit();
    }

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($curl);
    return $output;
}
