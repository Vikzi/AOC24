<?php

class DayEight
{
    private string $file = __DIR__ . '/../input/8.txt';
    
    public function solveA(): void
    {
        $data = $this->getData();

        $antinodes = [];
        foreach ($data['antennas'] as $type => $antenna) {
            for ($i = 0; $i < count($antenna); $i++) {
                for ($j = 0; $j < count($antenna); $j++) {
                    if ($i == $j) {
                        continue;
                    }

                    $antinodeRow = $antenna[$i]['row'] + ($antenna[$i]['row'] - $antenna[$j]['row']);
                    $antinodeCol = $antenna[$i]['col'] + ($antenna[$i]['col'] - $antenna[$j]['col']);

                    if ($antinodeRow < 0 || $antinodeRow >= $data['size']['rows'] || $antinodeCol < 0 || $antinodeCol >= $data['size']['cols']) {
                        continue;
                    }

                    if (in_array([$antinodeRow, $antinodeCol], $antinodes)) {
                        continue;
                    }

                    $antinodes[] = [$antinodeRow, $antinodeCol];
                }
            }
        }

        echo count($antinodes);
    }

    private function getData():array
    {
        $lines = explode("\n", file_get_contents($this->file));

        $data = [
            'antennas' => [],
            'size' => [
                'rows' => count($lines),
                'cols' => strlen($lines[0])
            ]
        ];

        foreach ($lines as $row => $line) {
            $chars = str_split($line);

            foreach ($chars as $col => $char) {
                if ($char == '.') {
                    continue;
                }

                if (!isset($data['antennas'][$char])) {
                    $data['antennas'][$char] = [];
                }

                $data['antennas'][$char][] = ['row' => $row, 'col' => $col];
            }
        }

        return $data;
    }

    public function solveB(): void
    {
        $data = $this->getData();

        $numberOfAntennas = 0;
        $antinodes = [];
        foreach ($data['antennas'] as $type => $antenna) {
            $numberOfAntennas += count($antenna);
            for ($i = 0; $i < count($antenna); $i++) {
                for ($j = 0; $j < count($antenna); $j++) {
                    if ($i == $j) {
                        continue;
                    }

                    $rowDist = $antenna[$i]['row'] - $antenna[$j]['row'];
                    $colDist = $antenna[$i]['col'] - $antenna[$j]['col'];
                    $antinodeRow = $antenna[$i]['row'] + $rowDist;
                    $antinodeCol = $antenna[$i]['col'] + $colDist;

                    while ($antinodeRow >= 0 && $antinodeRow < $data['size']['rows'] && $antinodeCol >= 0 && $antinodeCol < $data['size']['cols']) {
                        if (in_array([$antinodeRow, $antinodeCol], $antinodes) || $this->isOccupied($antinodeRow, $antinodeCol, $data['antennas'])) {
                            $antinodeRow += $rowDist;
                            $antinodeCol += $colDist;
                            continue;
                        }
    
                        $antinodes[] = [$antinodeRow, $antinodeCol];
                        $antinodeRow += $rowDist;
                        $antinodeCol += $colDist;
                    }
                }
            }
        }

        echo count($antinodes) + $numberOfAntennas;
    }

    private function isOccupied(int $row, int $col, array $antennas): bool
    {
        foreach ($antennas as $antenna) {
            foreach ($antenna as $coords) {
                if ($coords['row'] == $row && $coords['col'] == $col) {
                    return true;
                }
            }
        }

        return false;
    }
}