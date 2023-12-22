package mainuser

import (
	"errors"

	"github.com/gin-gonic/gin"
	lek "github.com/wiratkhamphan/go-api-lek/api/lek/main_user/All_file_user"
	database "github.com/wiratkhamphan/go-api-lek/database"
)

var ErrNotFound = errors.New("not found")

// // RecipesHandler เป็น handler สำหรับตัวดำเนินการที่เกี่ยวกับ recipe
type RecipesHandler struct {
	store lek.RecipeStore
}

// // NewRecipesHandler สร้าง instance ใหม่ของ RecipesHandler
func NewRecipesHandler(store lek.RecipeStore) *RecipesHandler {
	return &RecipesHandler{store: store}
}

func User_main() error {
	router := gin.Default()

	// Initialize the database connection
	db, err := database.DBConnection()
	if err != nil {
		panic(err)
	}
	defer db.Close()

	// Initialize the store and handler
	store := lek.NewMySQLStore(db)
	recipesHandler := lek.NewRecipesHandler(store)

	router.GET("/", HomePage)
	router.GET("/recipes", recipesHandler.ListRecipes)
	router.POST("/recipes", recipesHandler.CreateRecipe)
	router.GET("/recipes/:id", recipesHandler.GetRecipe)
	router.PUT("/recipes/:id", recipesHandler.UpdateRecipe)
	router.DELETE("/recipes/:id", recipesHandler.DeleteRecipe)

	router.Run(":8080")
	if err != nil {
		panic(err)
	}

	return nil
}
