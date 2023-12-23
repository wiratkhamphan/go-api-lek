package allfileuser

import (
	"database/sql"
	"net/http"

	"github.com/gin-gonic/gin"
	_ "github.com/go-sql-driver/mysql"
	database "github.com/wiratkhamphan/go-api-lek/database"
)

var db *sql.DB

type User struct {
	Username string `json:"username"`
	Password string `json:"password"`
}

func LoginHandler(c *gin.Context) {
	var user User
	if err := c.ShouldBindJSON(&user); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	// Perform login validation against the database
	if validateLogin(user.Username, user.Password) {
		c.JSON(http.StatusOK, gin.H{"success": true, "message": "Login successful"})
	} else {
		c.JSON(http.StatusUnauthorized, gin.H{"success": false, "message": "Invalid username or password"})
	}
}

func validateLogin(username, password string) bool {
	var err error
	db, err := database.DBConnection()
	if err != nil {
		panic(err.Error())
	}

	// ตรวจสอบ error ที่ได้จาก sql.Open
	if err != nil {
		panic(err.Error())
	}
	defer db.Close()

	var storedPassword string
	err = db.QueryRow("SELECT Password FROM recipe WHERE name = ?", username).Scan(&storedPassword)

	// ตรวจสอบ error ที่ได้จาก db.QueryRow
	if err != nil {
		return false
	}

	// Compare the stored password with the provided password
	return storedPassword == password
}
