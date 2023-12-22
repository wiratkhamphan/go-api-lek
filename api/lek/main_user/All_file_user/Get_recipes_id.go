package lek

import (
	"net/http"

	"github.com/gin-gonic/gin"
)

// Get ดึงข้อมูล Recipe จากฐานข้อมูล
func (m *MySQLStore) Get(id string) (Recipe, error) {
	var recipe Recipe
	err := m.db.QueryRow("SELECT name, description FROM recipe WHERE name = ?", id).Scan(&recipe.Name, &recipe.Description)
	if err != nil {
		return Recipe{}, ErrNotFound
	}
	return recipe, nil
}

// GetRecipe คือ handler สำหรับดึงข้อมูลสูตรอาหารจาก ID
func (h *RecipesHandler) GetRecipe(c *gin.Context) {
	// ดึงพารามิเตอร์ URL
	id := c.Param("id")

	// ดึงข้อมูลสูตรอาหารจาก store ด้วย ID
	recipe, err := h.store.Get(id)
	if err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": err.Error()})
		return
	}

	// ส่งข้อมูลสูตรอาหารกลับไป
	c.JSON(http.StatusOK, recipe)
}
