<?php
function calculateWordFrequency($words) {
    $stopWords = ["the", "and", "in"];
    $wordFrequency = array_count_values($words);

    foreach ($stopWords as $stopWord) {
        unset($wordFrequency[$stopWord]);
    }
    return $wordFrequency;
}

function sortWordFrequency($wordFrequency, $sortOrder) {
    if ($sortOrder === "asc") {
        asort($wordFrequency);
    } else {
        arsort($wordFrequency);
    }
    return $wordFrequency;
}

function limitWordFrequency($wordFrequency, $limit) {
    return array_slice($wordFrequency, 0, $limit);
}

$inputText = "";
$selectedSortOrder = "asc";
$selectedLimit = 10;
$limitedWordFrequency = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputText = $_POST['text'];
    $selectedSortOrder = $_POST['sort'];
    $selectedLimit = $_POST['limit'];

    $words = str_word_count(strtolower($inputText), 1);

    $wordFrequency = calculateWordFrequency($words);

    $sortedWordFrequency = sortWordFrequency($wordFrequency, $selectedSortOrder);

    $limitedWordFrequency = limitWordFrequency($sortedWordFrequency, $selectedLimit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Word Frequency Counter</title>
    <style>
        body {
            font-family: Courier, lucida;
            margin: 0;
            padding: 20px;
            background-color: #ffccff;
        }

        h1 {
            text-align: center;
            font-family: Courier, lucida;
        }

        form {
            background-color: #ffccff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;

        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        textarea, select, input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-family: Courier, lucida;
        }

        select {
            height: 35px;
        }

        input[type="submit"] {
            background-color: #ffccff;
            color: #fff;
            border: 2px solid #808080;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
            font-family: Courier, lucida;
        }

        input[type="submit"]:hover {
            background-color: #ffccff;
        }

        h2 {
            margin-top: 20px;
        }

    </style>
</head>
<body>

<h1>Word Frequency Counter</h1>

<form method="post" action="">
    <label for="text">Enter Text:</label>
    <br>
    <textarea id="text" name="text" rows="5" cols="40"><?php echo $inputText; ?></textarea>
    <br>

    <label for="sort">Sort Order:</label>
    <select id="sort" name="sort">
        <option value="asc" <?php if ($selectedSortOrder === 'asc') echo 'selected'; ?>>Ascending</option>
        <option value="desc" <?php if ($selectedSortOrder === 'desc') echo 'selected'; ?>>Descending</option>
    </select>
    <br>

    <label for="limit">Limit Results:</label>
    <input type="number" id="limit" name="limit" value="<?php echo $selectedLimit; ?>" min="1" max="100">
    <br>

    <input type="submit" value="Submit">
</form>

<h1>Word Frequency Results</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<table>';
    echo '<tr><th>Word</th><th>Frequency</th></tr>';
    foreach ($limitedWordFrequency as $word => $count) {
        echo '<tr><td>' . $word . '</td><td>' . $count . '</td></tr>';
    }
    echo '</table>';
}
?>

</body>
</html>