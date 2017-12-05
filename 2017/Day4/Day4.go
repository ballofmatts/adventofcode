package Day4

import (
	"strings"
	"sort"
	"io/ioutil"
)

func Day4() {
	input, _ := ioutil.ReadFile("./Day4/input.txt")
	var passwords = string(input)

	var valid1, valid2 int

	for _, password := range strings.Split(passwords, "\n") {
		passwordMap := make(map[string]bool)
		anagrams := make(map[string]bool)
		hasAnagram := false
		for _, word := range strings.Fields(password) {
			passwordMap[word] = true
			s := strings.Split(word, "")
			sort.Strings(s)
			sortedWord := strings.Join(s, "")
			if anagrams[sortedWord] {
				hasAnagram = true
			}
			anagrams[sortedWord] = true
		}
		if len(strings.Fields(password)) == len(passwordMap) {
			valid1++
		}
		if !hasAnagram {
			valid2++
		}
	}

	println(valid1)
	println(valid2)

}
