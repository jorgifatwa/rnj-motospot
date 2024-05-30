<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_api_limits
 *
 * @property CI_DB_forge         $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_create_table_motor extends CI_Migration {


	public function up()
	{ 
		$table = "motor";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'merk_id'          => [
				'type' => 'TINYINT(4)',
			],
			'jenis_id'          => [
				'type' => 'TINYINT(4)',
			],
			'cabang_id'          => [
				'type' => 'TINYINT(4)',
			],
			'nik'          => [
				'type' => 'VARCHAR(100)',
			],
			'km'          => [
				'type' => 'INT(11)',
			],
			'pajak'          => [
				'type' => 'DATE',
			],
			'harga_modal'          => [
				'type' => 'INT(11)',
			],
			'harga_open'=> [
				'type' => 'INT(11)',
			],
			'harga_net'=> [
				'type' => 'INT(11)',
			],
			'keterangan'      => [
				'type' => 'VARCHAR(100)',
			],
			'status'          => [
				'type' => 'INT(1)',
			],
			'created_at'      => [
				'type' => 'DATETIME',
			],
			'updated_at'      => [
				'type' => 'DATETIME',
			],
			'created_by'      => [
				'type' => 'TINYINT(4)',
			],
			'updated_by'      => [
				'type' => 'TINYINT(4)',
			],
			'is_deleted' => [
				'type' => 'TINYINT(4)',
			],
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($table);
	 
	}


	public function down()
	{
		$table = "motor";
		if ($this->db->table_exists($table))
		{
			$this->db->query(drop_foreign_key($table, 'api_key'));
			$this->dbforge->drop_table($table);
		}
	}

}
