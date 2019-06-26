<?php
// $Id: node.tpl.php,v 1.5 2007/10/11 09:51:29 goba Exp $
drupal_add_css($directory .'/node-application.css');
?>
<a href="newfilmfest">New Film Festival/Market</a>&nbsp&nbsp

<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">



<?php if ($page == 0): ?>
  <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
<?php endif; ?>


  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
  <?php endif; ?>


  <div class="content clear-block">
    <?php print $content ?>
  </div>
  <div class="content clear-block">
	<br/><br/><br/>
    <?php print views_embed_view('subs_log', 'page_3',($node->nid)); ?>
  </div>


