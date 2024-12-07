<?php

class DaySix
{
    private const DIR_LEFT = 0;
    private const DIR_UP = 1;
    private const DIR_RIGHT = 2;
    private const DIR_DOWN = 3;

    private const DIR_TO_ARROW_MAPPING = [
        self::DIR_LEFT => '<',
        self::DIR_RIGHT => '>',
        self::DIR_UP => '^',
        self::DIR_DOWN => 'v'
    ];

    private string $file = __DIR__ . '/../input/6.txt';

    public function solveA(): void
    {
        $data = $this->getData();

        list($posX, $posY, $dir) = $this->getGuardPos($data);

        $visitedCoords = [];
        while (true) {
            if (!in_array([$posX, $posY], $visitedCoords)) {
                $visitedCoords[] = [$posX, $posY];
            }

            if ($this->guardIsExiting($posX, $posY, $dir, $data)) {
                break;
            }

            list($posX, $posY, $dir) = $this->move($posX, $posY, $dir, $data);
        }

        echo count($visitedCoords);
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

    private function getGuardPos(array $data): array
    {
        foreach ($data as $row => $line) {
            foreach (self::DIR_TO_ARROW_MAPPING as $dir => $char) {
                $col = array_search($char, $line);

                if ($col === false) {
                    continue;
                }

                return [$row, $col, $dir];
            }
        }

        return [-1, -1, -1];
    }

    private function guardIsExiting(int $posX, int $posY, int $dir, array $data): bool
    {
        // kösz a tippet feri :):):P
        return ($posX == 0 && $dir == self::DIR_UP) ||
            ($posX == (count($data) - 1) && $dir == self::DIR_DOWN) ||
            ($posY == 0 && $dir == self::DIR_LEFT) ||
            ($posY == (count($data[0]) - 1) && $dir == self::DIR_RIGHT);
    }

    private function move(int $posX, int $posY, int $dir, array $data): array
    {
        if (
            ($dir == self::DIR_UP && $data[$posX - 1][$posY] == '#') ||
            ($dir == self::DIR_DOWN && $data[$posX + 1][$posY] == '#') ||
            ($dir == self::DIR_LEFT && $data[$posX][$posY - 1] == '#') ||
            ($dir == self::DIR_RIGHT && $data[$posX][$posY + 1] == '#')
        ) {
            return [$posX, $posY, ($dir + 1) % 4];
        }

        if ($dir == self::DIR_UP) {
            $posX = $posX - 1;
        } elseif ($dir == self::DIR_DOWN) {
            $posX = $posX + 1;
        } elseif ($dir == self::DIR_LEFT) {
            $posY = $posY - 1;
        } elseif ($dir == self::DIR_RIGHT) {
            $posY = $posY + 1;
        }

        return [$posX, $posY, $dir];
    }

    public function solveB(): void
    {
        echo (new \Datetime())->format("Y-m-d H:i:s") . "\n";
        $data = $this->getData();

        $counter = 0;
        foreach ($data as $row => $line) {
            echo "CHECKING ROW $row\n";
            foreach ($line as $col => $char) {
                if ($this->checkPlacedObstacleCausesLoop($row, $col, $data)) {
                    $counter++;
                }
            }
        }

        echo (new \Datetime())->format("Y-m-d H:i:s") . "\n";
        echo $counter;
    }

    private function checkPlacedObstacleCausesLoop(int $x, int $y, array $data): bool
    {
        if ($data[$x][$y] != '.') {
            return false;
        }

        $data[$x][$y] = '#';

        list($posX, $posY, $dir) = $this->getGuardPos($data);

        $visitedCoords = [];
        while (true) {
            // echo "STEP $posX, $posY, $dir |||";
            if (in_array([$posX, $posY, $dir], $visitedCoords)) {
                return true;
            } else {
                $visitedCoords[] = [$posX, $posY, $dir];
            }

            if ($this->guardIsExiting($posX, $posY, $dir, $data)) {
                // echo "EXITING |||\n";
                break;
            }

            list($posX, $posY, $dir) = $this->move($posX, $posY, $dir, $data);
            // echo "NEW COORD $posX, $posY, $dir\n";
        }

        return false;
    }
}