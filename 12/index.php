<?php

//--- Day 12: Hill Climbing Algorithm ---
//You try contacting the Elves using your handheld device, but the river you're following must be too low to get a decent signal.
//
//You ask the device for a heightmap of the surrounding area (your puzzle input). The heightmap shows the local area from above broken into a grid; the elevation of each square of the grid is given by a single lowercase letter, where a is the lowest elevation, b is the next-lowest, and so on up to the highest elevation, z.
//
//Also included on the heightmap are marks for your current position (S) and the location that should get the best signal (E). Your current position (S) has elevation a, and the location that should get the best signal (E) has elevation z.
//
//You'd like to reach E, but to save energy, you should do it in as few steps as possible. During each step, you can move exactly one square up, down, left, or right. To avoid needing to get out your climbing gear, the elevation of the destination square can be at most one higher than the elevation of your current square; that is, if your current elevation is m, you could step to elevation n, but not to elevation o. (This also means that the elevation of the destination square can be much lower than the elevation of your current square.)
//
//For example:
//
//    Sabqponm
//abcryxxl
//accszExk
//acctuvwj
//abdefghi
//Here, you start in the top-left corner; your goal is near the middle. You could start by moving down or right, but eventually you'll need to head toward the e at the bottom. From there, you can spiral around to the goal:
//
//v..v<<<<
//>v.vv<<^
//.>vv>E^^
//..v>>>^^
//..>>>>>^
//In the above diagram, the symbols indicate whether the path exits each square moving up (^), down (v), left (<), or right (>). The location that should get the best signal is still E, and . marks unvisited squares.
//
//This path reaches the goal in 31 steps, the fewest possible.
//
//What is the fewest steps required to move from your current position to the location that should get the best signal?

$rows = explode("\r\n", file_get_contents("./input.txt"));

$grid = [];
$start = [0,0];
$end = [0, 0];
$heightMap = array_flip(range('a', 'z'));
foreach ($rows as $index => $row) {
    $cells = str_split($row);
    $grid[$index] = [];
    foreach ($cells as $cell) {
        if ($cell === 'S') {
            $start = [$index, count($grid[$index])];
            $cell = 'a';
        }
        if ($cell === 'E') {
            $end = [$index, count($grid[$index])];
            $cell = 'z';
        }
        $grid[$index][] = $heightMap[$cell];
    }
}
// Put grid in a constant to make it available for helper functions
define("GRID", $grid);

$potentialPaths = [[$start]];
$shortestPath = INF;
while (count($potentialPaths) > 0) {
    $potentialPaths = array_filter($potentialPaths, fn ($path) => count($path) < $shortestPath);
    $currentPath = array_pop($potentialPaths);

    while (true) {
        $lastStep = end($currentPath);
        if ($lastStep === $end) {
            if ($shortestPath > count($currentPath)) {
                $shortestPath = count($currentPath);
                var_dump($shortestPath);
            }
            break;
        }

        $possibleSteps = getNextSteps($lastStep, $currentPath);
        shuffle($possibleSteps);
        $nextStep = array_pop($possibleSteps);
        foreach ($possibleSteps as $possibleStep) {
            $potentialPaths[] = [...$currentPath, $possibleStep];
        }

        if ($nextStep === null || count($currentPath) > $shortestPath) {
            break;
        } else {
            $currentPath[] = $nextStep;
            renderScreen($currentPath);
        }

//        var_dump($currentPath, $potentialPaths);
    }
}
var_dump($shortestPath);
exit();

// This recursion doesn't work since it keeps creating new instances
// Every branching means the program steps into new function, which doesn't get resolved until all later branches get resolved
// In practice, this means that a slightly larger dataset will take gigabytes of memory to run the calculation
// It does work for tiny sets of data

//--- Incorrect approach ---
//$allPaths = [];
//define("END", $end);
//define("GRID", $grid);
//$allPaths[] = getPath([$start], $allPaths);
//$filtered = array_filter($allPaths, fn ($path) => explode('-', $path)[1] === '1');
//sort($filtered);
//var_dump(array_splice($filtered, 0, 5));
//exit();

//function getPath($partialPath, &$allPaths): string
//{
//    while (true) {
//        $lastStep = end($partialPath);
//        if ($lastStep === END) {
//            $count = count($partialPath);
//            return "$count-1";
//        }
//
//        $possibleSteps = getNextSteps($lastStep, $partialPath);
//        $nextStep = array_pop($possibleSteps);
//
//        foreach ($possibleSteps as $possibleStep) {
//            $allPaths[] = getPath([...$partialPath, $possibleStep], $allPaths);
//        }
//
//        if ($nextStep === null) {
//            $count = count($partialPath);
//            return "$count-0";
//        } else {
//            $partialPath[] = $nextStep;
//        }
//    }
//}

function getNextSteps($currentLocation, $partialPath): array {
    $allNextSteps = [
        [$currentLocation[0], $currentLocation[1] + 1],
        [$currentLocation[0] - 1, $currentLocation[1]],
        [$currentLocation[0] + 1, $currentLocation[1]],
        [$currentLocation[0], $currentLocation[1] - 1],
    ];
    return array_values(array_filter(
        $allNextSteps,
        fn ($step) => isset(GRID[$step[0]][$step[1]]) &&
        GRID[$step[0]][$step[1]] - GRID[$currentLocation[0]][$currentLocation[1]] < 2 &&
        !in_array($step, $partialPath)
    ));
}

function renderScreen($path): void
{
    foreach (GRID as $row) {
        $mappedRow = implode('.', array_map(fn ($item) => "\033[32mo\033[0m", $row));
        echo "$mappedRow\n";
    }
//    popen('cls', 'w');
    echo "\033[31m some colored text \033[0m some white text \n";
    exit();
}