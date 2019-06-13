<?php
require 'google-clients/drive-client.php';
require 'common/helper.php';

// Get the API client and construct the service object.
$client = getDriveClient();
$httpClient = $client->authorize();
$response = $httpClient->get(getenv("google_drive"));

$lessons = json_decode($response->getBody()->getContents())->items;
$lessons = sort_lessons($lessons);
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