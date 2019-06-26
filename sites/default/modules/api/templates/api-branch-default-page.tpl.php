<?php if (!empty($branch)) { ?>
  <h3><?php print l('Topics', 'api/groups/' . $branch); ?></h3>
  <?php print api_page_listing($branch, 'group'); ?>
  <h3><?php print l('Files', 'api/files/' . $branch); ?></h3>
  <h3><?php print l('Globals', 'api/globals/' . $branch); ?></h3>
  <h3><?php print l('Constants', 'api/constants/' . $branch); ?></h3>
  <h3><?php print l('Functions', 'api/functions/' . $branch); ?></h3>
  <h3><?php print l('API Search', 'api/search/' . $branch); ?></h3>
<?php } ?>

<p class="api-no-mainpage"><em><?php print t('A main page for this branch has not been indexed. A documentation comment with <code>@mainpage {title}</code> needs to exist, or has not been indexed yet. For Drupal core, this is available in the <a href="http://cvs.drupal.org/viewvc.py/drupal/contributions/docs/developer/">developer documentation</a> in the contributions repository.'); ?></em></p>
