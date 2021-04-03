<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php if ($title) echo $title . ' | '; ?>JoaoCostaIFG</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css" />
    <link rel="shortcut icon" type="image/png" href="/favicon.png" />
    <link
      rel="alternate"
      type="application/rss+xml"
      title="JoaoCostaIFG"
      href="https://joaocosta.dev/atom.xml"
    />
    <meta
      name="description"
      content="The personal website/blog of JoaoCostaIFG. He tries to be active there."
    />
    <meta charset="utf-8" />
  </head>

  <body>
    <header>
      <h1><a href="/">JoaoCostaIFG (https://joaocosta.dev)</a></h1>

      <ul id="menu">
        <li><a href="/pages/about.php">About me</a></li>
        <li><a href="/pages/blog/">Blog Index</a></li>
        <li><a href="/pages/contacts.php">Contacts</a></li>
        <li>
          <a href="/pages/projects.php">Projects</a>
          <ul class="menuDropdown">
            <li><a href="/pages/projects.php">Projects</a></li>
            <li><a href="/pages/workshops/">Workshops</a></li>
            <li><a href="https://wiki.joaocosta.dev">Wiki</a></li>
          </ul>
        </li>
        <li>
          <a href="https://gitlab.com/JoaoCostaIFG"
            ><img src="/static/gitlab-icon.png" alt="Gitlab"
          /></a>
        </li>
        <li>
          <a href="https://github.com/JoaoCostaIFG"
            ><img src="/static/github-icon.png" alt="Github"
          /></a>
        </li>
        <li>
          <a href="/atom.xml"><img src="/static/rss-icon.png" alt="RSS" /></a>
        </li>
      </ul>
    </header>
