<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3x + 1 Function Calculator</title>
</head>
<body>
    <h2>Calculate 3x + 1 Function</h2>
    <form action="index.php" method="post">
        <label for="start">Start Number:</label>
        <input type="number" id="start" name="start" >
        <label for="end">End Number:</label>
        <input type="number" id="end" name="end" >
        <label for="step">Arithmetic Step:</label>
        <input type="number" id="step" name="step" >
        <button type="submit">Calculate</button>
    </form>

    <?php
    // Include necessary files
    include 'functions.php';

    // Check if form is submitted and inputs are not empty
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['start'])) {
        // Sanitize inputs
        $start = filter_input(INPUT_POST, "start", FILTER_SANITIZE_NUMBER_INT);
        $end = filter_input(INPUT_POST, "end", FILTER_SANITIZE_NUMBER_INT);
        $step = filter_input(INPUT_POST, "step", FILTER_SANITIZE_NUMBER_INT);

        // Check if start and end are not null
        if (!is_null($start) && !is_null($end)) {
            // Perform calculation
            $results = new Plural($start, $end, $step);
            
            // Display results
            echo "<h3>Results:</h3>";
            echo "<ul>";
            foreach ($results as $result) {
                echo "<li>$result</li>";
            }
            echo "</ul>";
        } else {
            // Handle error if start or end is null
            echo "Please provide valid start and end numbers.";
        }
    }
    ?>
</body>
</html>
