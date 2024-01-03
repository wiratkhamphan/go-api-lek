package shop

import (
	"log"

	"github.com/gin-gonic/gin"
	home "github.com/wiratkhamphan/go-api-lek/api/shop/home"
	login "github.com/wiratkhamphan/go-api-lek/api/shop/login"
	stock "github.com/wiratkhamphan/go-api-lek/api/shop/stock"

	database "github.com/wiratkhamphan/go-api-lek/database"
)

func Main_shop(router *gin.Engine) {

	// Connect to the database
	db, err := database.DBConnection()
	if err != nil {
		log.Fatalf("Error connecting to the database: %v", err)
	}
	defer db.Close()

	// Register routes from different modules
	home.RegisterRoutes(router)
	login.RegisterRoutes(router)
	stock.RegisterRoutes(router, db) // Pass the database connection to stock module

	// Start the server

}
