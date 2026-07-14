<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users_table extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'karyawan'],
                'default'    => 'karyawan',
            ],
            'created' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'modified' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ]);
        
        $this->dbforge->add_key('id_user', TRUE);
        $this->dbforge->create_table('users');
        
        // Add unique key to username field
        $this->db->query("ALTER TABLE `users` ADD UNIQUE (`username`)");
    }

    public function down() {
        $this->dbforge->drop_table('users');
    }
}
