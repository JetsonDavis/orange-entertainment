<dl class="api-functions">
<?php foreach ($functions as $function) { ?>
  <dt><?php print $function['function'] ?> <small>in <?php print $function['file'] ?></small></dt>
  <dd><?php print $function['description'] ?></dd>
<?php } ?>
</dl>
