<?php

class DayFive
{
    private string $file = __DIR__ . '/../input/5.txt';

    public function solveA(): void
    {
        $data = $this->getData();

        $sumOfMiddleNumbers = 0;
        foreach ($data['updates'] as $update) {
            if ($this->checkUpdate($update, $data['rules'])) {
                $sumOfMiddleNumbers += $update[(count($update) - 1) / 2];
            }
        }

        echo $sumOfMiddleNumbers;
    }

    private function getData(): array
    {
        $parts = explode("\n\n", file_get_contents($this->file));
        
        $ruleLines = explode("\n", $parts[0]);

        $data = [
            'rules' => [],
            'updates' => []
        ];
        foreach ($ruleLines as $ruleLine) {
            $data['rules'][] = array_map('intval', explode('|', $ruleLine));
        }

        $updateLines = explode("\n", $parts[1]);

        foreach ($updateLines as $updateLine) {
            $data['updates'][] = array_map('intval', explode(',', $updateLine));
        }

        return $data;
    }

    private function checkUpdate(array $update, array $rules): bool
    {
        foreach ($rules as $rule) {
            if (!in_array($rule[0], $update) || !in_array($rule[1], $update)) {
                continue;
            }

            if (array_search($rule[0], $update) > array_search($rule[1], $update)) {
                return false;
            }
        }

        return true;
    }

    public function solveB(): void
    {
        $data = $this->getData();

        $sumOfMiddleNumbers = 0;
        foreach ($data['updates'] as $update) {
            if (!$this->checkUpdate($update, $data['rules'])) {
                $fixedUpdate = $this->fixUpdate($update, $data['rules']);
                $sumOfMiddleNumbers += $fixedUpdate[(count($update) - 1) / 2];
            }
        }

        echo $sumOfMiddleNumbers;
    }

    private function fixUpdate(array $update, array $rules): array
    {
        $appliedRules = [];
        foreach ($rules as $rule) {
            if (!in_array($rule[0], $update) || !in_array($rule[1], $update)) {
                continue;
            }

            $appliedRules[] = $rule;
        }

        $fixedUpdate = [];
        foreach ($update as $val) {
            $index = 0;
            foreach ($appliedRules as $rule) {
                if ($rule[1] == $val) {
                    $index++;
                }
            }
            $fixedUpdate[$index] = $val;
        }

        return $fixedUpdate;
    }
}