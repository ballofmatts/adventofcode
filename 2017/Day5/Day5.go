package Day5

import (
	"strings"
	"strconv"
	"io/ioutil"
)

func Day5() {
	input, _ := ioutil.ReadFile("./Day5/input.txt")
	var instructions = string(input)

	//lots of hullabaloo converting the input "strings" over to ints
	splitInstructions := strings.Split(instructions, "\n")
	var intInstructions []int
	for _, inst := range splitInstructions {
		intInst, _ := strconv.Atoi(strings.TrimSpace(inst))
		intInstructions = append(intInstructions, intInst)
	}
	///

	//p1
	currentPointer := 0
	counterP1, counterP2 := 0, 0

	p1Instructions := make([]int, len(intInstructions))
	copy(p1Instructions, intInstructions)

	for currentPointer < len(p1Instructions) && currentPointer >= 0 {
		counterP1++
		oldI := currentPointer
		currentPointer += p1Instructions[currentPointer]
		p1Instructions[oldI]++
	}
	///

	//p2
	currentPointer = 0
	p2Instructions := make([]int, len(intInstructions))
	copy(p2Instructions, intInstructions)

	for currentPointer < len(p2Instructions) && currentPointer >= 0 {
		counterP2++
		oldI := currentPointer
		currentPointer += p2Instructions[currentPointer]
		if p2Instructions[oldI] >= 3 {
			p2Instructions[oldI]--
		} else {
			p2Instructions[oldI]++
		}
	}
	///
	println(counterP1)
	println(counterP2)

}
