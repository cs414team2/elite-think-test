<?php
class Test{
	const CORRECT                       = 'Y';
	const INCORRECT                     = 'N';
	const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
	const TRUE_FALSE_QUESTION_TYPE      = 'TF';
	const ESSAY_QUESTION_TYPE           = 'ESSAY';
	const UNAUTHENTICATED               = 0;
	const ADMINISTRATOR                 = 1;
	const TEACHER                       = 2;
	const STUDENT                       = 3;
	
	private $alphabet;
	
	public function __construct(){
		$this->alphabet = range('a', 'z');
	}
	
	private function prepare_connection(){
		return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
	}
	
	public function print_question($question_id, $question_text){
		echo "\r\n<div id='".$question_id."'style='font-weight: bold; padding: 5px; border: 1px solid black; margin-top: 8px'>";
		echo "\r\n   <div><span class='question_number'></span> &nbsp;" . $question_text ."</div>";

		echo "\r\n    <div class='rightAlignInDiv'  style='display: inline-block; max-width: 50%;'>";
		echo "\r\n	    <button style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Edit</button>";
		echo "\r\n	    <button onclick='delete_question(this.parentElement.parentElement)' style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Delete</button>";
		echo "\r\n    </div>";
	}
	
	public function print_answer($is_correct, $count, $answer_content, $question_type, $user_type){
		switch($user_type){
			case self::TEACHER:
				$this->print_teacher_answer($is_correct, $count, $answer_content, $question_type);
				break;
			case self:STUDENT:
				$this->print_student_answer($is_correct, $count, $answer_content, $question_type);
				break;
		}
			
	}
	
	public function get_class_name($test_id){
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT get_class_name_by_test(?)"); 
		$statement->bind_param("i", $test_id);
		$statement->execute();
		$statement->bind_result($class_name);
		$statement->fetch();
		
		echo $class_name;
	}
	
	public function get_test_number($test_id){
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT get_test_number(?)"); 
		$statement->bind_param("i", $test_id);
		$statement->execute();
		$statement->bind_result($test_number);
		$statement->fetch();
		
		echo "Test " . $test_number;
	}
	
	public function print_essay_answer(){
		echo "\r\n<div style='color:#47CC7A'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Essay Question</div>";
	}
	
	public function verify_test_access($user_id, $test_id, $user_type){
		switch($user_type){
			case self::TEACHER:
				$db = $this->prepare_connection();
				$statement = $db->prepare("SELECT verify_teacher_test_access(?, ?)"); 
				$statement->bind_param("ii", $user_id, $test_id);
				$statement->execute();
				$statement->bind_result($access_status);
				$statement->fetch();
				break;
			
			case self::STUDENT:
				$db = $this->prepare_connection();
				$statement = $db->prepare("SELECT verify_student_test_access(?, ?)");
				$statement->bind_param("ii", $user_id, $test_id);
				$statement->execute();
				$statement->bind_result($access_status);
				$statement->fetch();
				break;
		}
		
		return $access_status;
	}
	
	public function print_student_answer($is_correct, $count, $answer_content, $question_type){
		switch($question_type){
			case self::MULTIPLE_CHOICE_QUESTION_TYPE:
				echo "\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$this->alphabet[$count]. ")&nbsp;".$answer_content."</div>";
				break;
			case self::TRUE_FALSE_QUESTION_TYPE:
				echo "\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;True</p>";
				echo "\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;False</p>";
				break;
		}
	}
	
	public function print_teacher_answer($is_correct, $count, $answer_content, $question_type){
		switch($question_type){
			case self::MULTIPLE_CHOICE_QUESTION_TYPE:
				if($is_correct == self::CORRECT)
					echo "\r\n<div style='color:#47CC7A'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$this->alphabet[$count]. ")&nbsp;".$answer_content."&nbsp;&#10004;</div>";
				else
					echo "\r\n<div style='color:#CC1C11'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$this->alphabet[$count]. ")&nbsp;".$answer_content."&nbsp;&#10006;</div>";
				break;
			case self::TRUE_FALSE_QUESTION_TYPE:
				if($answer_content == "True"){
					echo "\r\n<div style='color:#47CC7A'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$answer_content."&nbsp;&#10004;</div>";
					echo "\r\n<div style='color:#CC1C11'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;False&nbsp;&#10006;</div>";
				}
				else if($answer_content == "False"){
					echo "\r\n<div style='color:#CC1C11'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;True&nbsp;&#10006;</div>";
					echo "\r\n<div style='color:#47CC7A'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$answer_content."&nbsp;&#10004;</div>";
				}
				break;
		}
	}
}
?>