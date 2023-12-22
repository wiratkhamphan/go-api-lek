package lek

import (
	"net/http"

	"github.com/gin-gonic/gin"
)

// Add เพิ่ม Recipe เข้าสู่ฐานข้อมูล
func (m *MySQLStore) Add(name string, recipe Recipe) error {
	_, err := m.db.Exec("INSERT INTO recipe (name, password) VALUES (?, ?)", name, recipe.Password)
	return err
}

// CreateRecipe คือ handler สำหรับเพิ่มสูตรอาหารใหม่
func (h *RecipesHandler) CreateRecipe(c *gin.Context) {
	// ดึง request body และแปลงเป็นโครงสร้าง Recipe
	var recipe Recipe
	if err := c.ShouldBindJSON(&recipe); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	// ตรวจสอบค่าว่าง
	if recipe.Name == "" || recipe.Password == "" {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Name and description cannot be empty"})
		return
	}

	// เพิ่มสูตรอาหารใหม่
	err := h.store.Add(recipe.Name, recipe)
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	// ส่งผลลัพธ์สำเร็จกลับ
	c.JSON(http.StatusOK, gin.H{"status": "success"})
}
