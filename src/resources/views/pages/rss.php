<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="en">
  <title type="text">joaocosta.dev</title>
  <updated><?= $args['bs'][0]->getDateStr(); ?></updated>
  <link rel="alternate" type="text/html" href="https://joaocosta.dev" />
  <id>https://joaocosta.dev/atom</id>
  <link rel="self" type="application/atom+xml" href="https://joaocosta.dev/atom" />
  <?php foreach ($args['bs'] as $b) { ?>
    <entry>
      <title><?= $b->getTitle(); ?></title>
      <?php $route = 'https://joaocosta.dev' . route_args('blog_post_route', array('id' => $b->getId())); ?>
      <link rel="alternate" type="text/html" href="<?= $route; ?>" />
      <id><?= $route; ?></id>
      <updated><?= $b->getDateStr(); ?></updated>
      <published><?= $b->getDateStr(); ?></published>
      <content type="html">
        <![CDATA["<?= $b->getIntro(); ?>"]]>
      </content>
    </entry>
  <?php } ?>
</feed>
