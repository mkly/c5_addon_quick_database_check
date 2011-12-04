<?php
defined('C5_EXECUTE') or die('Access Denied');
class DashboardQuickDatabaseCheckManageLoggingController extends Controller {
	public function view() {
		$method = $this->post('method');
		if($method == 'enable_logging') {
			$this->enable_logging();
			$this->set('logging_enabled', true);
		} elseif($method == 'disable_logging') {
			$this->disable_logging();
			$this->set('logging_enabled', false);
		} elseif($method == 'clear_log') {
			$this->clear_log();
			$this->set('logging_enabled', $this->get_status());
		} else {
			$this->set('logging_enabled', $this->get_status());
		}
	}

	public function enable_logging() {
		$this->set('message', t('Logging Enabled'));
		$this->add_command();
	}

	protected function disable_logging() {
		$this->set('message', t('Logging Disabled'));
		$this->remove_command();
	}

	protected function clear_log() {
		$perf_table = 'adodb_logsql';
		$db = Loader::db();
		if($db->GetOne("show tables like 'adodb_logsql'") !== NULL) {
			$this->set('message', t('Log Cleared'));
			$db->Execute("TRUNCATE TABLE adodb_logsql");
		}
	}

	protected function add_command() {
		$fname = DIR_BASE . '/config/site_process.php';
		if(!file_exists($fname)) {
			file_put_contents($fname, $this->get_command());
		} else {
			if($hndl = fopen($fname, 'r')) {
				if(filesize($fname)) {
					$cnts = fread($hndl, filesize($fname));
					fclose($hndl);
					$cnts = str_replace($this->get_command(), '', $cnts);
					$cnts = preg_replace('/(\r|\r\n|\n)$/', '', $cnts);
					file_put_contents($fname, $cnts . "\n" . $this->get_command());
				} else {
					file_put_contents($fname, $this->get_command());
				}
			}
		}
	}

	protected function remove_command() {
		$fname = DIR_BASE . '/config/site_process.php';
		if(file_exists($fname)) {
			if($hndl = fopen($fname, 'r')) {
				if(filesize($fname)) {
					$cnts = fread($hndl, filesize($fname));
					fclose($hndl);
					$cnts = str_replace($this->get_command(), '', $cnts);
					$cnts = preg_replace('/(\r|\r\n|\n)$/', '', $cnts);
					file_put_contents($fname, $cnts);
				}
			}
		}
	}

	protected function get_status() {
		$fname = DIR_BASE . '/config/site_process.php';
		if(file_exists($fname)) {
			if($hndl = fopen($fname, 'r')) {
				if(filesize($fname)) {
					$cnts = fread($hndl, filesize($fname));
					fclose($hndl);
					$pos = @strpos($this->get_command(), str_replace(array("\r", "\r\n", "\n"), ' ', $cnts));
					if($pos !== false) {
						return true;
					}	else {
						return false;
					}
				}
			}
		}
		return false;
	}
	protected function get_command() {
		$cmd = '<?php /* For Db Monitor - Do Not Remove */ $db = Loader::db(); $db->setLogging(true); ?>';
		return $cmd;
	}
}
?>
