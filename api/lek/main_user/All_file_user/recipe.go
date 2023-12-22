package lek

// Recipe คือโครงสร้างที่แทนสูตรอาหาร
type Recipe struct {
	Name        string `json:"name"`
	Description string `json:"description"`
}
