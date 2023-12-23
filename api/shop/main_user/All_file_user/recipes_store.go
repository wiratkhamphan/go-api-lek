package allfileuser

// recipeStore คือ interface ที่กำหนดวิธีการจัดการกับข้อมูลของ Recipe
type RecipeStore interface {
	Add(name string, recipe Recipe) error
	Get(name string) (Recipe, error)
	List() (map[string]Recipe, error)
	Update(name string, recipe Recipe) error
	Remove(name string) error
}
