package lek

import (
	"net/http"

	"github.com/gin-gonic/gin"
)

// List ดึงรายการ Recipe ทั้งหมดจากฐานข้อมูล
func (m *MySQLStore) List() (map[string]Recipe, error) {
	rows, err := m.db.Query("SELECT name, description FROM recipe")
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	recipes := make(map[string]Recipe)
	for rows.Next() {
		var recipe Recipe
		err := rows.Scan(&recipe.Name, &recipe.Description)
		if err != nil {
			return nil, err
		}
		recipes[recipe.Name] = recipe
	}

	return recipes, nil
}

// ListRecipes คือ handler สำหรับดึงรายการสูตรอาหารทั้งหมด
func (h *RecipesHandler) ListRecipes(c *gin.Context) {
	// เรียกใช้ store เพื่อดึงรายการสูตรอาหาร
	recipes, err := h.store.List()
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	// ส่งรายการสูตรอาหารกลับไป
	c.JSON(http.StatusOK, recipes)
}
