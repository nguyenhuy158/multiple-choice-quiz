<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Quiz</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .special-card {
            opacity: .1;
        }

        body {
            background-color: #333;
        }

        .container {
            background-color: #555;
            color: #ddd;
            border-radius: 10px;
            padding: 20px;
            font-family: 'Montserrat', sans-serif;
            max-width: 700px;
        }

        .container > p {
            font-size: 32px;
        }

        .question {
            width: 75%;
        }

        .options {
            position: relative;
            padding-left: 40px;
        }

        #options label {
            display: block;
            margin-bottom: 15px;
            font-size: 14px;
            cursor: pointer;
        }

        .options input {
            opacity: 0;
        }

        .checkmark {
            position: absolute;
            top: -1px;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #555;
            border: 1px solid #ddd;
            border-radius: 50%;
        }

        .options input:checked ~ .checkmark:after {
            display: block;
        }

        .options .checkmark:after {
            content: "";
            width: 10px;
            height: 10px;
            display: block;
            background: white;
            position: absolute;
            top: 50%;
            left: 50%;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: 300ms ease-in-out 0s;
        }

        .options input[type="radio"]:checked ~ .checkmark {
            background: #21bf73;
            transition: 300ms ease-in-out 0s;
        }

        .options input[type="radio"]:checked ~ .checkmark:after {
            transform: translate(-50%, -50%) scale(1);
        }

        .btn-primary {
            background-color: #555;
            color: #ddd;
            border: 1px solid #ddd;
        }

        .btn-primary:hover {
            background-color: #21bf73;
            border: 1px solid #21bf73;
        }

        .btn-success {
            padding: 5px 25px;
            background-color: #21bf73;
        }

        @media (max-width: 576px) {
            .question {
                width: 100%;
                word-spacing: 2px;
            }
        }
    </style>
</head>
<body>

<div class="container  my-1">
    <div class="d-flex justify-content-around py-3">
        <div>
            <a class='btn btn-lg btn-primary' href="index.php">Home</a>
        </div>
    </div>
</div>

<?php
require_once('configDB.php');
$lesson_id = $_GET['lesson_id'];
$question_id = $_GET['question_id'];
$question_length = executeResult("SELECT count(*) as length from `questions` WHERE lesson_id = '$lesson_id'", true)['length'];

$query = "SELECT * FROM `questions` WHERE stt = '$question_id' AND lesson_id = '$lesson_id'";
$response = executeResult($query, true);
?>
<div class="container mt-sm-5 my-1">
    <div class="question ml-sm-5 pl-sm-5 pt-2">
        <div class="py-2 h5"><b>
                <?= $response['question'] ?>
            </b></div>
        <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">

            <label class="options"><?= $response['option1'] ?>
                <input type="radio" name="radio" value="1">
                <span class="checkmark"></span>
            </label>

            <label class="options"><?= $response['option2'] ?>
                <input type="radio" name="radio" value="2">
                <span class="checkmark"></span>
            </label>

            <label class="options"><?= $response['option3'] ?>
                <input type="radio" name="radio" value="3">
                <span class="checkmark"></span>
            </label>

            <label class="options"><?= $response['option4'] ?>
                <input type="radio" name="radio" value="4">
                <span class="checkmark"></span>
            </label>

            <!--            answer-->
            <input type="hidden" name="answer" value="<?= $response['answer'] ?>">

            <!--            when wrong-->
            <label class="options p-3" id="when_wrong">
            </label>
        </div>
    </div>
    <div class="d-flex align-items-center pt-3">
        <?php
        if ($question_id - 1 != 0) {
            echo
                "
            <div id='prev'>
                <form action='./lesson.php' method='get'>
                    <input type='hidden' name='lesson_id' value='" . $lesson_id . "'>
                    <input type='hidden' name='question_id' value='" . $question_id - 1 . "'>
                    <button class='btn btn-primary'>Previous</button>
                </div>
            </form>
            ";
        } else {
            echo
                "
            <div id='prev'>
                <form action='./lesson.php' method='get'>
                    <input type='hidden' name='lesson_id' value='" . $lesson_id . "'>
                    <input type='hidden' name='question_id' value='" . $question_id - 1 . "'>
                    <button class='btn btn-primary' style='pointer-events: none;' disabled>Previous</button>
                </form>
            </div>
            ";
        }
        ?>

        <?php
        if ($question_id + 1 <= $question_length) {
            echo
                "
            <div class='ml-auto '>
                <form action='./lesson.php' method='get'>
                    <input type='hidden' name='lesson_id' value='" . $lesson_id . "'>
                    <input type='hidden' name='question_id' value='" . $question_id + 1 . "'>
                    <button class='btn btn-success'>Next</button>
                </form>
            </div>
            ";
        } else {
            echo
                "
            <div class='ml-auto '>
                <form action='./lesson.php' method='get'>
                    <input type='hidden' name='lesson_id' value='" . $lesson_id . "'>
                    <input type='hidden' name='question_id' value='" . $question_id + 1 . "'>
                    <button class='btn btn-success' style='pointer-events: none;' disabled>Next</button>
                </form>
            </div>
            ";
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

<script>
    $("input[type='radio']").click(function (e) {
        console.log($(this).attr('value') == $("input[name='answer']").attr('value'));
        $("input[type='radio']").attr('disabled', 'disabled');
        $("input[type='radio']").attr('style', 'pointer-events: none');
        $("input[type='radio']").parent().attr('style', 'pointer-events: none');
        $("input[type='radio']").parent().attr('class', $("input[type='radio']").parent().attr('class') + ' special-card');

        if ($(this).attr('value') != $("input[name='answer']").attr('value')) {

            $('#when_wrong').text($(`input[name='radio'][value='${$("input[name='answer']").attr('value')}']`).parent().text().trim());
            $("#when_wrong").attr('class', 'option border rounded p-3');

        }
    })
</script>
</body>
</html>