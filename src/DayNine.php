<?php

class DayNine
{
    private string $file = __DIR__ . '/../input/9.txt';

    public function solveA(): void
    {
        $data = array_map('intval', str_split(file_get_contents($this->file)));

        $disk = [];
        $isFree = true;
        $id = 0;
        foreach ($data as $num) {
            for ($i = 0; $i < $num; $i++) {
                $disk[] = $isFree ? $id : '.';
            }

            if ($isFree) {
                $id++;
            }
            $isFree = !$isFree;
        }

        for ($i = count($disk) - 1; $i >= 0; $i--) {
            for ($j = 0; $j < count($disk); $j++) {
                if ($disk[$j] == '.') {
                    $disk[$j] = $disk[$i];
                    unset($disk[$i]);
                    continue 2;
                }
            }
        }

        $sum = 0;
        foreach ($disk as $index => $val) {
            $sum += $index * $val;
        }

        echo $sum;
    }

    public function solveB(): void
    {
        $data = array_map('intval', str_split(file_get_contents($this->file)));

        $disk = [];
        $isFile = true;
        $fileId = 0;
        foreach ($data as $num) {
            if ($isFile) {
                $disk[] = [
                    'type' => 'file',
                    'length' => $num,
                    'fileId' => $fileId
                ];
                $fileId++;
            } else {
                $disk[] = [
                    'type' => 'free',
                    'length' => $num
                ];
            }

            $isFile = !$isFile;
        }

        $actualDisk = $disk;
        for ($i = count($disk) - 1; $i >= 0; $i--) {
            if ($disk[$i]['type'] != 'file') {
                continue;
            }

            for ($j = 0; $j < count($actualDisk); $j++) {
                if ($actualDisk[$j]['type'] != 'free') {
                    continue;
                }

                if ($actualDisk[$j]['length'] >= $disk[$i]['length']) {
                    array_splice(
                        $actualDisk,
                        $j,
                        0,
                        [['type' => 'file', 'length' => $disk[$i]['length'], 'fileId' => $disk[$i]['fileId']]]
                    );
                    
                    if ($actualDisk[$j + 1]['length'] != $disk[$i]['length']) {
                        $actualDisk[$j + 1]['length'] -= $disk[$i]['length'];
                    } else {
                        unset($actualDisk[$j + 1]);
                        $actualDisk = array_values($actualDisk);
                    }

                    for ($k = count($actualDisk) - 1; $k >= 0; $k--) {
                        if ($actualDisk[$k]['type'] != 'file') {
                            continue;
                        }

                        if ($actualDisk[$k]['fileId'] == $disk[$i]['fileId']) {
                            $actualDisk[$k]['type'] = 'free';
                            unset($actualDisk[$k]['fileId']);
                            break;
                        }
                    }

                    continue 2;
                }
            }
        }

        $sum = 0;
        foreach ($this->renderDisk($actualDisk) as $index => $val) {
            if ($val == '.') {
                continue;
            }
            $sum += $index * $val;
        }

        echo $sum;
    }

    private function renderDisk(array $disk): array
    {
        $ret = [];
        foreach ($disk as $el) {
            for ($i = 0; $i < $el['length']; $i++) {
                $ret[] = $el['type'] == 'file' ? $el['fileId'] : '.';
            }
        }

        return $ret;
    }
}