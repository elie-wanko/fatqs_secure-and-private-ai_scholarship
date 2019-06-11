<?php
require 'google-clients/drive-client.php';
// Get the API client and construct the service object.
$client = getDriveClient();
$httpClient = $client->authorize();
$response = $httpClient->get("https://www.googleapis.com/drive/v2/files?q='1a2V6obuD_A-A2PEo3Pk6-_uG1jxVcMTR'+in+parents&key=LhdVdfYOjlrVYJ8f4ZuBJlJF");

$lessons = json_decode($response->getBody()->getContents())->items;
?>


<ul id="slide-out" class="sidenav">
    <li>
        <div class="user-view theme--bg">
        </div>
    </li>
    <?php
    foreach($lessons as $lesson) {
        echo '<li>';
        echo '<a href = "lesson.php?id=' . $lesson->id . '&title=' . $lesson->title .'" target="_blank">' . $lesson->title . '</a>';
        echo '</li>';
    }
    ?>
</ul>