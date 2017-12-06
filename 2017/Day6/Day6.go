package Day6

import (
	"strings"
	"io/ioutil"
	"strconv"
	"fmt"
)

func getMax(array []int) (int, int) {
	var max int = array[0]
	var index int = 0
	for i, value := range array {
		if max < value {
			max = value
			index = i
		}
	}
	return index, max
}

func generateKey(array []int) (string){
	return strings.Trim(strings.Replace(fmt.Sprint(array), " ", "", -1), "[]")
}

func Day6() {
	input, _ := ioutil.ReadFile("./Day6/input.txt")
	var instructions = string(input)

	//instructions = `0	2	7	0`
	var membanks []int

	for _, num := range strings.Split(instructions, "\t") {
		convNum, _ := strconv.Atoi(num)
		membanks = append(membanks, convNum)
	}

	visited := make(map[string]bool)
	visited[generateKey(membanks)] = true
	alreadySeen := false
	for {
		index, max := getMax(membanks)
		membanks[index] = 0
		for i:=1;i<=max;i++ {
			membanks[(index+i) % len(membanks)]++
		}

		if visited[generateKey(membanks)] {
			println(len(visited))
			visited = make(map[string]bool)

			if alreadySeen {
				break
			}
			alreadySeen = true
		}
		visited[generateKey(membanks)] = true
	}
}
