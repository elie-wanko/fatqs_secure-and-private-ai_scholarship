<?php
require 'google-clients/sheet-client.php';
// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);
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
$answerValues = $answersResponse->getValues();

if (empty($answerValues)) {
    print "No data found.\n";
} else {
    foreach ($answerValues as $row) {
        $answers[$row[1]] = $row[2];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/style.css"/>

</head>

<body>
<header>
    <nav class="header__top theme--bg">
        <div class="nav-wrapper">
            <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <h4>
                <?php
                    echo $_GET['title'];
                ?>
            </h4>
            <?php
            require 'sidenav.php';
            ?>
        </div>
    </nav>
</header>
<section class="content--block">
    <div class="container-lg">
        <div class="row">
            <div class="col m4 s12 questions--block">
                <h5>Frequently Asked Technical Questions</h5>
                <ul>
                    <?php
                    foreach ($questions as $key => $question) {
                        echo "<li>";
                        echo '<a href="#" class="question" data-question="' . $question .'" data-answer="' . $answers[$key] . '" >' . $question . '</a>';
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="col m8 s12 answers--block card">
                <h5>Please choose a question to view the answer.</h5>
                <div id="answers--block" class="hiddendiv">
                    <p>Q: <strong class="question-title text-accent-1"></strong></p>
                    <p>
                        <strong>Ans.</strong>
                        <span class="answer"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>

</body>
</html>
        