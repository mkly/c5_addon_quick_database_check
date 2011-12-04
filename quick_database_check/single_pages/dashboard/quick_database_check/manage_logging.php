<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div id="ccm-dashboard-content-inner">
<h1><span><?php echo t('Database Monitor') ?></span></h1>
<div class="ccm-dashboard-inner">
	<div style="margin:0px; padding:0px; width:100%; height:auto;">
		<table class="grid-list" width="600" cellspacing="1" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td class="header" colspan="2">
						<?php echo t('Manage Logging'); ?>
					</td>
				</tr>
					<?php if($logging_enabled): ?>
				<tr>
					<td class="subheader" colspan="2">
						<?php echo t('IMPORTANT: Disable logging and clear log after troubleshooting'); ?>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="background-color: #FFD9D4" class="subheader">
						<?php echo t('Logging currently enabled') ?>
					</td>
				</tr>
				<tr>
						<td>
							<form method="post" action="">
								<input type="submit" value="<?php echo t('Disable Logging'); ?>" />
								<input type="hidden" name="method" value="disable_logging" />
							</form>
						</td>
						<td>
							<form method="post" action="">
								<input type="submit" value="<?php echo t('Clear Log'); ?>" />
								<input type="hidden" name="method" value="clear_log" />
							</form>
						</td>
				</tr>
					<?php else: ?>
				<tr>
					<td class="subheader" colspan="2">
						<?php echo t('WARNING: Logging is only meant for temporary troubleshooting of database performance issues. If you leave this on it will slow down your site and eventually fill up your database.'); ?>
					</td>
				</tr>
				<tr>
						<td>
							<form method="post" action="">
								<input type="submit" value="<?php echo t('Enable Logging'); ?>" />
								<input type="hidden" name="method" value="enable_logging" />
							</form>
						</td>
						<td>
							<form method="post" action="">
								<input type="submit" value="<?php echo t('Clear Log'); ?>" />
								<input type="hidden" name="method" value="clear_log" />
							</form>
						</td>
				</tr>
					<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
