<?php

class CollatzCalculator {
    public function calculateIterations($x) {
        $count = 0;
        while ($x != 1) {
            if ($x % 2 == 0) {
                $x /= 2;
            } else {
                $x = 3 * $x + 1;
            }
            $count++;
        }
        return $count;
    }
}

class RangeAnalyzer {
    private $collatzCalculator;

    public function __construct() {
        $this->collatzCalculator = new CollatzCalculator();
    }

    public function calculateMaxAndMinValues($start, $end) {
        $maxValue = 0;
        $minValue = PHP_INT_MAX;
        $maxNumbers = [];
        $minNumbers = [];
        $totalIterations = 0;

        for ($i = $start; $i <= $end; $i++) {
            $currentIterations = $this->collatzCalculator->calculateIterations($i);
            $totalIterations += $currentIterations;

            if ($currentIterations > $maxValue) {
                $maxValue = $currentIterations;
                $maxNumbers = [$i];
            } elseif ($currentIterations == $maxValue) {
                $maxNumbers[] = $i;
            }

            if ($currentIterations < $minValue) {
                $minValue = $currentIterations;
                $minNumbers = [$i];
            } elseif ($currentIterations == $minValue) {
                $minNumbers[] = $i;
            }
        }

        return [
            'max_value' => $maxValue,
            'max_numbers' => $maxNumbers,
            'min_value' => $minValue,
            'min_numbers' => $minNumbers,
            'total_iterations' => $totalIterations
        ];
    }

    public function mathematicProgression($start, $end, $step) {
        $sequence = [];
        for ($i = $start; $i <= $end; $i += $step) {
            $sequence[] = $i;
        }
        return $sequence;
    }
}

// Usage
$rangeAnalyzer = new RangeAnalyzer();

$startRange = (int)readline("Enter the start of the range: ");
$endRange = (int)readline("Enter the end of the range: ");

echo "\nFinding max and min values and numbers with max and min iterations for range $startRange to $endRange\n";
$result = $rangeAnalyzer->calculateMaxAndMinValues($startRange, $endRange);
echo "Max value: " . $result['max_value'] . "\n";
echo "Numbers achieving max value: " . implode(", ", $result['max_numbers']) . "\n";
echo "Min value: " . $result['min_value'] . "\n";
echo "Numbers achieving min value: " . implode(", ", $result['min_numbers']) . "\n";
echo "Total iterations: " . $result['total_iterations'] . "\n";

// Example of using mathematicProgression method
$startProgression = (int)readline("\nEnter the start of the progression: ");
$endProgression = (int)readline("Enter the end of the progression: ");
$stepProgression = (int)readline("Enter the step of the progression: ");

$progression = $rangeAnalyzer->mathematicProgression($startProgression, $endProgression, $stepProgression);
echo "\nMathematic progression from $startProgression to $endProgression with step $stepProgression: ";
echo implode(", ", $progression);
echo "\n";
?>
