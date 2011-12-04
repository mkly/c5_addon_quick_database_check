<?php
defined('C5_EXECUTE') or die('Access Denied');

class QuickDatabaseCheckPackage extends Package {
	protected $pkgHandle = 'quick_database_check';
	protected $appVersionRequired = '5.3.0';
	protected $pkgVersion = '1.0';

	public function getPackageDescription() {
		return t('Discover database issues and problematic sql queries');
	}

	public function getPackageName() {
		return t('Quick Database Check');
	}

	public function install() {
		$pkg = parent::install();
		
		Loader::model('single_page');
		SinglePage::add('/dashboard/quick_database_check', $pkg);
		SinglePage::add('/dashboard/quick_database_check/sql_check', $pkg);
		SinglePage::add('/dashboard/quick_database_check/manage_logging', $pkg);
	}

	public function testForInstall($package, $testForAlreadyInstalled = true) {
		parent::testForInstall($package, $testForAlreadyInstalled);

		//Make sure we can write the config file
		$fname = DIR_BASE . '/config/site_process.php';
		$fdir = DIR_BASE . '/config/';
		$emsg = t('File /config/site_process.php cannot be created or written to');
		if(!file_exists($fname) && !is_writeable($fdir)) {
			$errors[] = $emsg;
		} elseif (file_exists($fname) && !is_writeable($fname)) {
			$errors[] = $emsg;
		}
	}

	public function uninstall() {
		$this->remove_command();
		parent::uninstall();
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

		protected function get_command() {
		$cmd = '<?php /* For Db Monitor - Do Not Remove */ $db = Loader::db(); $db->setLogging(true); ?>';
		return $cmd;
	}

}	

