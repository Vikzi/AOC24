<?php

class DayFour
{
    private const HORIZONTAL = 1;
    private const VERTICAL = 2;
    private const DIAGONALFRONT = 3;
    private const DIAGONALBACK = 4;

    private const ADD_INDEXES = [
        self::HORIZONTAL => [[1, 0], [2, 0], [3, 0]],
        self::VERTICAL => [[0, 1], [0, 2], [0, 3]],
        self::DIAGONALFRONT => [[1, 1], [2, 2], [3, 3]],
        self::DIAGONALBACK => [[-1, 1], [-2, 2], [-3, 3]]
    ];

    private string $file = __DIR__ . '/../input/4.txt';

    public function solveA(): void
    {
        $data = $this->getData();

        $xmasCounter = 0;
        foreach($data as $y => $line) {
            foreach ($line as $x => $char) {
                if ($y < count($data) - 3 && $this->checkXmas($x, $y, $data, self::VERTICAL)) {
                    $xmasCounter++;
                }

                if ($x < count($line) - 3 && $this->checkXmas($x, $y, $data, self::HORIZONTAL)) {
                    $xmasCounter++;
                }

                if ($y < count($data) - 3 && $x < count($line) - 3 && $this->checkXmas($x, $y, $data, self::DIAGONALFRONT)) {
                    $xmasCounter++;
                }

                if ($y < count($data) - 3 && $x > 2 && $this->checkXmas($x, $y, $data, self::DIAGONALBACK)) {
                    $xmasCounter++;
                }
            }
        }

        echo $xmasCounter;
    }

    private function getData(): array
    {
        $lines = explode("\n", file_get_contents($this->file));

        $data = [];
        foreach ($lines as $line) {
            $data[] = str_split($line);
        }

        return $data;
    }

    private function checkXmas($x, $y, $data, $dir): bool
    {
        $addIndexes = self::ADD_INDEXES[$dir];

        $substr = $data[$x][$y];
        foreach ($addIndexes as $index) {
            $substr .= $data[$x + $index[0]][$y + $index[1]];
        }

        if ($substr == 'XMAS' || $substr == 'SAMX') {
            return true;
        }

        return false;
    }

    public function solveB(): void
    {
        $data = $this->getData();

        $xmasCounter = 0;
        for ($i = 1; $i < count($data[0]) - 1; $i++) {
            for ($j = 1; $j < count($data) - 1; $j++) {
                $frontdiag = $data[$i - 1][$j - 1] . $data[$i][$j] . $data[$i + 1][$j + 1];
                $backdiag = $data[$i - 1][$j + 1] . $data[$i][$j] . $data[$i + 1][$j - 1];

                if (($frontdiag == 'MAS' || $frontdiag == 'SAM') && ($backdiag == 'MAS' || $backdiag == 'SAM')) {
                    $xmasCounter++;
                }
            }
        }

        echo $xmasCounter;
    }
}