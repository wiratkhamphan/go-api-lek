package lek

import (
	"net/http"

	"github.com/gin-gonic/gin"
)

// Remove ลบ Recipe จากฐานข้อมูล
func (m *MySQLStore) Remove(name string) error {
	result, err := m.db.Exec("DELETE FROM recipe WHERE name = ?", name)
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

// DeleteRecipe คือ handler สำหรับลบสูตรอาหาร
func (h *RecipesHandler) DeleteRecipe(c *gin.Context) {
	// ดึงพารามิเตอร์ URL
	id := c.Param("id")

	// เรียกใช้ store เพื่อลบสูตรอาหาร
	err := h.store.Remove(id)
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
