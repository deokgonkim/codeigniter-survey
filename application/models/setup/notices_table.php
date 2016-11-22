<?php

/**
 * 이용안내 정보를 담는 notices 테이블에 대한 DB 셋업 클래스
 *
 * id 		INT (PK)	: 이용안내 id값.
 * title 	VARCHAR(256)	: 이용안내 제목 
 * creator	INT		: 이용안내 작성자
 * create_datetime DATETIME	: 이용안내 작성일시
 * modifier	INT		: 이용안내 수정자
 * modify_datetime DATETIME	: 이용안내 수정일시
 * writer	VARCHAR(20)	: 이용안내 게시자 (보이는 이름)
 * content	TEXT		: 이용안내 내용
 * attachment1_name VARCHAR(256) : 이용안내 첨부파일1 파일명
 * attachment2_name VARCHAR(256) : 이용안내 첨부파일2 파일명
 * attachment3_name VARCHAR(256) : 이용안내 첨부파일3 파일명
 * attachment1	LONGBLOB	: 이용안내 첨부파일1 ( max 4GB )
 * attachment2	LONGBLOB	: 이용안내 첨부파일2 ( max 4GB )
 * attachment3	LONGBLOB	: 이용안내 첨부파일3 ( max 4GB )
 * status	INT		: 이용안내 상태 (게시0, 보류1, 삭제3)
 *
 * @author dgkim
 */
class Notices_table extends CI_Model {

	var $table_name = 'notices';

	public function __construct() {
		parent::__construct();
	}

	public function create_table() {

		$this->dbforge->add_field('id INT NOT NULL AUTO_INCREMENT PRIMARY KEY');
		$this->dbforge->add_field('title VARCHAR(256) NOT NULL');
		$this->dbforge->add_field('creator INT NOT NULL');
		$this->dbforge->add_field('create_datetime DATETIME');
		$this->dbforge->add_field('modifier INT');
		$this->dbforge->add_field('modify_datetime DATETIME');
		$this->dbforge->add_field('writer VARCHAR(20)');
		$this->dbforge->add_field('content TEXT');
		$this->dbforge->add_field('attachment1_name VARCHAR(256)');
		$this->dbforge->add_field('attachment2_name VARCHAR(256)');
		$this->dbforge->add_field('attachment3_name VARCHAR(256)');
		$this->dbforge->add_field('attachment1 LONGBLOB');
		$this->dbforge->add_field('attachment2 LONGBLOB');
		$this->dbforge->add_field('attachment3 LONGBLOB');
		$this->dbforge->add_field('status INT DEFAULT 0');

		$this->dbforge->create_table($this->table_name, FALSE);
	}

	public function fulfill_table() {
		$data = array(
				'title' => '환영합니다.',
				'creator' => 1,
				'create_datetime' => date_create()->format('Y-m-d H:i:s'),
				'writer' => '관리자',
				'content' => '설문조사 시스템 사용을 환영합니다.'
			);

		$query = $this->db->get_where($this->table_name, array('id' => '1'), 1, 0);
		if ( $query->result() )	{
			throw new Exception('default data exists');
		}
		$this->db->insert($this->table_name, $data);
	}

	public function drop_table() {
		$this->dbforge->drop_table($this->table_name);
	}
}
