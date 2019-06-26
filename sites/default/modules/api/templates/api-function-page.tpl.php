<dl id="api-function-signature">
<dt class="header"><?php print t('Versions') ?></dt>
<?php foreach ($signatures as $branch => $signature) { ?>
  <?php if ($signature['active']) { ?>
    <dt><strong><?php print $branch ?></strong></dt>
    <dd><strong><code><?php print $signature['signature'] ?></code></strong></dd>
  <?php } else { ?>
    <dt><?php print l($branch, $signature['url']) ?></dt>
    <dd><code><?php print l($signature['signature'], $signature['url'], array('html' => TRUE)) ?></code></dd>
  <?php } ?>
<?php } ?>
</dl>

<?php print $documentation ?>

<?php if (!empty($parameters)) { ?>
<h3><?php print t('Parameters') ?></h3>
<?php print $parameters ?>
<?php } ?>

<?php if (!empty($return)) { ?>
<h3><?php print t('Return value') ?></h3>
<?php print $return ?>
<?php } ?>

<?php if (!empty($related_topics)) { ?>
<h3><?php print t('Related topics') ?></h3>
<?php print $related_topics ?>
<?php } ?>

<?php print $call ?>

<h3><?php print t('Code') ?></h3>
<p><?php print api_file_link($function) ?>, <?php print t('line') ?> <?php print $function->start_line ?></p>
<?php print $code ?>
