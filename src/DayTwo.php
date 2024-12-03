<?php

class DayTwo
{
    private string $file = __DIR__ . '/../input/2.txt';

    public function solveA(): void
    {
        $data = $this->getData();
        
        $safeCounter = 0;
        foreach ($data as $report) {
            if ($this->isSafe($report)) {
                $safeCounter++;
            }
        }

        echo $safeCounter;
    }

    private function getData(): array
    {
        $input = file_get_contents($this->file);
        $lines = explode("\n", $input);

        $data = [];
        foreach ($lines as $line) {
            $data[] = array_map('intval', explode(' ', $line));
        }

        return $data;
    }

    private function isSafe(array $report, bool $enableOneBadLevel = false): bool
    {
        $firstDiff = $report[0] - $report[1];

        if (abs($firstDiff) > 3 || $firstDiff == 0) {
            if ($enableOneBadLevel) {
                return $this->isSafeWithOneRemoved($report, 1);
            }
            return false;
        }

        for($i = 1; $i < count($report) - 1; $i++)
        {
            if (($firstDiff * ($report[$i] - $report[$i + 1]) <= 0) || (abs($report[$i] - $report[$i + 1]) > 3)) {
                if ($enableOneBadLevel) {
                    return $this->isSafeWithOneRemoved($report, $i + 1);
                }
                return false;
            }
        }

        return true;
    }

    private function isSafeWithOneRemoved(array $report, int $badIndex): bool
    {
        $removeIndexes = [];
        if ($badIndex < 3) {
            $removeIndexes = [0, 1, 2];
        } else {
            $removeIndexes = [$badIndex - 1, $badIndex];
        }

        foreach ($removeIndexes as $removeIndex) {
            $copy = $report;
            unset($copy[$removeIndex]);
            if ($this->isSafe(array_values($copy))) {
                return true;
            }
        }

        return false;
    }

    public function solveB(): void
    {
        $data = $this->getData();
        
        $safeCounter = 0;
        foreach ($data as $report) {
            if ($this->isSafe($report, true)) {
                $safeCounter++;
            }
        }

        echo $safeCounter;
    }
}