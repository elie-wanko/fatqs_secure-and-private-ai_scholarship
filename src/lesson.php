<?php
require __DIR__ . '/../common/helper.php';

$spreadsheetId = $_GET['id'];
$response = getLessonDetail($spreadsheetId);

$answers = [];
$questions = $response['questions'];
$answerValues = $response['answers'];
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
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/style.css"/>

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
            require __DIR__ . '/sidenav.php';
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
                    unset($questions['Id']);
                    foreach ($questions as $key => $question) {

                        echo "<li>";
                        echo '<a href="#" class="question" data-index="'. $key.'" data-question="' . $question . '" >' . $question . '</a>';
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="col m8 s12 answers--block card">
                <h5>Please choose a question to view the answer.</h5>
                <?php
                foreach ($questions as $key => $question) {
                    $answer = isset($answers[$key]) ? $answers[$key] : '';
                ?>
                    <div class="answers--content" data-index="<?php echo $key ?>">
                        <p><b>Q.:  </b><strong class="question-title text-accent-1"></strong></p>
                        <p>
                            <strong><b>A.:  </b></strong>
                            <span class="answer"><?php echo $answer ?></span>
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
<script type="text/javascript" src="../js/main.js"></script>

</body>
</html>
