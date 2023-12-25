package home

import (
	"net/http"

	"github.com/gin-gonic/gin"
)

// homePage คือ handler สำหรับ route หน้าแรก
func HomePage(c *gin.Context) {
	c.JSON(http.StatusOK, gin.H{"message": "Welcome to the home page"})
}
