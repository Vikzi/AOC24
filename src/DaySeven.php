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
        echo "CALCULATING " . $value . "\n";
        $maxOperatorNumber = bindec(str_pad("", count($numbers) - 1, '1'));
        echo "MAX OPERATOR NUMBER " . $maxOperatorNumber . "\n";
        $i = 0;
        while($i <= $maxOperatorNumber) {
            $operatorNumber = decbin($i);
            $operatorDescriptor = str_pad($operatorNumber, count($numbers) - 1, '0', STR_PAD_LEFT);
            echo "LINE " . $value . "\n";
            echo "DESCRIPTOR " . $i . "\n";

            $val = $operatorDescriptor[0] == '0' ? $numbers[0] + $numbers[1] : $numbers[0] * $numbers[1];
            for ($j = 1; $j < count($numbers) - 1; $j++) {
                if ($operatorDescriptor[$j] == '0') {
                    $val += $numbers[$j+1];
                } else {
                    $val *= $numbers[$j+1];
                }
            }

            echo "VALUE " . $val . "\n";

            if ($val == $value) {
                return true;
            }

            $i++;
        }

        return false;
    }

    public function solveB(): void
    {

    }
}