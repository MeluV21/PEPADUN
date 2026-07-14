<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_monitoring_table extends CI_Migration {
    public function up() {
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'progress', 'completed'],
                'default'    => 'pending',
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'activity_date' => [
                'type' => 'DATE',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('monitoring');
        
        // Add foreign key constraints
        $this->db->query("ALTER TABLE `monitoring` ADD CONSTRAINT `fk_monitoring_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
        $this->db->query("ALTER TABLE `monitoring` ADD CONSTRAINT `fk_monitoring_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE");
    }

    public function down() {
        $this->dbforge->drop_table('monitoring');
    }
}
