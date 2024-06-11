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
class Migration_insert_field_main_for_galeri extends CI_Migration {


	public function up()
	{ 
		 // Add field to table motor
		 $fields = array(
			'main' => array(
                'type' => 'TINYINT',
				'constraint' => '4',
                'null' => TRUE,
            ),
        );
        $this->dbforge->add_column('galeri', $fields);
	} 

	public function down()
	{
		
	}

}