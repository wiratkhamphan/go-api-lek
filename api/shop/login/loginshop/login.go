package loginshop

import (
	"database/sql"
	"fmt"
	"net/http"

	"github.com/dgrijalva/jwt-go"
	"github.com/gin-gonic/gin"
	_ "github.com/go-sql-driver/mysql"
	database "github.com/wiratkhamphan/go-api-lek/database"
	"golang.org/x/crypto/bcrypt"
)

type User struct {
	Username string `json:"username" bindin:"required"`
	Password string `json:"password" bindin:"required"`
}

var hmacSampleSecret = []byte("my_secret_key")

func LoginHandler(c *gin.Context) {
	var user User

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

	// Check if the user with the given username exists
	userExists, err := userExists(db, user.Username)
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to check user existence"})
		return
	}

	if !userExists {
		c.JSON(http.StatusUnauthorized, gin.H{"success": false, "message": "User does not exist"})
		return
	}

	if validateLogin(db, user.Username, user.Password) {
		tokenString, err := generateJWT(user.Username)
		if err != nil {
			c.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to generate JWT"})
			return
		}
		c.JSON(http.StatusOK, gin.H{"success": true, "message": "Login successful", "token": tokenString})
	} else {
		c.JSON(http.StatusUnauthorized, gin.H{"success": false, "message": "Invalid username or password"})
	}
}

func validateLogin(db *sql.DB, username, password string) bool {
	var storedPassword string

	err := db.QueryRow("SELECT password FROM person WHERE username = ?", username).Scan(&storedPassword)
	if err != nil {
		return false
	}

	// Print out the stored password for debugging
	fmt.Println("Stored Password:", storedPassword)

	// Compare the stored hashed password with the provided password
	err = bcrypt.CompareHashAndPassword([]byte(storedPassword), []byte(password))

	// Print out the result of the comparison for debugging
	fmt.Println("Comparison Result:", err)

	return err == nil
}

func generateJWT(username string) (string, error) {
	token := jwt.NewWithClaims(jwt.SigningMethodHS256, jwt.MapClaims{
		"user": username,
	})

	tokenString, err := token.SignedString(hmacSampleSecret)
	if err != nil {
		return "", err
	}

	return tokenString, nil
}
func userExists(db *sql.DB, username string) (bool, error) {
	var count int

	err := db.QueryRow("SELECT COUNT(*) FROM person WHERE username = ?", username).Scan(&count)
	if err != nil {
		return false, err
	}

	return count > 0, nil
}
