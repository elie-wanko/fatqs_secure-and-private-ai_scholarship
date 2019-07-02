<?php
    require __DIR__ . '/../common/helper.php';

    echo json_encode(getAllLessons($searchText));
?>