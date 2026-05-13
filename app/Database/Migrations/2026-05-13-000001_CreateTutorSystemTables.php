<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTutorSystemTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 120],
            'code' => ['type' => 'VARCHAR', 'constraint' => 20],
            'email' => ['type' => 'VARCHAR', 'constraint' => 120],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 30],
            'city' => ['type' => 'VARCHAR', 'constraint' => 80],
            'address' => ['type' => 'VARCHAR', 'constraint' => 160],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->createTable('companies');

        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'company_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 120],
            'email' => ['type' => 'VARCHAR', 'constraint' => 120],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role' => ['type' => 'VARCHAR', 'constraint' => 30],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'active'],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addForeignKey('company_id', 'companies', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('users');

        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'company_id' => ['type' => 'INT', 'unsigned' => true],
            'tutor_id' => ['type' => 'INT', 'unsigned' => true],
            'student_id' => ['type' => 'INT', 'unsigned' => true],
            'subject' => ['type' => 'VARCHAR', 'constraint' => 80],
            'starts_at' => ['type' => 'TIMESTAMP'],
            'duration_minutes' => ['type' => 'INT'],
            'location' => ['type' => 'VARCHAR', 'constraint' => 120],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'planned'],
            'price' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'default' => 0],
            'homework' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('company_id', 'companies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tutor_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('student_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lessons');

        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'lesson_id' => ['type' => 'INT', 'unsigned' => true],
            'topic' => ['type' => 'VARCHAR', 'constraint' => 160],
            'progress' => ['type' => 'INT'],
            'homework_checked' => ['type' => 'SMALLINT', 'default' => 0],
            'student_comment' => ['type' => 'TEXT', 'null' => true],
            'tutor_comment' => ['type' => 'TEXT'],
            'filled_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('lesson_id', 'lessons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lesson_entries');

        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'class_name' => ['type' => 'VARCHAR', 'constraint' => 160],
            'method_name' => ['type' => 'VARCHAR', 'constraint' => 80],
            'action' => ['type' => 'VARCHAR', 'constraint' => 80],
            'message' => ['type' => 'TEXT'],
            'created_at' => ['type' => 'TIMESTAMP'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('action_logs');
    }

    public function down()
    {
        $this->forge->dropTable('action_logs', true);
        $this->forge->dropTable('lesson_entries', true);
        $this->forge->dropTable('lessons', true);
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('companies', true);
    }
}
