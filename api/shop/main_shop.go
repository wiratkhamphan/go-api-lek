package mainuser

import (
	"errors"

	"github.com/gin-gonic/gin"
	home "github.com/wiratkhamphan/go-api-lek/api/shop/home"
	shop "github.com/wiratkhamphan/go-api-lek/api/shop/main_user/All_file_user"
	login "github.com/wiratkhamphan/go-api-lek/api/shop/main_user/login"
	database "github.com/wiratkhamphan/go-api-lek/database"
)

var ErrNotFound = errors.New("not found")

// // RecipesHandler เป็น handler สำหรับตัวดำเนินการที่เกี่ยวกับ recipe
type RecipesHandler struct {
	store shop.RecipeStore
}

// // NewRecipesHandler สร้าง instance ใหม่ของ RecipesHandler
func NewRecipesHandler(store shop.RecipeStore) *RecipesHandler {
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
	store := shop.NewMySQLStore(db)
	recipesHandler := shop.NewRecipesHandler(store)

	router.GET("/", home.HomePage)
	router.GET("/recipes", recipesHandler.ListRecipes)
	router.POST("/recipes", recipesHandler.CreateRecipe)
	router.GET("/recipes/:id", recipesHandler.GetRecipe)
	router.PUT("/recipes/:id", recipesHandler.UpdateRecipe)
	router.DELETE("/recipes/:id", recipesHandler.DeleteRecipe)
	router.POST("/login", login.LoginHandler)

	router.Run(":8080")
	if err != nil {
		panic(err)
	}

	return nil
}
