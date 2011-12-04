<?php
defined('C5_EXECUTE') or die('Access Denied.');
class DashboardQuickDatabaseCheckController extends Controller {
	public function view() {
		$this->redirect('/dashboard/quick_database_check/sql_check');
	}
}
?>
