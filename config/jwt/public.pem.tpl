{{ with secret "secret/jwt" }}{{ .Data.public }}{{end}}
