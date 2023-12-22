package lek

import (
	"errors"

	_ "github.com/go-sql-driver/mysql"
)

var ErrNotFound = errors.New("not found")

// // RecipesHandler เป็น handler สำหรับตัวดำเนินการที่เกี่ยวกับ recipe
type RecipesHandler struct {
	store RecipeStore
}

// // NewRecipesHandler สร้าง instance ใหม่ของ RecipesHandler
func NewRecipesHandler(store RecipeStore) *RecipesHandler {
	return &RecipesHandler{store: store}
}
