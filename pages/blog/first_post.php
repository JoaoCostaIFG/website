<?php
$title="First post";
require_once '../../templates/tpl_header.php';
?>

<h2>First Post</h2>
<p>
  This is just a sample page that is slightly extending what's done in the
  <a href="https://gohugo.io/getting-started/quick-start">Quick Start</a>
  guide for HUGO. Below is some sample C code to test
  <a href="https://prismjs.com/">PrismJS</a> syntax highlighting.
</p>

<pre><code class="language-c">
  int
  main(void) {
    puts("Hello World\n");
    return 0;
  }
 </code></pre>

<?php
require_once '../../templates/tpl_footer.php';
?>
