<?php

class DayTen
{
    private string $file = __DIR__ . '/../input/10.txt';

    private const MOVE_DIRS = [
        [-1, 0],
        [1, 0],
        [0, -1],
        [0, 1]
    ];

    public function solveA(): void
    {
        $data = $this->getData();

        $goodTrails = 0;
        foreach ($data as $row => $line) {
            foreach ($line as $col => $height) {
                if ($height != 0) {
                    continue;
                }

                $goodTrails += count($this->findGoodTrailsFor($row, $col, $data));
            }
        }

        echo $goodTrails;
    }

    private function getData(): array
    {
        $lines = explode("\n", file_get_contents($this->file));

        $data = [];
        foreach ($lines as $line) {
            $data[] = array_map('intval', str_split($line));
        }

        return $data;
    }

    private function findGoodTrailsFor($row, $col, $data, $uniqueOnly = true): array
    {
        $goodTrails = [];

        foreach (self::MOVE_DIRS as $moveDir) {
            $nextRow = $row + $moveDir[0];
            $nextCol = $col + $moveDir[1];
            if ($nextRow < 0 || $nextRow > count($data) - 1 || $nextCol < 0 || $nextCol > count($data[0]) - 1) {
                continue;
            }

            if ($data[$nextRow][$nextCol] != $data[$row][$col] + 1) {
                continue;
            }

            if ($data[$nextRow][$nextCol] == 9) {
                $goodTrails[] = [$nextRow, $nextCol];
                continue;
            }

            $goodTrails = array_merge($goodTrails, $this->findGoodTrailsFor($nextRow, $nextCol, $data, $uniqueOnly));
        }

        if ($uniqueOnly) {
            return array_unique($goodTrails, SORT_REGULAR);
        }
        return $goodTrails;
    }

    public function solveB(): void
    {
        $data = $this->getData();

        $goodTrails = 0;
        foreach ($data as $row => $line) {
            foreach ($line as $col => $height) {
                if ($height != 0) {
                    continue;
                }

                $goodTrails += count($this->findGoodTrailsFor($row, $col, $data, false));
            }
        }

        echo $goodTrails;
    }
}