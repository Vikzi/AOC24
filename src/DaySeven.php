<?php

class DaySeven
{
    private string $file = __DIR__ . '/../input/7.txt';

    public function solveA(): void
    {
        $data = $this->getData();

        $sumOfDescriptableNumbers = 0;
        foreach ($data as $line) {
            if ($this->numbersCanBeCombined($line['value'], $line['numbers'])) {
                $sumOfDescriptableNumbers += $line['value'];
            }
        }

        echo $sumOfDescriptableNumbers;
    }

    public function getData(): array
    {
        $lines = explode("\n", file_get_contents($this->file));

        $data = [];
        foreach ($lines as $line) {
            list($value, $numbers) = explode(": ", $line);

            $data[] = [
                'value' => intval($value),
                'numbers' => array_map('intval', explode(' ', $numbers))
            ];
        }

        return $data;
    }

    public function numbersCanBeCombined(int $value, array $numbers): bool
    {
        $maxOperatorNumber = bindec(str_pad("", count($numbers) - 1, '1'));
        $i = 0;
        while($i <= $maxOperatorNumber) {
            $operatorNumber = decbin($i);
            $operatorDescriptor = str_pad($operatorNumber, count($numbers) - 1, '0', STR_PAD_LEFT);

            $val = $operatorDescriptor[0] == '0' ? $numbers[0] + $numbers[1] : $numbers[0] * $numbers[1];
            for ($j = 1; $j < count($numbers) - 1; $j++) {
                if ($operatorDescriptor[$j] == '0') {
                    $val += $numbers[$j+1];
                } else {
                    $val *= $numbers[$j+1];
                }
            }

            if ($val == $value) {
                return true;
            }

            $i++;
        }

        return false;
    }

    public function solveB(): void
    {
        $data = $this->getData();

        $sum = 0;
        foreach ($data as $line) {
            if ($this->numbersCanBeCombinedWithConcat($line['value'], $line['numbers'])) {
                $sum += $line['value'];
            }
        }

        echo $sum;
    }

    private function numbersCanBeCombinedWithConcat(int $value, array $numbers): bool
    {
        return 
            $this->recursiveCombination($value, $numbers, 'add', $numbers[0]) ||
            $this->recursiveCombination($value, $numbers, 'mul', $numbers[0]) ||
            $this->recursiveCombination($value, $numbers, 'con', $numbers[0]);
    }

    private function recursiveCombination(int $value, array $numbers, string $operator, int $currentValue, int $index = 1): bool
    {
        if ($operator == 'add') {
            $currentValue = $currentValue + $numbers[$index];
        } elseif($operator == 'mul') {
            $currentValue = $currentValue * $numbers[$index];
        } elseif ($operator == 'con') {
            $currentValue = intval((string)$currentValue . (string)$numbers[$index]);
        }

        if ($currentValue > $value) {
            return false;
        }

        if ($index == count($numbers) - 1) {
            return $currentValue == $value;
        }

        return
            $this->recursiveCombination($value, $numbers, 'add', $currentValue, $index + 1) ||
            $this->recursiveCombination($value, $numbers, 'mul', $currentValue, $index + 1) ||
            $this->recursiveCombination($value, $numbers, 'con', $currentValue, $index + 1);
    }
}