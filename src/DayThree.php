<?php

class DayThree
{
    private string $file = __DIR__ . '/../input/3.txt';

    public function solveA(): void
    {
        $data = $this->getData();
        $matches = "";
        preg_match_all("/mul\([0-9]+,[0-9]+\)/i", $data, $matches);

        $sum = 0;
        foreach ($matches[0] as $match) {
            list($numA, $numB) = array_map('intval', explode(',', explode('(', substr($match, 0, strlen($match) - 1))[1]));
            
            $sum += $numA * $numB;
        }

        echo $sum;
    }

    private function getData(): string
    {
        return file_get_contents($this->file);
    }

    public function solveB(): void
    {
        $data = $this->getData();
        $matches = "";
        preg_match_all("/mul\([0-9]+,[0-9]+\)|do\(\)|don\'t\(\)/i", $data, $matches);

        $sum = 0;
        $switch = true;
        foreach ($matches[0] as $match) {
            if ($match == 'do()') {
                $switch = true;
            } elseif ($match == 'don\'t()') {
                $switch = false;
            } elseif ($switch) {
                list($numA, $numB) = array_map('intval', explode(',', explode('(', substr($match, 0, strlen($match) - 1))[1]));
            
                $sum += $numA * $numB;
            }
        }

        echo $sum;
    }
}