<?php

require 'google-clients/sheet-client.php';

// Get the API client and construct the service object.
$client = getDriveClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
$spreadsheetId = $_GET['id'];

// Get Questions
$questionRange = 'questions!A2:B3';
$questionResponse = $service->spreadsheets_values->get($spreadsheetId, $questionRange);
$questionValues = $questionResponse->getValues();

$questions = [];

if (empty($questionValues)) {
    print "No data found.\n";
} else {
    foreach ($questionValues as $row) {
        $questions[$row[0]] = $row[1];
    }
}


// Get Answers
$answers = [];
$answersRange = 'answers!A2:C3';
$answersResponse = $service->spreadsheets_values->get($spreadsheetId, $answersRange);
$answerValues = $answersResponse ->getValues();

if (empty($answerValues)) {
    print "No data found.\n";
} else {
    foreach ($answerValues as $row) {
        $answers[$row[1]] = $row[2];
    }
}

?>

<table>
    <thead>
        <th>ID</th>
        <th>Question</th>
        <th>Answer</th>
    </thead>
    <tbody>
        <?php
            foreach ($questions as $key => $question) {
                echo "<tr>";
                    echo "<td>";
                        echo $key;
                    echo "</td>";

                    echo "<td>";
                        echo $question;
                    echo "</td>";

                    echo "<td>";
                        echo $answers[$key];
                    echo "</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

