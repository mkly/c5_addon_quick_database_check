<?php
defined('C5_EXECUTE') or die('Access Denied');
class DashboardQuickDatabaseCheckSqlCheckController extends Controller {
	public function view() {
		$html = Loader::helper('html');
		$this->addHeaderItem($html->javascript('table2CSV.js', 'quick_database_check'));
		$this->set('invalid_sql', $this->invalid_sql(10));
		$this->set('suspicious_sql', $this->suspicious_sql(10));
		$this->set('expensive_sql', $this->expensive_sql(10));
	}


	protected function invalid_sql($numsql = 10) {
		$perf_table = 'adodb_logsql';
		$db = Loader::db();
		$res = $db->GetAll("select distinct count(*),sql1,tracer as error_msg from adodb_logsql where tracer like 'ERROR:%' group by sql1,tracer order by 1 desc limit ?", array($numsql));
		$res = array_map(array($this, 'replace_newlines'), $res);
		return $res;
	}

	protected function suspicious_sql($numsql = 10) {
		$perf_table = 'adodb_logsql';
		$db = Loader::db();
		$res = $db->GetAll("select avg(timer) as avg_timer,tracer,sql1,count(*),max(timer) as max_timer,min(timer) as min_timer from adodb_logsql where upper(substr(sql0,1,5)) not in ('DROP ', 'INSER', 'COMMI', 'CREAT') and tracer not like '%/dashboard/quick_database_check/%' and (tracer is null or tracer not like 'ERROR:%') group by sql1 order by 1 desc limit ?", array($numsql));
		$res = array_map(array($this, 'replace_newlines'), $res);
		return $res;
	}

	protected function expensive_sql($numsql = 10) {
		$perf_table = 'adodb_logsql';
		$db = Loader::db();
		$res = $db->GetAll("select sum(timer) as total,sql1,tracer,count(*),max(timer) as max_timer,min(timer) as min_timer from adodb_logsql where upper(substr(sql0,1,5)) not in ('DROP ', 'INSER', 'COMMI', 'CREAT') and tracer not like '%/dashboard/quick_database_check/%' and (tracer is null or tracer not like 'ERROR:%') group by sql1 having count(*)>1 order by 1 desc limit ?", array($numsql));
		$res = array_map(array($this, 'replace_newlines'), $res);
		return $res;
	}

	protected function replace_newlines($query) {
		return str_replace(array("\r", "\r\n", "\n", "\t"), ' ', $query);
	}
}
