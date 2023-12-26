package login

import (
	"github.com/gin-gonic/gin"
	login "github.com/wiratkhamphan/go-api-lek/api/shop/login/loginshop"
	register "github.com/wiratkhamphan/go-api-lek/api/shop/login/registershop"
)

func RegisterRoutes(router *gin.Engine) {
	router.POST("/login", login.LoginHandler)
	router.POST("/register", register.RegisterHandler)
}
