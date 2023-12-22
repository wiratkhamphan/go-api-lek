package main

import (
	"log"

	mainuser "github.com/wiratkhamphan/go-api-lek/api/lek/main_user"
)

func main() {
	err := mainuser.User_main()
	if err != nil {
		log.Fatalf("Error starting the server: %v", err)
	}
}
