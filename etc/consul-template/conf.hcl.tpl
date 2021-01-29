vault {
  address = "${VAULT_HTTP_ADDR}"

  ssl {
    enabled = false
    verify = false
  }
}

template {
  source = "/var/www/html/config/packages/doctrine.yaml.tpl"
  destination = "/var/www/html/config/packages/doctrine.yaml"
}

template {
  source = "/var/www/html/config/services.yaml.tpl"
  destination = "/var/www/html/config/services.yaml"
}
