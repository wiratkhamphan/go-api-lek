package main

import (
	"log"

	main_shop "github.com/wiratkhamphan/go-api-lek/api/shop"
)

func main() {
	err := main_shop.User_main()
	if err != nil {
		log.Fatalf("Error starting the server: %v", err)
	}
}
