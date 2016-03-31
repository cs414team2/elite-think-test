<?php
class Test{
	const CORRECT                       = 'Y';     // Signifies that a question is correct
	const INCORRECT                     = 'N';     // Signifies that a question is incorrect
	const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
	const TRUE_FALSE_QUESTION_TYPE      = 'TF';
	const ESSAY_QUESTION_TYPE           = 'ESSAY';
	const MATCHING_QUESTION_TYPE        = 'MATCH';
	const UNAUTHENTICATED               = 0;
	const AUTHENTICATED                 = 1;
	const ADMINISTRATOR                 = 1;
	const TEACHER                       = 2;
	const STUDENT                       = 3;
	const DATE_IS_SET                   = 1;
	
	private $test_id;
	private $db;
	
	public function __construct($test_id){
		$this->test_id = $test_id;
		$this->db = $this->prepare_connection();
	}
	
	private function prepare_connection(){
		return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
	}
	
	public function print_question($question_id, $question_text, $access_level, $question_type, $question_weight){
		if($access_level == self::TEACHER){
			echo "\r\n<li id='".$question_id."' style='font-weight: bold; padding: 5px; border: 1px solid black; margin-top: 8px' data-question-type='". $question_type . "'>";
			echo "\r\n   <div><span class='question_number'></span> &nbsp;<span class='question_text'>" . htmlspecialchars($question_text) ."</span> <span style='float: right;'>&nbsp;<span class='question_weight' >". $question_weight ."</span> Point(s)</span></div>";

			echo "\r\n    <div class='rightAlignInDiv'  style='display: inline-block; max-width: 50%;'>";
			echo "\r\n	    <button style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small' onclick='open_question_editor(this.parentElement.parentElement)'>Edit</button>";
			echo "\r\n	    <button onclick='delete_question(this.parentElement.parentElement)' style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Delete</button>";
			echo "\r\n    </div>";
		}
		else if($access_level == self::STUDENT){
			echo "\r\n<li id='".$question_id."' class='the_question' style='font-weight: bold; padding: 5px; border: 1px solid black; margin-top: 8px'>";
			echo "\r\n   <div><span class='question_number'></span> &nbsp;" . htmlspecialchars($question_text) ."<span class='question_weight' style='float: right;'>".$question_weight . ($question_weight == 1 ? " Point" : " Points") . "</span></div>";
		}
	}
	
	public function print_answer($is_correct, $answer_content, $question_type, $user_type, $question_id, $answer_id, $answer_given){
		switch($user_type){
			case self::TEACHER:
				$this->print_teacher_answer($is_correct, $answer_content, $question_type, $question_id, $answer_id);
				break;
			case self::STUDENT:
				$this->print_student_answer($answer_content, $question_type, $question_id, $answer_id, $answer_given);
				break;
		}
			
	}
	
	public function get_class_name(){
		$statement = $this->db->prepare("SELECT get_class_name_by_test(?)") or die($db->error); 
		$statement->bind_param("i", $this->test_id) 				        or die($statement->error);
		$statement->execute() 									            or die($statement->error);
		$statement->bind_result($class_name) 				                or die($statement->error);
		$statement->fetch() 							                    or die($statement->error);
		
		return $class_name;
	}
	
	public function get_test_number(){
		$statement = $this->db->prepare("SELECT get_test_number(?)"); 
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->bind_result($test_number);
		$statement->fetch();
		
		return $test_number;
	}
	
	public function verify_test_access($user_id, $user_type){
		switch($user_type){
			case self::TEACHER:
				$statement = $this->db->prepare("SELECT verify_teacher_test_access(?, ?)"); 
				$statement->bind_param("ii", $user_id, $this->test_id);
				$statement->execute();
				$statement->bind_result($access_status);
				$statement->fetch();
				break;
			
			case self::STUDENT:
				$statement = $this->db->prepare("SELECT verify_student_test_access(?, ?)");
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
	
	public function print_student_answer($answer_content, $question_type, $question_id, $answer_id, $answer_given){
		switch($question_type){
			case self::MULTIPLE_CHOICE_QUESTION_TYPE:
				echo "\r\n<li>
							<input type='radio' id='answer_". $answer_id ."' name='". $question_id ."' value='". $answer_id ."' class='answer' ". ($answer_given == $answer_id ? "checked" : " ") . ">
							<label for='answer_". $answer_id ."'>". htmlspecialchars($answer_content) ."</label>
						  </li>";
				break;
			case self::TRUE_FALSE_QUESTION_TYPE:
				echo "\r\n
					  <input type='radio' id='answer_". $answer_id ."_true' name='". $question_id ."' value='T' class='answer' ". ($answer_given == 'T' ? "checked" : " ") . ">" 
				   . "<label for='answer_" . $answer_id . "_true' style='margin-left: 5px;'>True</label>
				      \r\n<input type='radio' id='answer_". $answer_id ."_false' name='". $question_id ."' value='F' class='answer' ". ($answer_given == 'F' ? "checked" : " ") . ">"
				   . "<label for='answer_" . $answer_id . "_false' style='margin-left: 5px;'>False</label>";
				break;
			case self::ESSAY_QUESTION_TYPE:
				echo "\r\n<textarea id='txt_eq_entry' rows='4' name='" . htmlspecialchars($question_id) . "' style='text-align:left;' class='studentEssayQuestion'>". $answer_given ."</textarea>";
				break;
		}
	}
	
	public function print_teacher_answer($is_correct, $answer_content, $question_type, $question_id, $answer_id){
		switch($question_type){
			case self::MULTIPLE_CHOICE_QUESTION_TYPE:
				if($is_correct == self::CORRECT)
					echo "\r\n<li style='color:#47CC7A; font-family: Segoe UI Light;'> <span class='answer' data-answer-id='".$answer_id."' data-is-correct='Y'>".htmlspecialchars($answer_content)."</span><span class='symbol'>&nbsp;&#10004;</span></li>";
				else
					echo "\r\n<li style='color:#CC1C11; font-family: Segoe UI Light;'> <span class='answer' data-answer-id='".$answer_id."' data-is-correct='N'>".htmlspecialchars($answer_content)."</span><span class='symbol'>&nbsp;&#10006;</span></li>";
				break;
			case self::TRUE_FALSE_QUESTION_TYPE:
				if($answer_content == "T"){
					echo "\r\n<div style='color:#47CC7A; padding-left: 20px; font-family: Segoe UI Light;' class='answer true_answer' data-answer-id='".$answer_id."' data-is-correct='Y'>True&nbsp;&#10004;</div>";
					echo "\r\n<div style='color:#CC1C11; padding-left: 20px; font-family: Segoe UI Light;' class='false_answer' >False&nbsp;&#10006;</div>";
				}
				else if($answer_content == "F"){
					echo "\r\n<div style='color:#CC1C11; padding-left: 20px; font-family: Segoe UI Light;' class='true_answer'>True&nbsp;&#10006;</div>";
					echo "\r\n<div style='color:#47CC7A; padding-left: 20px; font-family: Segoe UI Light;' class='answer false_answer' data-answer-id='".$answer_id."' data-is-correct='Y'>False&nbsp;&#10004;</div>";
				}
				break;
			case self::ESSAY_QUESTION_TYPE:
				echo "\r\n<div style='color:#47CC7A; padding-left: 20px; font-family: Segoe UI Light;' class='answer' data-answer-id='".$answer_id."' data-is-correct='Y'>". htmlspecialchars(($answer_content == null ? "(no description)" : $answer_content))."</div>";
				break;
		}
	}
	
	public function get_date_due(){
		$statement = $this->db->prepare("SELECT date_due 
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
		$statement = $this->db->prepare("SELECT date_active 
		                                 FROM   test 
								         WHERE  test_id = ?") or die($this->db->error);
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($date_active);
		
		if($statement->num_rows > 0)
			$statement->fetch();
		
		return date('j F Y', strtotime($date_active));
	}
	
	public function has_started($student_id){
		$statement = $this->db->prepare("SELECT time_started 
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
		$statement = $this->db->prepare("SELECT is_completed 
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
		$statement = $this->db->prepare("SELECT DISTINCT student_test_id 
		                                 FROM  student_test 
								         WHERE test_id = ? and student_id = ? and end_time < now()") or die($db->error);
		$statement->bind_param("ii", $this->test_id, $student_id);
		$statement->execute();
		$statement->store_result();
		
		if($statement->num_rows > 0)
			return true;
		else
			return false;
	}
	
	public function due_date_is_set(){
		$statement = $this->db->prepare("SELECT count(date_due) 
		                                 FROM   test 
		                                 WHERE  test_id = ? and date_due is not null") or die($db->error);
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->bind_result($date_is_set);
		$statement->fetch();
		
		return ($date_is_set >= self::DATE_IS_SET ? 'true' : 'false');
	}
	
	public function active_date_is_set(){
		$statement = $this->db->prepare("SELECT count(date_active) 
		                                 FROM   test 
		                                 WHERE  test_id = ? and date_active is not null") or die($db->error);
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->bind_result($date_is_set);
		$statement->fetch();
		
		return ($date_is_set >= self::DATE_IS_SET ? 'true' : 'false');
	}
	
	public function get_completed_tests(){
		$statement = $this->db->prepare("SELECT student_test_id, student_id, student_fname, student_lname
									     FROM completed_tests 
									     WHERE test_id = ?") or die($db->error);
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($student_test_id, $student_id, $student_fname, $student_lname);
		
		if($statement->num_rows > 0){
			while($statement->fetch()){
				echo'<div class="gradeTestDiv">
						<h1>'. $student_lname .', '. $student_fname .'<button id="'. $student_test_id .'" class="alt button special reset gradeTestButton" data-student-id="'.$student_id.'" >Grade</button><h1>
					 </div>';
			}
		}
		else
			echo "<div> No Completed Tests </div>";
	}
	
/*********************************************************************************************/
/*                                      MATCHING SECTION                                     */
/*********************************************************************************************/
	public function print_matching_sections(){
		$statement = $this->db->prepare("SELECT matching_section_id, matching_section_description
									     FROM matching_section 
									     WHERE test_id = ? ORDER BY section_number") or die($db->error);
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($matching_section_id, $matching_section_description);
		
		if($statement->num_rows > 0){
			echo "<div class='my-form-builder' id='".Test::MATCHING_QUESTION_TYPE."'>";
			echo "\r\n  <h4> Matching Sections </h4>";
			echo "\r\n  <ul class='question_list'>";
			while($statement->fetch()){
				$this->print_section($matching_section_id, $matching_section_description);
			}
			echo "\r\n  </ul>";
		}
		else {
			echo "<div class='my-form-builder' id='".Test::MATCHING_QUESTION_TYPE."' style='display:none;'>";
			echo "\r\n  <h4> Matching Sections </h4>";
		}
		echo "\r\n</div>";
	}
	
	public function print_section($matching_section_id, $matching_section_description){
		echo "\r\n<li data-section_id='". $matching_section_id ."' style='font-weight: bold; padding: 5px; border: 1px solid black; margin-top: 8px' data-question-type='". self::MATCHING_QUESTION_TYPE ."'>";
		echo "<h5>". $matching_section_description ."</h5>";
		
		$this->print_matching_questions($matching_section_id);
		$this->print_matching_answers($matching_section_id);
		
		echo "\r\n</li>";
	}

	public function print_matching_questions($matching_section_id){
		$question_statement = $this->db->prepare("SELECT matching_question_id, question_text, question_weight, matching_answer_id
												  FROM matching_question 
												  WHERE matching_section_id = ?") or die($db->error);
		$question_statement->bind_param("i", $matching_section_id);
		$question_statement->execute();
		$question_statement->store_result();
		$question_statement->bind_result($matching_question_id, $question_text, $question_weight, $matching_answer_id);
		
		echo "<ol class='matching_questions' data-section-id='". $matching_section_id ."'>";
		while($question_statement->fetch()){
			echo "<li class='question_item'>";
			echo "\r\n   <span class='answer_number answer answer_text' data-question-id='". $matching_question_id ."' data-matching-answer-id='". $matching_answer_id ."'>". htmlspecialchars($question_text) ."</span>";
			echo "</li>";
		}
		echo "</ol>";
		
	}
	
	public function print_matching_answers($matching_section_id){
		$answer_statement = $this->db->prepare("SELECT matching_answer_id, answer_content
												FROM matching_answer 
												WHERE matching_section_id = ?") or die($db->error);
		$answer_statement->bind_param("i", $matching_section_id);
		$answer_statement->execute();
		$answer_statement->store_result();
		$answer_statement->bind_result($matching_answer_id, $answer_content);
		
		echo "<ol class='matching_answers' data-section-id='". $matching_section_id ."'>";
		while($answer_statement->fetch()){
			echo "<li class='answer_item'>";
			echo "\r\n   <span class='answer_number answer answer_text' data-question-id='". $matching_answer_id ."'>". htmlspecialchars($answer_content) ."</span>";
			echo "</li>";
		}
		echo "</ol>";
	}
}
?>