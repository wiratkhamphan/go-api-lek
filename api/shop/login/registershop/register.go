package registershop

import (
	"database/sql"
	"net/http"

	"github.com/gin-gonic/gin"
	_ "github.com/go-sql-driver/mysql"
	database "github.com/wiratkhamphan/go-api-lek/database"
	"golang.org/x/crypto/bcrypt"
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
	encryperdPassword, err := insertUser(db, user)
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to register the user"})
		return
	}

	// Send the encrypted password to the user (for demonstration purposes)
	c.JSON(http.StatusCreated, gin.H{
		"success":            true,
		"message":            "Registration successful",
		"encrypted_password": encryperdPassword,
	})
}

func insertUser(db *sql.DB, user UserRegistration) (string, error) {
	// Insert a new user into the 'person' table
	encryperdPassword, err := bcrypt.GenerateFromPassword([]byte(user.Password), 10)
	if err != nil {
		return "", err
	}

	_, err = db.Exec("INSERT INTO person (name, surname, username, password, iso_p_code) VALUES (?, ?, ?, ?, ?)",
		user.Name, user.Surname, user.Username, encryperdPassword, user.ISOPCode)

	if err != nil {
		return "", err
	}

	return string(encryperdPassword), nil
}
