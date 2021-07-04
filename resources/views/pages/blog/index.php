<?php layout_header('Blog index'); ?>

<h2>All of my blog posts</h2>

<?php if (is_auth()) { ?>
  <a href="<?php echo route('blog_insert_route'); ?>">+</a>
<?php } ?>

<ul>
  <li><a href="./cake_recipe.php">The recipe for my favorite cake</a> - 2021-03-01</li>
  <li><a href="./chin_chang_hanji.php">Ching Chang Hanji</a> - 2020-10-20</li>
  <li><a href="./github_ssh_2fa.php">Github, ssh keys and 2FA</a> - 2020-03-09</li>
  <li><a href="./plantuml.php">Draw UML diagrams with PlantUML</a> - 2020-02-22</li>
  <li><a href="./developing_for_mycroft.php">Developing a skill for Mycroft</a> - 2020-02-16</li>
  <li><a href="./lcom_and_ubuntu.php">My adventure with Ubuntu and LCOM's exam day</a> - 2020-02-12</li>
  <li><a href="./estoria_historia.php">Estória vs. história</a> - 2020-02-03</li>
  <li><a href="./how_create_page.php">How I created this web page</a> - 2020-01-30</li>
  <li><a href="./first_post.php">First Post</a> - 2020-01-21</li>
</ul>

<?php layout_footer(); ?>
