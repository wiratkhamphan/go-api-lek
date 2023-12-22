package lek

import "database/sql"

type MySQLStore struct {
	db *sql.DB
}

func NewMySQLStore(db *sql.DB) RecipeStore {
	return &MySQLStore{db: db}
}
