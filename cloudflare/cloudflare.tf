terraform {

  cloud {
    organization = "ifg"
    hostname = "app.terraform.io"

    workspaces {
      name = "cloudflare"
      project = "ifgsv"
    }
  }

  required_providers {
    cloudflare = {
      source = "cloudflare/cloudflare"
      version = "~> 4"
    }
  }
}

variable "api_token" {}

variable "zone_id" {}

variable "account_id" {}

provider "cloudflare" {
  api_token = var.api_token
}

resource "cloudflare_record" "dns_wildcard" {
  content = "joaocosta.dev"
  name    = "*"
  proxied = true
  ttl     = 1
  type    = "CNAME"
  zone_id = var.zone_id
}

resource "cloudflare_ruleset" "zone_level_managed_waf" {
  zone_id     = var.zone_id
  name        = "Phase entry point ruleset for custom rules in my zone"
  description = ""
  kind        = "zone"
  phase       = "http_request_firewall_custom"

  rules {
    ref         = "allow_rss_bot_access"
    action      = "skip"
    action_parameters {
        phases = [
            "http_ratelimit",
            "http_request_firewall_managed",
            "http_request_sbfm"
        ]
        ruleset = "current"
    }
    description = "Allow bot access to /rss"
    expression  = "(http.request.full_uri eq \"https://joaocosta.dev/rss\")"
    logging {
        enabled = true
    }
  }
}

resource "cloudflare_ruleset" "terraform_rules" {
  zone_id = var.zone_id
  kind    = "zone"
  name    = "default"
  phase   = "http_request_dynamic_redirect"
  rules {
    action = "redirect"
    action_parameters {
      from_value {
        preserve_query_string = true
        status_code           = 301
        target_url {
          expression = "wildcard_replace(http.request.full_uri, r\"http://*\", r\"https://$${1}\")"
        }
      }
    }
    description = "HTTP to HTTPS"
    enabled     = true
    expression  = "(http.request.full_uri wildcard r\"http://*\")"
  }
  rules {
    action = "redirect"
    action_parameters {
      from_value {
        preserve_query_string = true
        status_code           = 301
        target_url {
          expression = "wildcard_replace(http.request.full_uri, r\"https://www.*\", r\"https://$${1}\")"
        }
      }
    }
    description = "Remove WWW"
    enabled     = true
    expression  = "(http.request.full_uri wildcard r\"https://www.*\")"
  }
}

resource "cloudflare_list" "root_redirects" {
  name        = "root"
  description = "Static redirects for tailscale services"
  kind        = "redirect"
  account_id = var.account_id

  item {
    value {
      redirect {
        source_url  = "wiki.joaocosta.dev"
        target_url  = "https://joaocostaifg.github.io/wiki"
        status_code = 301
      }
    }
    comment = "ai"
  }

  item {
    value {
      redirect {
        source_url  = "ai.joaocosta.dev"
        target_url  = "https://ai.tail1dfda.ts.net"
        status_code = 301
      }
    }
    comment = "ai"
  }

  item {
    value {
      redirect {
        source_url  = "dns.joaocosta.dev"
        target_url  = "https://dns.tail1dfda.ts.net"
        status_code = 301
      }
    }
    comment = "dns"
  }

  item {
    value {
      redirect {
        source_url  = "dozzle.joaocosta.dev"
        target_url  = "https://dozzle.tail1dfda.ts.net"
        status_code = 301
      }
    }
    comment = "dozzle"
  }

  item {
    value {
      redirect {
        source_url  = "files.joaocosta.dev"
        target_url  = "https://files.tail1dfda.ts.net"
        status_code = 301
      }
    }
    comment = "files"
  }

  item {
    value {
      redirect {
        source_url  = "immich.joaocosta.dev"
        target_url  = "https://immich.tail1dfda.ts.net"
        status_code = 301
      }
    }
    comment = "immich"
  }

  item {
    value {
      redirect {
        source_url  = "joplin.joaocosta.dev"
        target_url  = "https://joplin.tail1dfda.ts.net"
        status_code = 301
      }
    }
    comment = "joplin"
  }

  item {
    value {
      redirect {
        source_url  = "paperless.joaocosta.dev"
        target_url  = "https://paperless.tail1dfda.ts.net"
        status_code = 301
      }
    }
    comment = "paperless"
  }

  item {
    value {
      redirect {
        source_url  = "pdf.joaocosta.dev"
        target_url  = "https://pdf.tail1dfda.ts.net"
        status_code = 301
      }
    }
    comment = "pdf"
  }

  item {
    value {
      redirect {
        source_url  = "tail.joaocosta.dev"
        target_url  = "https://tail.tail1dfda.ts.net"
        status_code = 301
      }
    }
    comment = "tail"
  }

  item {
    value {
      redirect {
        source_url  = "vaultwarden.joaocosta.dev"
        target_url  = "https://vaultwarden.tail1dfda.ts.net"
        status_code = 301
      }
    }
    comment = "vaultwarden"
  }

  item {
    value {
      redirect {
        source_url  = "searxng.joaocosta.dev"
        target_url  = "https://searxng.tail1dfda.ts.net"
        status_code = 301
      }
    }
    comment = "searxng"
  }
}


