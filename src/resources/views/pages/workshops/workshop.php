<?php layout('header_workshop.php', array('title' => $args['title'])); ?>

<textarea id="source">
    </textarea>

<script src="<?= res_js('remark.js'); ?>"></script>
<script>
  var slideshow = remark.create({
    sourceUrl: '<?= $args['md']; ?>',
    highlightStyle: 'atom-one-dark',
  });
</script>

</body>

</html>
