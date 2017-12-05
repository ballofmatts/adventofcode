package Day3

import (
	"math"
	"strconv"
)

func Day3pt1() {
	var puzzleInput = 312051

	for i := 1; i < puzzleInput; i = i + 2 {
		threshold := int(math.Pow(float64(i), 2.0))
		if puzzleInput-threshold <= 0 {
			println(threshold)
			x := i / 2
			y := i / 2
			squareSize := i
			counter := 1
			dir := 3
			currentNum := threshold
			for currentNum > puzzleInput {
				counter++
				currentNum--
				switch dir {
				case 0:
					y++
				case 1:
					x++
				case 2:
					y--
				case 3:
					x--
				}
				if counter == squareSize {
					dir--
					counter = 1
					if dir < 0 {
						dir = 3
						squareSize--
					}
				}
			}
			println(x)
			println(y)
			println(int(math.Abs(float64(x)) + math.Abs(float64(y))))

			break
		}
	}

}

func Day3pt2() {
	var puzzleInput = 312051

	x, y := 0, 0
	spiral := make(map[string]int)
	spiral["0,0"] = 1
	dir := 1
	squareSize := 1
	counter := 0

	for i := 0; ; i++ {
		counter++
		switch dir {
		case 0:
			y++
		case 1:
			x++
		case 2:
			y--
		case 3:
			x--
		}
		if counter == squareSize {
			dir++
			counter = 0
			if dir > 3 {
				dir = 0
			}
			if dir == 1 || dir == 3 {
				squareSize++
			}
		}
		var sum int

		for j := x - 1; j <= x+1; j++ {
			for k := y - 1; k <= y+1; k++ {
				sum += spiral[strconv.Itoa(j)+","+strconv.Itoa(k)]
			}
		}
		spiral[strconv.Itoa(x)+","+strconv.Itoa(y)] = sum
		if sum == puzzleInput {
			println("puzzle input at:")
			println(strconv.Itoa(x)+","+strconv.Itoa(y))
		}
		if sum > puzzleInput {
			println("next number:")
			println(sum)
			break
		}
	}

}
