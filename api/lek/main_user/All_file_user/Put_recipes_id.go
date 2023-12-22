package lek

import (
	"net/http"

	"github.com/gin-gonic/gin"
)

// Update อัพเดตข้อมูล Recipe ในฐานข้อมูล
func (m *MySQLStore) Update(name string, recipe Recipe) error {
	result, err := m.db.Exec("UPDATE recipe SET description = ? WHERE name = ?", recipe.Description, name)
	if err != nil {
		return err
	}

	rowsAffected, err := result.RowsAffected()
	if err != nil {
		return err
	}

	if rowsAffected == 0 {
		return ErrNotFound
	}

	return nil
}

// UpdateRecipe คือ handler สำหรับอัปเดตข้อมูลสูตรอาหาร
func (h *RecipesHandler) UpdateRecipe(c *gin.Context) {
	// ดึงพารามิเตอร์ URL
	id := c.Param("id")

	// ดึง request body และแปลงเป็นโครงสร้าง Recipe
	var recipe Recipe
	if err := c.ShouldBindJSON(&recipe); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	// เรียกใช้ store เพื่ออัปเดตสูตรอาหาร
	err := h.store.Update(id, recipe)
	if err != nil {
		if err == ErrNotFound {
			c.JSON(http.StatusNotFound, gin.H{"error": err.Error()})
			return
		}
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	// ส่งผลลัพธ์สำเร็จกลับ
	c.JSON(http.StatusOK, gin.H{"status": "success"})
}
