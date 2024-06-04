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
class Migration_insert_field_keterangan_and_nama_pelanggan extends CI_Migration {


	public function up()
	{ 
		 // Add field to table transaksi
		 $fields = array(
            'keterangan' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'default' => NULL,
            ),
			'nama_pelanggan' => array(
                'type' => 'VARCHAR',
				'constraint' => '100',
                'null' => TRUE,
                'default' => NULL,
            )
        );
        $this->dbforge->add_column('transaksi', $fields);
	} 

	public function down()
	{
		
	}

}