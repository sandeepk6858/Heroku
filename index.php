<?php 

$json = file_get_contents('php://input');
$data = json_decode($json,true);

//get user id from file
$user_id = $data['config']['user_id'];

if ( $user_id != "") {

  //get email from api by user id
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://www.eventbriteapi.com/v3/users/'.$user_id.'/?token=B6DJJX73BWHK4A4EHQAI',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Cookie: mgrefby=; G=v%3D2%26i%3Db2e6c4e5-f47c-4676-b5a7-0baa87cf06ec%26a%3Ddc4%26s%3D75c2d51258a99d8943d7917496eca7a0bdf1788c; SS=AE3DLHSHPC1xDVqljqiKv9YFmHyxzgRbRA; eblang=lo%3Den_US%26la%3Den-us; AS=4b62a42c-9f7c-47b6-ab7c-fa7e01b6fca0; mgref=typeins; SP=AGQgbbk12vfak6QuecwyQbIlgwMcu5nNfuHFlGTXPrzUnofaO3K28vw3MDQx2bFHezr3NWwbOXffoLqPwdMXDPE_zcX_BSYcaMNRsjOCwog-5ECKByTgk-9chIIQyu8C54wZTWPKGbl9Hhxna8TNcIkQKa48joBW7fQ0vLWz0gfXqBaZz-JAiHa-iVDfvByYcg73NIhES-rtgK7YeYgLowWsHx4b3rvY-U6-MacSAzx8N9oTo0o_kyc'
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);

  $data = json_decode($response,true);
  foreach ($data['emails'] as $value) {
    $email = $value['email'];
  }
    if ($email != "" ) {

      $Adminemail = 'zach@getfilteroff.com';

      // Please Change Api Here
      $token = "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"; 
      $message = "<p>Hi there,</p>
                    <p>Thanks so much for registering for the upcoming video speed dating event on Filter Off!</p>
                    <p>Here’s what to do next:</p>
                    <ol>
                      <li>Install the  <a href='https://www.getfilteroff.com/'>Filter Off app</a> (iOS / Android)</li>
                      <li>Create your profile</li>
                      <li>RSVP to your upcoming event</li>
                      <li>Confirm your attendance up to 1 hour before the event - Filter Off will send you a reminder</li>
                      <li>Filter Off will schedule your dates — all you need to do is show up!</li>
                    </ol>
                    <p>If you do not see your event listed in the app, it may mean that the event was canceled or rescheduled due to low attendance. Not to worry, we also offer a free matchmaking service that sets you up with people nearby.</p>
                    <p>If you’re an organization and interested in hosting your own virtual speed dating event you can create one here <a href='https://www.getfilteroff.com/events.html'>(run an event)</a>.</p> 
                    <p>Happy Dating,</p>
                    <p>Filter Off</p>";
      $data = array (
              'personalizations' => 
              array (
                0 => 
                array (
                  'to' => 
                  array (
                    0 => 
                    array (
                      'email' => $email,
                    ),
                  ),
                ),
              ),
              'from' => 
              array (
                'email' => $Adminemail,
              ),
              'subject' => 'Event',
              'content' => 
              array (
                0 => 
                array (
                  'type' => 'text/html',
                  'value' =>  $message,
                ),
              ),
            );
      $json = json_encode($data);
        

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.sendgrid.com/v3/mail/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $json,
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'MIME-Version: 1.0',
          'Reply-To: <'.$Adminemail.'>',
          'Content-type: text/html; charset=utf-8\r\n',
          'Authorization: Bearer '.$token
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);

   }else{
       echo json_encode(array("message" => "Email Not Found"));
    }

}else{
   echo json_encode(array("message" => "Bad Request"));
}
?>