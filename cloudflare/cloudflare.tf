terraform {
  required_providers {
    cloudflare = {
      source  = "cloudflare/cloudflare"
      version = "~> 4"
    }

    external = {
      source  = "hashicorp/external"
      version = "~> 1.2"
    }
  }
}

data "external" "vault" {
  program = [
    "ansible-vault",
    "decrypt",
    "--output",
    "-",
    "vault.json"
  ]
}

provider "cloudflare" {
  api_token = data.external.vault.result.api_token
}

resource "cloudflare_record" "dns_wildcard" {
  content = "joaocosta.dev"
  name    = "*"
  proxied = true
  ttl     = 1
  type    = "CNAME"
  zone_id = data.external.vault.result.zone_id
}

resource "cloudflare_ruleset" "zone_level_managed_waf" {
  zone_id     = data.external.vault.result.zone_id
  name        = "Phase entry point ruleset for custom rules in my zone"
  description = ""
  kind        = "zone"
  phase       = "http_request_firewall_custom"

  rules {
    ref    = "allow_rss_bot_access"
    action = "skip"
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
  zone_id = data.external.vault.result.zone_id
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

