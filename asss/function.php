<?php
class Plural{

    public $min;
    public $max;
    public $results;

    public function __construct($start, $end, $step) {
        $this->results = [];

        for ($i = $start; $i <= $end; $i += $step) {
            $number = $i;
            $current_value = $number;
            $max_value = $current_value;
            $iterations = 0;

            while ($current_value != 1) {
                $current_value = $current_value % 2 == 0 ? $current_value / 2 : 3 * $current_value + 1;
                $max_value = max($max_value, $current_value);
                $iterations++;
            }

            $this->results[] = [
                'number' => $number,
                'max_value' => $max_value,
                'iterations' => $iterations
            ];
        }

        $this->find_maxmin_iterations($this->results);
        $this->printResults();
    }

    public function find_maxmin_iterations($results) {
        $max_iterations = 0;
        $min_iterations = PHP_INT_MAX;

        foreach ($results as $result) {
            if ($result['iterations'] > $max_iterations) {
                $max_iterations = $result['iterations'];
                $this->max = $result;
            }
            if ($result['iterations'] < $min_iterations) {
                $min_iterations = $result['iterations'];
                $this->min = $result;
            }
        }
    }

    public function printResults() {
        echo "<h3>Results:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Number</th><th>Max Value</th><th>Iterations</th></tr>";
        foreach ($this->results as $result) {
            echo "<tr><td>{$result['number']}</td><td>{$result['max_value']}</td><td>{$result['iterations']}</td></tr>";
        }
        echo "</table>";

        echo "<h3>Number with Maximum Iterations:</h3>";
        echo "Number: {$this->max['number']}<br>";
        echo "Iterations: {$this->max['iterations']}<br>";
        echo "Max Value: {$this->max['max_value']}<br>";

        echo "<h3>Number with Minimum Iterations:</h3>";
        echo "Number: {$this->min['number']}<br>";
        echo "Iterations: {$this->min['iterations']}<br>";
        echo "Max Value: {$this->min['max_value']}<br>";

        echo "<div class='chart-container'>";
        foreach ($this->results as $result) {
            $num = $result['number'];
            $count = $result['iterations'];
            $percent = ($count / $this->max['iterations']) * 100;
            echo "<div class='bar' style='height: {$percent}%;' onmouseover='showinfo(this)' onmouseout='hideinfo(this)'>";
            echo "<div class='textinfo'>";
            echo "Number: $num<br> Iteration: $count";
            echo "</div>";
            echo "</div>";
        }
        echo '</div>';
    }
}

class Singular{
    public $sequence;
    public $maxValue;
    public $countIterations;

    function __construct($number){
        $this->calculateSequence($number);
        $this->printSequence();
    }

    public function calculateSequence($number) {
        $sequence = array();
        $sequence[] = $number;

        while ($number != 1) {
            if ($number % 2 == 0) {
                $number = $number / 2;
            } else {
                $number = 3 * $number + 1;
            }
            $sequence[] = $number;
        }

        $this->sequence = $sequence;
        $this->maxValue = max($sequence);
        $this->countIterations = count($sequence) - 1;
    }

    public function printSequence() {
        echo "Sequence for {$this->sequence[0]}: <br>";
        echo implode("<br>", $this->sequence) . "<br>";
        echo "Max Value: {$this->maxValue}<br>";
        echo "Count of Iterations: {$this->countIterations}<br>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3x + 1 Function Calculator</title>
    <style>
        .chart-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            height: 400px;
        }
        .bar {
            width: 20px;
            background-color: blue;
            margin: 0 5px;
            position: relative;
        }
        .bar:hover .textinfo {
            display: block;
        }
        .textinfo {
            display: none;
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Calculate 3x + 1 Function</h2>
    <form action="" method="post">
        <label for="start">Start Number:</label>
        <input type="number" id="start" name="start" >
        <label for="end">End Number:</label>
        <input type="number" id="end" name="end" >
        <label for="step">Arithmetic Step:</label>
        <input type="number" id="step" name="step" >
        <button type="submit">Calculate</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['start'])) {
        $start = filter_input(INPUT_POST, "start", FILTER_SANITIZE_NUMBER_INT);
        $end = filter_input(INPUT_POST, "end", FILTER_SANITIZE_NUMBER_INT);
        $step = filter_input(INPUT_POST, "step", FILTER_SANITIZE_NUMBER_INT);

        if (!is_null($start) && !is_null($end)) {
            $results = new Plural($start, $end, $step);
        } else
