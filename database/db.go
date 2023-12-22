// database/database.go
package database

import (
	"database/sql"

	_ "github.com/go-sql-driver/mysql"
)

// DBType is a placeholder type for the database connection.
type MySQLStore struct {
	db *sql.DB
}

// DBConnection initializes and returns a database connection.
func DBConnection() (*sql.DB, error) {
	dbDriver := "mysql"
	dbUser := "root"
	dbPass := ""
	dbName := "web_lek"
	db, err := sql.Open(dbDriver, dbUser+":"+dbPass+"@/"+dbName)

	if err != nil {
		return nil, err
	}

	// Ensure the database connection is valid
	err = db.Ping()
	if err != nil {
		return nil, err
	}
	return db, nil
}
