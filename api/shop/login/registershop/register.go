package registershop

import (
	"database/sql"
	"net/http"

	"github.com/gin-gonic/gin"
	_ "github.com/go-sql-driver/mysql"
	database "github.com/wiratkhamphan/go-api-lek/database"
)

type UserRegistration struct {
	Name     string `json:"name"`
	Surname  string `json:"surname"`
	Username string `json:"username"`
	Password string `json:"password"`
	ISOPCode string `json:"iso_p_code"`
}

func RegisterHandler(c *gin.Context) {
	var user UserRegistration

	if err := c.ShouldBindJSON(&user); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	// Example: Use the db variable
	db, err := database.DBConnection()
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to connect to the database"})
		return
	}
	defer db.Close()

	// Perform registration by inserting a new user into the database
	if err := insertUser(db, user); err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to register the user"})
		return
	}

	c.JSON(http.StatusCreated, gin.H{"success": true, "message": "Registration successful"})
}

func insertUser(db *sql.DB, user UserRegistration) error {
	// Insert a new user into the 'person' table
	_, err := db.Exec("INSERT INTO person (name, surname, username, password, iso_p_code) VALUES (?, ?, ?, ?, ?)",
		user.Name, user.Surname, user.Username, user.Password, user.ISOPCode)

	if err != nil {
		return err
	}

	return nil
}
