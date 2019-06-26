<?php
// $Id: node.tpl.php,v 1.5 2007/10/11 09:51:29 goba Exp $
drupal_add_css($directory .'/node-application.css');
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">

<?php //dsm($node);?>

<?php if ($page == 0): ?>
  <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
<?php endif; ?>

  <div class="content clear-block">
	<table id="company_info_node">
		<colgroup>
			<col width = "24%">
			<col width = "80%">
		</colgroup>
		<tr>
			<td>Company Name:</td><td><?php print $node->title?></td>
		</tr>
		<?php for ($i=0;$i < sizeof($node->field_compcontact);$i++) 
		{
			print "<tr><td>";
			print ($i==0)?("Contact:"):(" ");
			print "</td><td>".$node->field_compcontact[$i]['view']."</td></tr>";
		} ?>		

		<tr>
			<td>Address:</td><td><?php print $node->field_compstreet[0]['view']?></td>
		</tr>
		<tr>
			<?php for ($i=0;$i < sizeof($node->field_addrlabel);$i++) {if ($node->field_addrlabel[$i]['value']) {print "<tr><td>".$node->field_addrlabel[$i]['value'].":</td><td>".$node->field_compcannesaddr[$i]['value'];
			print ($node->field_printaddr[$i]['value']=="Print This Address")?(" "):("&nbsp&nbsp<bold>[Don't print]</bold>")."</td></tr>";
			}
		} ?>
			
		<?php for ($i=0;$i < sizeof($node->field_compphone);$i++) {if ($node->field_compphonelabel[$i]['value']) {print "<tr><td>".$node->field_compphonelabel[$i]['value']."</td><td>".$node->field_compphone[$i]['value']."</td></tr>";}} ?>
	</table>
  </div>

  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
  <?php endif; ?>
<br/><br/><br/>
<?php print views_embed_view('subs_log', 'page_2',($node->nid)); ?>

  <div class="clear-block">
    <div class="meta">
    <?php if ($taxonomy): ?>
      <div class="terms"><?php print $terms ?></div>
    <?php endif;?>
    </div>

    <?php if ($links): ?>
      <div class="links"><?php print $links; ?></div>
    <?php endif; ?>
  </div>

</div>
