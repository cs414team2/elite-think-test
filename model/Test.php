<?php
class Test{
	const CORRECT                       = 'Y';
	const INCORRECT                     = 'N';
	const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
	const TRUE_FALSE_QUESTION_TYPE      = 'TF';
	const ESSAY_QUESTION_TYPE           = 'ESSAY';
	const UNAUTHENTICATED               = 0;
	const AUTHENTICATED                 = 1;
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
	
	public function print_question($question_id, $question_text, $access_level){
		if($access_level == self::TEACHER){
			echo "\r\n<div id='".$question_id."'style='font-weight: bold; padding: 5px; border: 1px solid black; margin-top: 8px'>";
			echo "\r\n   <div><span class='question_number'></span> &nbsp;" . $question_text ."</div>";

			echo "\r\n    <div class='rightAlignInDiv'  style='display: inline-block; max-width: 50%;'>";
			echo "\r\n	    <button style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Edit</button>";
			echo "\r\n	    <button onclick='delete_question(this.parentElement.parentElement)' style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Delete</button>";
			echo "\r\n    </div>";
		}
		else if($access_level == self::STUDENT){
			echo "\r\n<div id='".$question_id."'style='font-weight: bold; padding: 5px; border: 1px solid black; margin-top: 8px'>";
			echo "\r\n   <div><span class='question_number'></span> &nbsp;" . $question_text ."</div>";
		}
	}
	
	public function print_answer($is_correct, $answer_content, $question_type, $user_type, $question_id, $answer_id){
		switch($user_type){
			case self::TEACHER:
				$this->print_teacher_answer($is_correct, $answer_content, $question_type);
				break;
			case self::STUDENT:
				$this->print_student_answer($is_correct, $answer_content, $question_type, $question_id, $answer_id);
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
	
	public function print_essay_answer($user_type){
		if($user_type == self::TEACHER)
			echo "\r\n<div style='color:#47CC7A; padding-left: 50px; font-family: Segoe UI Light;'>Essay Question</div>";
		else
			echo "<textarea id='txt_eq_entry' rows='4' name='txt_eq_entry' style='text-align:left;' class='studentEssayQuestion'></textarea>";
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
		if($access_status == self::AUTHENTICATED)
			return true;
		else
			return false;
	}
	
	public function print_student_answer($is_correct, $answer_content, $question_type, $question_id, $answer_id){
		switch($question_type){
			case self::MULTIPLE_CHOICE_QUESTION_TYPE:
				echo "\r\n<li>
							<input type='radio' id='". $answer_id ."' name='". $question_id ."'>
							<label for='". $answer_id ."'>". $answer_content ."</label>
						  </li>";
				break;
			case self::TRUE_FALSE_QUESTION_TYPE:
				echo "\r\n<input type='radio' id='". $answer_id ."_true' name='". $question_id ."'>
					  <label for='" . $answer_id . "_true' style='margin-left: 5px;'>True</label>";
				echo "\r\n<input type='radio' id='". $answer_id ."_false' name='". $question_id ."'>
					  <label for='" . $answer_id . "_false' style='margin-left: 5px;'>False</label>";
				break;
			case self::ESSAY_QUESTION_TYPE:
				$this->print_essay_answer(self::STUDENT);
				break;
		}
	}
	
	public function print_teacher_answer($is_correct, $answer_content, $question_type){
		switch($question_type){
			case self::MULTIPLE_CHOICE_QUESTION_TYPE:
				if($is_correct == self::CORRECT)
					echo "\r\n<li style='color:#47CC7A;'>".$answer_content."&nbsp;&#10004;</li>";
				else
					echo "\r\n<li style='color:#CC1C11;'>".$answer_content."&nbsp;&#10006;</li>";
				break;
			case self::TRUE_FALSE_QUESTION_TYPE:
				if($answer_content == "True"){
					echo "\r\n<div style='color:#47CC7A; margin-left: 5px; font-family: Segoe UI Light;'>".$answer_content."&nbsp;&#10004;</div>";
					echo "\r\n<div style='color:#CC1C11; margin-left: 5px; font-family: Segoe UI Light;'>False&nbsp;&#10006;</div>";
				}
				else if($answer_content == "False"){
					echo "\r\n<div style='color:#CC1C11; margin-left: 5px;'>True&nbsp;&#10006;</div>";
					echo "\r\n<div style='color:#47CC7A; margin-left: 5px;'>".$answer_content."&nbsp;&#10004;</div>";
				}
				break;
			case self::ESSAY_QUESTION_TYPE:
				$this->print_essay_answer(self::TEACHER);
				break;
		}
	}
}
?>