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
	const DATE_IS_SET                   = 1;
	
	private $alphabet;
	private $test_id;
	
	public function __construct($test_id){
		$this->alphabet = range('a', 'z');
		$this->test_id = $test_id;
	}
	
	private function prepare_connection(){
		return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
	}
	
	public function print_question($question_id, $question_text, $access_level, $question_type){
		if($access_level == self::TEACHER){
			echo "\r\n<div id='".$question_id."'style='font-weight: bold; padding: 5px; border: 1px solid black; margin-top: 8px' data-question-type='". $question_type . "'>";
			echo "\r\n   <div><span class='question_number'></span> &nbsp;<span class='question_text'>" . $question_text ."</span></div>";

			echo "\r\n    <div class='rightAlignInDiv'  style='display: inline-block; max-width: 50%;'>";
			echo "\r\n	    <button style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small' onclick='open_question_editor(this.parentElement.parentElement)'>Edit</button>";
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
				$this->print_teacher_answer($is_correct, $answer_content, $question_type, $question_id);
				break;
			case self::STUDENT:
				$this->print_student_answer($answer_content, $question_type, $question_id, $answer_id);
				break;
		}
			
	}
	
	public function get_class_name(){
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT get_class_name_by_test(?)"); 
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->bind_result($class_name);
		$statement->fetch();
		
		echo $class_name;
	}
	
	public function get_test_number(){
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT get_test_number(?)"); 
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->bind_result($test_number);
		$statement->fetch();
		
		echo "Test " . $test_number;
	}
	
	public function print_essay_answer($question_id, $user_type){
		if($user_type == self::TEACHER)
			echo "\r\n<div style='color:#47CC7A; padding-left: 20px; font-family: Segoe UI Light;'>Essay Question</div>";
		else
			echo "\r\n<textarea id='txt_eq_entry' rows='4' name='" . $question_id . "' style='text-align:left;' class='studentEssayQuestion'></textarea>";
	}
	
	public function verify_test_access($user_id, $user_type){
		switch($user_type){
			case self::TEACHER:
				$db = $this->prepare_connection();
				$statement = $db->prepare("SELECT verify_teacher_test_access(?, ?)"); 
				$statement->bind_param("ii", $user_id, $this->test_id);
				$statement->execute();
				$statement->bind_result($access_status);
				$statement->fetch();
				break;
			
			case self::STUDENT:
				$db = $this->prepare_connection();
				$statement = $db->prepare("SELECT verify_student_test_access(?, ?)");
				$statement->bind_param("ii", $user_id, $this->test_id);
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
	
	public function print_student_answer($answer_content, $question_type, $question_id, $answer_id){
		switch($question_type){
			case self::MULTIPLE_CHOICE_QUESTION_TYPE:
				echo "\r\n<li>
							<input type='radio' id='answer_". $answer_id ."' name='". $question_id ."' value='". $answer_id ."' class='answer'>
							<label for='answer_". $answer_id ."'>". $answer_content ."</label>
						  </li>";
				break;
			case self::TRUE_FALSE_QUESTION_TYPE:
				echo "\r\n
					  <input type='radio' id='answer_". $answer_id ."_true' name='". $question_id ."' value='T' class='answer'>" 
				   . "<label for='answer_" . $answer_id . "_true' style='margin-left: 5px;'>True</label>
				      \r\n<input type='radio' id='answer_". $answer_id ."_false' name='". $question_id ."' value='F' class='answer'>"
				   . "<label for='answer_" . $answer_id . "_false' style='margin-left: 5px;'>False</label>";
				break;
			case self::ESSAY_QUESTION_TYPE:
				$this->print_essay_answer($question_id, self::STUDENT);
				break;
		}
	}
	
	public function print_teacher_answer($is_correct, $answer_content, $question_type, $question_id){
		switch($question_type){
			case self::MULTIPLE_CHOICE_QUESTION_TYPE:
				if($is_correct == self::CORRECT)
					echo "\r\n<li style='color:#47CC7A; font-family: Segoe UI Light;'>".$answer_content."&nbsp;&#10004;</li>";
				else
					echo "\r\n<li style='color:#CC1C11; font-family: Segoe UI Light;'>".$answer_content."&nbsp;&#10006;</li>";
				break;
			case self::TRUE_FALSE_QUESTION_TYPE:
				if($answer_content == "T"){
					echo "\r\n<div style='color:#47CC7A; padding-left: 20px; font-family: Segoe UI Light;'>True&nbsp;&#10004;</div>";
					echo "\r\n<div style='color:#CC1C11; padding-left: 20px; font-family: Segoe UI Light;'>False&nbsp;&#10006;</div>";
				}
				else if($answer_content == "F"){
					echo "\r\n<div style='color:#CC1C11; padding-left: 20px; font-family: Segoe UI Light;'>True&nbsp;&#10006;</div>";
					echo "\r\n<div style='color:#47CC7A; padding-left: 20px; font-family: Segoe UI Light;'>False&nbsp;&#10004;</div>";
				}
				break;
			case self::ESSAY_QUESTION_TYPE:
				$this->print_essay_answer($question_id, self::TEACHER);
				break;
		}
	}
	
	public function get_date_due(){
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT date_due 
		                           FROM   test 
								   WHERE  test_id = ?") or die($db->error);
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($date_due);
		
		if($statement->num_rows > 0)
			$statement->fetch();
		
		return date('j F Y', strtotime($date_due));
	}
	
	public function get_date_active(){
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT date_active 
		                           FROM   test 
								   WHERE  test_id = ?") or die($db->error);
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($date_active);
		
		if($statement->num_rows > 0)
			$statement->fetch();
		
		return date('j F Y', strtotime($date_active));
	}
	
	public function has_started($student_id){
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT time_started 
		                           FROM   student_test 
								   WHERE  test_id = ? and student_id = ? and time_started is not null") or die($db->error);
		$statement->bind_param("ii", $this->test_id, $student_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($time_started);
		
		if($statement->num_rows > 0)
			return true;
		else
			return false;
	}
	
	public function is_completed($student_id){
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT is_completed 
		                           FROM   student_test 
								   WHERE  test_id = ? and student_id = ? and is_completed = 'Y'") or die($db->error);
		$statement->bind_param("ii", $this->test_id, $student_id);
		$statement->execute();
		$statement->store_result();
		
		if($statement->num_rows > 0)
			return true;
		else
			return false;
	}
	
	public function has_timed_out($student_id){
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT student_test_id 
		                           FROM   student_test 
								   WHERE  test_id = ? and student_id = ? and end_time < now()") or die($db->error);
		$statement->bind_param("ii", $this->test_id, $student_id);
		$statement->execute();
		$statement->store_result();
		
		if($statement->num_rows > 0)
			return true;
		else
			return false;
	}
	
	public function due_date_is_set(){
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT count(date_due) 
		                           FROM   test 
		                           WHERE  test_id = ? and date_due is not null") or die($db->error);
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->bind_result($date_is_set);
		$statement->fetch();
		
		return ($date_is_set >= self::DATE_IS_SET ? 'true' : 'false');
	}
	
	public function active_date_is_set(){
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT count(date_active) 
		                           FROM   test 
		                           WHERE  test_id = ? and date_active is not null") or die($db->error);
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->bind_result($date_is_set);
		$statement->fetch();
		
		return ($date_is_set >= self::DATE_IS_SET ? 'true' : 'false');
	}
}
?>