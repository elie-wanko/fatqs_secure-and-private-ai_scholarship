<?php
require __DIR__ . '/../common/helper.php';

$spreadsheetId = $_GET['id'];
$response = getLessonDetail($spreadsheetId);

$answers = [];
$data['questions'] = $response['questions'];
$data['answers'] = $response['answers'];

$searchText = '@';
if (isset($_GET['search_text'])) {
    $searchText = $_GET['search_text'];
}

$searchResults = search($data, $searchText);
$docID = $_GET['id'];
$title = $_GET['title'];
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
                echo $title;
                ?>
            </h4>
            <form action="<?php $_SERVER["PHP_SELF"] ?>">
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix active">search</i>
                        <input type="text" id="search_text" name="search_text" class="materialize-textarea">
                        <label for="search_text">Enter your search query</label>
                        <input type="hidden" name="id" value="<?php echo $docID; ?>">
                        <input type="hidden" name="title" value="<?php echo $title; ?>">
                    </div>
                </div>
            </form>
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
                    foreach ($searchResults as $key => $result) {
                        echo "<li>";
                        echo '<a href="#" class="question" data-index="' . $key . '" >' . $result['question'] . '</a>';
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="col m8 s12 answers--block card">
                <?php
                foreach ($searchResults as $key => $result) {
                    ?>
                    <div class="answers--content" data-index="<?php echo $key ?>">
                        <p><b>Q.: </b>
                            <strong class="question-title text-accent-1">
                                <?php echo $result['question'] ?>
                            </strong>
                        </p>
                        <p>
                            <strong><b>A.: </b></strong>
                            <span class="answer"><?php echo $result['answer'][2]  ?></span>
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
