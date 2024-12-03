<?php

class DayOne
{
    private string $file = __DIR__ . '/../input/1.txt';

    public function solveA(): void
    {
        $data = $this->getData();

        sort($data['left']);
        sort($data['right']);

        $sumOfDiffs = 0;
        for ($index = 0; $index < count($data['left']); $index++) {
            $sumOfDiffs += abs($data['left'][$index] - $data['right'][$index]);
        }

        echo $sumOfDiffs;
    }

    private function getData(): array
    {
        $data = [
            'left' => [],
            'right' => []
        ];

        $input = file_get_contents($this->file);
        $lines = explode("\n", $input);

        foreach ($lines as $line) {
            list($left, $right) = explode("   ", $line);
            $data['left'][] = $left;
            $data['right'][] = $right;
        }

        return $data;
    }

    public function solveB(): void
    {
        $data = $this->getData();

        $val = 0;
        for ($index = 0; $index < count($data['left']); $index++) {
            $currentLeftElement = $data['left'][$index];
            $val += $data['left'][$index] * count(array_filter($data['right'], function ($element) use ($currentLeftElement) { return $element == $currentLeftElement; }));
        }

        echo $val;
    }
}