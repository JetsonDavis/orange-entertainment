<?php
// $Id: node.tpl.php,v 1.5 2007/10/11 09:51:29 goba Exp $
drupal_add_css($directory .'/node-application.css');
?>

<?php if ($page == 0): ?>
  <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
<?php endif; ?>
<?php //dsm($node); ?>

  <div class="content clear-block">
	<table id="film_node_table">
		<colgroup>
		  <col width = "15%">
		  <col width = "25%">
		  <col width = "15%">
		  <col width = "17%">
		  <col width = "15%">
		</colgroup>
		<tr>
			<td>Sales Company:</td>
			<td><?php print $node->field_salescomp[0]['view']?></td>
		</tr>
		<tr>
			<td>Status:</td>
			<td><?php print $node->field_status[0]['view']?></td>
			<td>Read by:</td><td><?php print $node->field_mirjamread[0]['view']?>
		</tr>
		<tr>
			<td>Genre:</td><td><?php print $node->field_genre[0]['view']?></td>
			<td>Submitted By:</td><td><?php print $node->field_subfrom[0]['view']?></td>

		</tr>
		<tr>
			<td>Budget:</td><td><?php print $node->field_language[0]['view']?></td>
			<td>Submitted To:</td><td><?php print $node->field_subto[0]['view']?></td>
		</tr>
		<tr>
			<td>Language:</td><td><?php print $node->field_budget[0]['view']?></td>
			<td>On File:</td><td><?php print $node->field_formatsubed[0]['view']?></td>
		</tr>
		<tr>
			<td>Audience:</td><td><?php print $node->field_poporart[0]['view']?>
		</tr>
		<tr><td> </td></tr>
		<tr><td> </td></tr>
		<?php for ($i=0;$i < sizeof($node->field_cast);$i++) 
		{
			print "<tr><td>";
			print ($i==0)?("Cast:"):(" ");
			print "</td><td>".$node->field_cast[$i]['view']."</td></tr>";
		} ?>	
		</table>
		<br/>
		<table id="film_node_table">
			<colgroup>
				<col width = "6%">
				<col width = "25%">
			</colgroup>
		<tr>
			<td>Director:</td><td><?php print $node->field_director[0]['view']?></td></tr>
			<tr><td>Writer:</td><td><?php print $node->field_writer[0]['view']?></td>
		</tr>
		<?php for ($i=0;$i < sizeof($node->field_producer);$i++) 
		{
			print "<tr><td>";
			print ($i==0)?("Producer:"):(" ");
			print "</td><td>".$node->field_producer[$i]['view']."</td></tr>";
		} ?>		
		</table>
				<br/>
		<table id="film_node_table">

		<colgroup>
			<col width = "194px">
			<col width = "766px">

		</colgroup>	
		<tr>
			<td>Log Line:</td><td><?php print $node->field_logline[0]['view']?></td>
		</tr>
		<tr>
			<td>Screenings:</td><td><?php print $node->screenings[0]['view']?></td>
		</tr>

		<tr>
			<td>Notes:</td><td><?php print $node->field_notes[0]['view']?></td>
		</tr>
		<tr>
			<td>Avails:</td><td><?php print $node->field_addl_avails[0]['view']?></td>
		</tr>
		<?php for ($i=0;$i < sizeof($node->field_fest);$i++) 
		{
			print "<tr><td>";
			print ($i==0)?("Fest/Market(s):"):(" ");
			$result = db_query("SELECT title from {node} WHERE nid=%d",$node->field_fest[$i]['nid']);
			$obj = db_fetch_object($result);
			print "</td><td>".$obj->title." - ".$node->field_festprogram[$i]['value']."</td></tr>";
		} ?>
	</table>
	
	<!-- Print Territory Avail Table -->
<?php if($node->field_terr_name[0]['value'] != null): ?> 
<table id="film_terr_table">
	<colgroup>
		<col width = "20%">
		<col width = "20%">
		<col width = "20%">
		<col width = "20%">
		<col width = "20%">
	</colgroup>
	<tr>
		<th>Territory</th><th>Exceptions</th><th>Rating</th><th>Price</th><th>Sold To</th>
	</tr>
	
	<?php for ($i=0;$i < sizeof($node->field_terr_name);$i++) {
		$result = db_query("SELECT title FROM {node} WHERE type = 'allowed_territories' LIMIT 1 OFFSET %d",$node->field_terr_name[$i]['value']);
		$obj = db_fetch_object($result);
		print "<tr><td>".$obj->title."</td>";
		print "<td>".$node->field_terrexcept[$i]['value']."</td>";
		print "<td>".$node->field_terr_rating[$i]['value']."</td>";
		print "<td>".$node->field_terr_price[$i]['value']."</td>";
		print "<td>".$node->field_terr_sold_to[$i]['value']."</td>";
	} ?>
</table>
<?php endif; ?>
  </div>


<?php if ($node->field_coverage[0]['view'] != ""){
print "<br/><h4>COVERAGE:</h4><br/>";
$coverage = '<EMBED CLASS="xyz" SRC="http://www.orange-ent.net/htdocs/sites/default/files/';
//print "FILE LOCA:".check_plain($node->field_coverage[0]['view']);
$coverage .= substr($node->field_coverage[0]['view'], stripos($node->field_coverage[0]['view'], "files/") + 6, stripos($node->field_coverage[0]['view'], ".pdf",stripos($node->field_coverage[0]['view'], "files/")) - stripos($node->field_coverage[0]['view'], "files/") - 2);
$coverage .= '"#view=FullScreenEmbed,top&pagemode=none&scrollbar=1&statusbar=0&messages=1&navpanes=1" "BORDER=1 HEIGHT=500 WIDTH=100% ALT="">';
print $coverage;
} ?>
<?php if (strlen($node->field_coveragetextonly[0]['view'])>10): ?>
<br/>Coverage (Text version):<?php print $node->field_coveragetextonly[0]['view']; ?>
<?php endif; ?>

<?php if (isset($node->field_script[0]['filename'])) {
print "<br/><div class='script_pdf'>Script:<br/><br/>".$node->field_script[0]['view']."</div>";
} ?>

<br/><br/>
  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
  <?php endif; ?>

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
