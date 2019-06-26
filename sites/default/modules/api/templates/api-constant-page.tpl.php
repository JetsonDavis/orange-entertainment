<p><?php print t('in') ?> <?php print api_file_link($constant) ?></p>

<?php print $documentation ?>

<?php print $code ?>

<?php if (!empty($related_topics)) { ?>
<h3><?php print t('Related topics') ?></h3>
<?php print $related_topics ?>
<?php } ?>
