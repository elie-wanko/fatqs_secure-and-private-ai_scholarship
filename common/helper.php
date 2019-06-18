<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../google-api/client.php';

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
 * @param $scopes
 * @return Google_Service_Drive
 * @throws Google_Exception
 */
function connect($scopes)
{
    $client = getClient($scopes);
    $service = new Google_Service_Drive($client);
    return $service;
}

/**
 * @param null $searchText
 * @return array|Google_Service_Drive_DriveFile
 * @throws Google_Exception
 */
function getAllLessons($searchText = null)
{

    // Connect to google api
    $service = connect(Google_Service_Drive::DRIVE_METADATA_READONLY);
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
{
    // Connect to google api
    $service = connect(Google_Service_Sheets::SPREADSHEETS_READONLY);

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

    return $answerValues;
}
