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
class Migration_insert_field_for_motor extends CI_Migration {


	public function up()
	{ 
		 // Add field to table motor
		 $fields = array(
			'warna' => array(
                'type' => 'VARCHAR',
                'null' => TRUE,
				'constraint' => '100',
                'default' => NULL,
            ),
			'nopol' => array(
                'type' => 'VARCHAR',
                'null' => TRUE,
				'constraint' => '100',
                'default' => NULL,
            ),
			'modal_akhir' => array(
                'type' => 'INT',
                'null' => TRUE,
                'default' => 0,
            ),
			'biaya_perbaikan' => array(
                'type' => 'INT',
                'null' => TRUE,
                'default' => 0,
            ),
			'part_ori' => array(
                'type' => 'VARCHAR',
                'null' => TRUE,
				'constraint' => '100',
                'default' => NULL,
            ),
			'link_instagram' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'default' => NULL,
            ),
        );
        $this->dbforge->add_column('motor', $fields);
	} 

	public function down()
	{
		
	}

}