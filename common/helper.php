<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../google-api/client.php';

require __DIR__ . '/../google-api/globalvars.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

/**
 * @param $lessons
 * @return array
 */
function sort_lessons($lessons)
{
    $sorted_lessons = [];
    foreach ($lessons as $lesson) {
        $pos = strrpos($lesson->name, ":");
        $index = substr($lesson->name, $pos - 1, 1);
        $sorted_lessons[$index] = [$lesson->id, $lesson->name];
    }
    ksort($sorted_lessons);
    return $sorted_lessons;
}

/**
 * @param string $type
 * @param $scopes
 * @return Google_Service_Drive|Google_Service_Sheets
 * @throws Google_Exception
 */
function connect($type = 'Drive', $scopes)
{
    $client = getClient($scopes);
    if ($type === 'Drive') {
        return new Google_Service_Drive($client);
    }

    return new Google_Service_Sheets($client);
}

/**
 * @param null $searchText
 * @return array|Google_Service_Drive_DriveFile
 * @throws Google_Exception
 */
function getAllLessons($searchText = null)
{

    // Connect to google api
    $service = connect('Drive', Google_Service_Drive::DRIVE_METADATA_READONLY);
    $drive = getenv('drive');

    // Query Params
    $optParams = ['q' =>
        ["'{$drive}' in parents and fullText contains '{$searchText}'"]
    ];
    $results = $service->files->listFiles($optParams);
    $lessons = [];
    if (count($results->getFiles()) > 0) {
        $lessons = $results->getFiles();
        $lessons = sort_lessons($lessons);
    }
    return $lessons;
}

/**
 * @param $spreadsheetId
 * @return mixed
 * @throws Google_Exception
 */
function getLessonDetail($spreadsheetId)
{    // Connect to google api
    $service = connect('Spreadsheet', Google_Service_Sheets::SPREADSHEETS_READONLY);

    // Get Questions
    $questionRange = 'questions';
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
    $answersRange = 'answers';
    $answersResponse = $service->spreadsheets_values->get($spreadsheetId, $answersRange);
    $answerValues = $answersResponse->getValues();

    return ['questions' => $questions, 'answers' => $answerValues];
}


/**
 * @param $data
 * @param $searchText
 * @return array
 */
function search($data, $searchText)
{
    $questions_answers = [];
    foreach ($data["questions"] as $key => $d) {
        if ($key == 0) continue;
        $questions_answers[] = [
            'question' => $d,
            'answer' => isset($data["answers"][$key]) ? $data["answers"][$key] : '',
        ];
    }
    $fuse = new \wataridori\SFS\SimpleFuzzySearch($questions_answers, ["question", "answer"]);
    if ($searchText === '') {
        return $questions_answers;
    }
    $response = $fuse->search($searchText);
    $questions_answers = [];
    foreach($response as $qa){
        $questions_answers[] = [
            'question' => isset($qa[0]['question']) ? $qa[0]['question'] : '',
            'answer' => isset($qa[0]['answer']) ? $qa[0]['answer'] : ''
        ];
    }
    return $questions_answers;
}
