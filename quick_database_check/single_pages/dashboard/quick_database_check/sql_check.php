<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<script type="text/javascript">
$(function() {
	$('#export-suspicious-sql').click(function(e) {
		e.preventDefault();
		$('#suspicious-sql').table2CSV();
	});
	$('#export-expensive-sql').click(function(e) {
		e.preventDefault();
		$('#expensive-sql').table2CSV();
	});
	$('#export-invalid-sql').click(function(e) {
		e.preventDefault();
		$('#expensive-sql').table2CSV();
	});
});
</script>
<style>
	table.grid-list td.odd {
		background-color: #eef1f2;
	}
</style>
<div id="ccm-dashboard-content-inner">
<h1><span><?php echo t('Database Monitor') ?></span></h1>
<div class="ccm-dashboard-inner">
	<div style="margin:0px; padding:0px; width:100%; height:auto;">
		<table id="suspicious-sql" class="grid-list" width="600" cellspacing="1" cellpadding="0" border="0">
			<h2 class="header" colspan="6">
				<?php echo t('Suspicious SQL'); ?> <small><a id="export-suspicious-sql" href="">export</a></small>
			</h2>
			<thead>
				<tr>
					<td class="subheader"><?php echo t('Count'); ?></td>
					<td class="subheader"><?php echo t('Avg'); ?></td>
					<td class="subheader"><?php echo t('Max'); ?></td>
					<td class="subheader"><?php echo t('Min'); ?></td>
					<td class="subheader"><?php echo t('Script'); ?></td>
					<td class="subheader"><?php echo t('Sql'); ?></td>
				</tr>
			</thead>
			<tbody>
			<?php if(empty($suspicious_sql)): ?>
				<tr>
					<td colspan="6">
						<?php echo t('No SQL Data Logged'); ?>
					</td>
				</tr>
				<?php else: ?>
				<?php foreach($suspicious_sql as $idx => $s_sql): ?>
				<?php ($idx%2) ? $class = 'class="odd"' : $class = ''; ?>
				<tr>
					<td <?php echo $class ?>><?php echo $s_sql['count(*)'] ?></td>
					<td <?php echo $class ?>><?php echo $s_sql['avg_timer'] ?></td>
					<td <?php echo $class ?>><?php echo $s_sql['max_timer'] ?></td>
					<td <?php echo $class ?>><?php echo $s_sql['min_timer'] ?></td>
					<td <?php echo $class ?>><?php echo preg_replace('/^<br>.*\//U', '/', $s_sql['tracer']); ?></td>
					<td <?php echo $class ?>><?php echo $s_sql['sql1'] ?></td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
		<table id="expensive-sql" class="grid-list" width="600" cellspacing="1" cellpadding="0" border="0">
			<thead>
				<h2 style="margin-top: 15px" class="header" colspan="6">
					<?php echo t('Expensive SQL'); ?> <small><a id="export-expensive-sql" href="">export</a></small>
				</h2>
				<tr>
					<td class="subheader"><?php echo t('Count'); ?></td>
					<td class="subheader"><?php echo t('Total'); ?></td>
					<td class="subheader"><?php echo t('Max'); ?></td>
					<td class="subheader"><?php echo t('Min'); ?></td>
					<td class="subheader"><?php echo t('Script'); ?></td>
					<td class="subheader"><?php echo t('Sql'); ?></td>
				</tr>
			</thead>
			<tbody>
				<?php if(empty($expensive_sql)): ?>
				<tr>
					<td colspan="6">
						<?php echo t('No SQL Data Logged'); ?>
					</td>
				</tr>
				<?php else: ?>
				<?php foreach($expensive_sql as $idx => $e_sql): ?>
				<?php ($idx%2) ? $class='class="odd"' : $class=''; ?>
				<tr>
					<td <?php echo $class ?>><?php echo $e_sql['count(*)'] ?></td>
					<td <?php echo $class ?>><?php echo $e_sql['total'] ?></td>
					<td <?php echo $class ?>><?php echo $e_sql['max_timer'] ?></td>
					<td <?php echo $class ?>><?php echo $e_sql['min_timer'] ?></td>
					<td <?php echo $class ?>><?php echo preg_replace('/^<br>.*\//U', '/', $e_sql['tracer']); ?></td>
					<td <?php echo $class ?>><?php echo $e_sql['sql1'] ?></td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
		<table id="invalid-sql" class="grid-list" width="600" cellspacing="1" cellpadding="0" border="0">
			<thead>
				<h2 style="margin-top: 15px" class="header" colspan="5">
					<?php echo t('Invalid SQL'); ?>	<small><a id="export-invalid-sql" href="">export</a></small>
				</h2>
				<tr>
					<td class="subheader"><?php echo t('Count'); ?></td>
					<td class="subheader"><?php echo t('Sql'); ?></td>
					<td class="subheader"><?php echo t('Error'); ?></td>
				</tr>
			</thead>
			<tbody>
				<?php if(empty($invalid_sql)): ?>
				<tr>
					<td colspan="3">
						<?php echo t('No SQL Data Logged'); ?>
					</td>
				</tr>
				<?php else: ?>
				<?php foreach($invalid_sql as $idx => $i_sql): ?>
				<tr>
					<td <?php echo $class ?>><?php echo $i_sql['count(*)'] ?></td>
					<td <?php echo $class ?> colspan="2"><?php echo $i_sql['sql1'] ?></td>
					<td <?php echo $class ?> colspan="2"><?php echo $i_sql['error_msg'] ?></td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
