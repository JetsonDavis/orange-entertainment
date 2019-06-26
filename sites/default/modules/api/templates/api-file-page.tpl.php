<?php if (!empty($file->version)) { ?>
<p><?php print t('Version') ?> <?php print $file->version ?></p>
<?php } ?>

<?php print $documentation ?>

<?php if (!empty($constants)) { ?>
<h3><?php print t('Constants') ?></h3>
<?php print $constants ?>
<?php } ?>
<?php if (!empty($globals)) { ?>
<h3><?php print t('Globals') ?></h3>
<?php print $globals ?>
<?php } ?>
<?php if (!empty($functions)) { ?>
<h3><?php print t('Functions') ?></h3>
<?php print $functions ?>
<?php } ?>
