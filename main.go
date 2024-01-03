package main

import (
	"fmt"
	"log"
	"net/http"
	"time"

	"github.com/gin-gonic/gin"
	main_shop "github.com/wiratkhamphan/go-api-lek/api"
)

func main() {
	router := gin.Default()

	// Call the Main_shop function directly without assigning the result
	main_shop.Main_shop(router)

	srv := http.Server{
		Handler:      router,
		Addr:         ":8080", // Replace with your desired port number
		WriteTimeout: 30 * time.Second,
		ReadTimeout:  30 * time.Second,
	}
	fmt.Println("server started on port:", srv.Addr)

	err := srv.ListenAndServe()
	log.Fatal(err)
}
