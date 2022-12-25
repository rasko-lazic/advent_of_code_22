<?php

//--- Day 17: Pyroclastic Flow ---
//Your handheld device has located an alternative exit from the cave for you and the elephants. The ground is rumbling almost continuously now, but the strange valves bought you some time. It's definitely getting warmer in here, though.
//
//The tunnels eventually open into a very tall, narrow chamber. Large, oddly-shaped rocks are falling into the chamber from above, presumably due to all the rumbling. If you can't work out where the rocks will fall next, you might be crushed!
//
//The five types of rocks have the following peculiar shapes, where # is rock and . is empty space:
//
//####
//
//.#.
//###
//.#.
//
//..#
//..#
//###
//
//#
//#
//#
//#
//
//##
//##
//The rocks fall in the order shown above: first the - shape, then the + shape, and so on. Once the end of the list is reached, the same order repeats: the - shape falls first, sixth, 11th, 16th, etc.
//
//The rocks don't spin, but they do get pushed around by jets of hot gas coming out of the walls themselves. A quick scan reveals the effect the jets of hot gas will have on the rocks as they fall (your puzzle input).
//
//For example, suppose this was the jet pattern in your cave:
//
//>>><<><>><<<>><>>><<<>>><<<><<<>><>><<>>
//In jet patterns, < means a push to the left, while > means a push to the right. The pattern above means that the jets will push a falling rock right, then right, then right, then left, then left, then right, and so on. If the end of the list is reached, it repeats.
//
//The tall, vertical chamber is exactly seven units wide. Each rock appears so that its left edge is two units away from the left wall and its bottom edge is three units above the highest rock in the room (or the floor, if there isn't one).
//
//After a rock appears, it alternates between being pushed by a jet of hot gas one unit (in the direction indicated by the next symbol in the jet pattern) and then falling one unit down. If any movement would cause any part of the rock to move into the walls, floor, or a stopped rock, the movement instead does not occur. If a downward movement would have caused a falling rock to move into the floor or an already-fallen rock, the falling rock stops where it is (having landed on something) and a new rock immediately begins falling.
//
//Drawing falling rocks with @ and stopped rocks with #, the jet pattern in the example above manifests as follows:
//
//The first rock begins falling:
//|..@@@@.|
//|.......|
//|.......|
//|.......|
//+-------+
//
//Jet of gas pushes rock right:
//|...@@@@|
//|.......|
//|.......|
//|.......|
//+-------+
//
//Rock falls 1 unit:
//|...@@@@|
//|.......|
//|.......|
//+-------+
//
//Jet of gas pushes rock right, but nothing happens:
//|...@@@@|
//|.......|
//|.......|
//+-------+
//
//Rock falls 1 unit:
//|...@@@@|
//|.......|
//+-------+
//
//Jet of gas pushes rock right, but nothing happens:
//|...@@@@|
//|.......|
//+-------+
//
//Rock falls 1 unit:
//|...@@@@|
//+-------+
//
//Jet of gas pushes rock left:
//|..@@@@.|
//+-------+
//
//Rock falls 1 unit, causing it to come to rest:
//|..####.|
//+-------+
//
//A new rock begins falling:
//|...@...|
//|..@@@..|
//|...@...|
//|.......|
//|.......|
//|.......|
//|..####.|
//+-------+
//
//Jet of gas pushes rock left:
//|..@....|
//|.@@@...|
//|..@....|
//|.......|
//|.......|
//|.......|
//|..####.|
//+-------+
//
//Rock falls 1 unit:
//|..@....|
//|.@@@...|
//|..@....|
//|.......|
//|.......|
//|..####.|
//+-------+
//
//Jet of gas pushes rock right:
//|...@...|
//|..@@@..|
//|...@...|
//|.......|
//|.......|
//|..####.|
//+-------+
//
//Rock falls 1 unit:
//|...@...|
//|..@@@..|
//|...@...|
//|.......|
//|..####.|
//+-------+
//
//Jet of gas pushes rock left:
//|..@....|
//|.@@@...|
//|..@....|
//|.......|
//|..####.|
//+-------+
//
//Rock falls 1 unit:
//|..@....|
//|.@@@...|
//|..@....|
//|..####.|
//+-------+
//
//Jet of gas pushes rock right:
//|...@...|
//|..@@@..|
//|...@...|
//|..####.|
//+-------+
//
//Rock falls 1 unit, causing it to come to rest:
//|...#...|
//|..###..|
//|...#...|
//|..####.|
//+-------+
//
//A new rock begins falling:
//|....@..|
//|....@..|
//|..@@@..|
//|.......|
//|.......|
//|.......|
//|...#...|
//|..###..|
//|...#...|
//|..####.|
//+-------+
//The moment each of the next few rocks begins falling, you would see this:
//
//|..@....|
//|..@....|
//|..@....|
//|..@....|
//|.......|
//|.......|
//|.......|
//|..#....|
//|..#....|
//|####...|
//|..###..|
//|...#...|
//|..####.|
//+-------+
//
//|..@@...|
//|..@@...|
//|.......|
//|.......|
//|.......|
//|....#..|
//|..#.#..|
//|..#.#..|
//|#####..|
//|..###..|
//|...#...|
//|..####.|
//+-------+
//
//|..@@@@.|
//|.......|
//|.......|
//|.......|
//|....##.|
//|....##.|
//|....#..|
//|..#.#..|
//|..#.#..|
//|#####..|
//|..###..|
//|...#...|
//|..####.|
//+-------+
//
//|...@...|
//|..@@@..|
//|...@...|
//|.......|
//|.......|
//|.......|
//|.####..|
//|....##.|
//|....##.|
//|....#..|
//|..#.#..|
//|..#.#..|
//|#####..|
//|..###..|
//|...#...|
//|..####.|
//+-------+
//
//|....@..|
//|....@..|
//|..@@@..|
//|.......|
//|.......|
//|.......|
//|..#....|
//|.###...|
//|..#....|
//|.####..|
//|....##.|
//|....##.|
//|....#..|
//|..#.#..|
//|..#.#..|
//|#####..|
//|..###..|
//|...#...|
//|..####.|
//+-------+
//
//|..@....|
//|..@....|
//|..@....|
//|..@....|
//|.......|
//|.......|
//|.......|
//|.....#.|
//|.....#.|
//|..####.|
//|.###...|
//|..#....|
//|.####..|
//|....##.|
//|....##.|
//|....#..|
//|..#.#..|
//|..#.#..|
//|#####..|
//|..###..|
//|...#...|
//|..####.|
//+-------+
//
//|..@@...|
//|..@@...|
//|.......|
//|.......|
//|.......|
//|....#..|
//|....#..|
//|....##.|
//|....##.|
//|..####.|
//|.###...|
//|..#....|
//|.####..|
//|....##.|
//|....##.|
//|....#..|
//|..#.#..|
//|..#.#..|
//|#####..|
//|..###..|
//|...#...|
//|..####.|
//+-------+
//
//|..@@@@.|
//|.......|
//|.......|
//|.......|
//|....#..|
//|....#..|
//|....##.|
//|##..##.|
//|######.|
//|.###...|
//|..#....|
//|.####..|
//|....##.|
//|....##.|
//|....#..|
//|..#.#..|
//|..#.#..|
//|#####..|
//|..###..|
//|...#...|
//|..####.|
//+-------+
//To prove to the elephants your simulation is accurate, they want to know how tall the tower will get after 2022 rocks have stopped (but before the 2023rd rock begins falling). In this example, the tower of rocks will be 3068 units tall.
//
//How many units tall will the tower of rocks be after 2022 rocks have stopped falling?

//--- Part Two ---
//The elephants are not impressed by your simulation. They demand to know how tall the tower will be after 1000000000000 rocks have stopped! Only then will they feel confident enough to proceed through the cave.
//
//In the example above, the tower would be 1514285714288 units tall!
//
//How tall will the tower be after 1000000000000 rocks have stopped?

const SIMULATION_END = 2022;
const BIG_SIMULATION_END = 1000000000000;

$movements = array_map(fn($item) => $item === '>' ? 1 : -1, str_split(file_get_contents("./input.txt")));
//$movements = array_map(fn($item) => $item === '>' ? 1 : -1, str_split(">>><<><>><<<>><>>><<<>>><<<><<<>><>><<>>"));
$rockShapes = [
    fn($y) => [[$y + 4, 3], [$y + 4, 4], [$y + 4, 5], [$y + 4, 6]],
    fn($y) => [[$y + 6, 4], [$y + 5, 3], [$y + 5, 4], [$y + 5, 5], [$y + 4, 4]],
    fn($y) => [[$y + 6, 5], [$y + 5, 5], [$y + 4, 3], [$y + 4, 4], [$y + 4, 5]],
    fn($y) => [[$y + 7, 3], [$y + 6, 3], [$y + 5, 3], [$y + 4, 3]],
    fn($y) => [[$y + 5, 3], [$y + 5, 4], [$y + 4, 3], [$y + 4, 4]],
];

$totalMovements = count($movements);
$layout = [
    '0-1' => [0, 1],
    '0-2' => [0, 2],
    '0-3' => [0, 3],
    '0-4' => [0, 4],
    '0-5' => [0, 5],
    '0-6' => [0, 6],
    '0-7' => [0, 7],
];
$rock = null;
$maxHeight = $rockCounter = $cycles = 0;
while (true) {
    $windDirection = $movements[$cycles % $totalMovements];
    $cycles++;

    // Every loop the height increases by 2752
    if ($cycles === count($movements) * 2 + 5854) {
        echo "second ";
        var_dump([$maxHeight, $rockCounter]);
    }
    if ($cycles === count($movements) * 3 + 5854) {
        echo "third ";
        var_dump([$maxHeight, $rockCounter]);
    }
    if (in_array($cycles, [count($movements), count($movements) * 2, count($movements) * 3, count($movements) * 4, count($movements) * 5, count($movements) * 6, count($movements) * 7])) {
        var_dump([$maxHeight, $rockCounter]);
    }


    if ($rockCounter === SIMULATION_END) {
        echo "The height of the rock tower is $maxHeight\n\n";
        break;
    }
    if ($rock === null) {
        $rock = $rockShapes[$rockCounter % 5]($maxHeight);
    }

//    renderScreen($layout, $rock, $maxHeight);
//    usleep(500000);

    // Wind is blowing
    $canGoLeft = min(array_column($rock, 1)) > 1;
    $canGoRight = max(array_column($rock, 1)) < 7;
    if ($windDirection === -1 && $canGoLeft || $windDirection === 1 && $canGoRight) {
        $rock = array_map(fn($item) => [$item[0], $item[1] + $windDirection], $rock);
        if (count(array_filter($rock, fn ($item) => isset($layout[implode('-', $item)]))) > 0) {
            $rock = array_map(fn($item) => [$item[0], $item[1] - $windDirection], $rock);
        }
    }
    // And we are falling
    $rock = array_map(fn($item) => [$item[0] - 1, $item[1]], $rock);
    // Until we can't
    if (count(array_filter($rock, fn ($item) => isset($layout[implode('-', $item)]))) > 0) {
        $rock = array_map(fn($item) => [$item[0] + 1, $item[1]], $rock);
        $layout = array_merge($layout, array_combine(array_map(fn ($item) => implode('-', $item), $rock), $rock));
        $maxHeight = max([...array_column($rock, 0), $maxHeight]);
        $rock = null;
        $rockCounter++;
    }
}

//--- Part Two ---
// For each full movement loop, max height increases by 2752, while rock count increases by 1745
// When rock count increases by 1008, max height jumps by 1594
$remainingCycles = BIG_SIMULATION_END % 1745; // 1010
$loopCycles = floor(BIG_SIMULATION_END / 1745); // 573065902
$total = 2773 + 2752 * 573065901 + 1590;
// 272718263789 is too low
// 1577077363919 is too high
echo "Total height of rock tower after 1000000000000 is $total";

function renderScreen($layout, $rock, $maxHeight): void
{
    $screen = '';
    popen('cls', 'w');
    $maxHeight = $maxHeight + 6;
    for ($i = $maxHeight; $i > $maxHeight - 20; $i--) {
        $screen .= PHP_EOL;
        for ($j = 0; $j < 9; $j++) {
            if ($i === 0) {
                echo "$screen+-------+";
            } else {
                if ($j === 0 || $j === 8) {
                    $screen .= '|';
                    continue;
                }
                if (in_array([$i, $j], [...$layout, ...$rock])) {
                    $screen .= '#';
                } else {
                    $screen .= '.';
                }
            }
        }
    }
}