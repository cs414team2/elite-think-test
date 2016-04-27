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
	private $alphabet;
	private $answer_count;
	private $question_count;
	private $user_type;
	private $matching_answers_list;
	
	public function __construct($test_id){
		$this->test_id  = $test_id;
		$this->db       = $this->prepare_connection();
		$this->alphabet = range('a', 'z');
	}
	
	private function prepare_connection(){
		return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
	}
	
	public function print_question($question_id, $question_text, $access_level, $question_type, $question_weight){
		if($access_level == self::TEACHER){
			echo "\r\n<li id='".$question_id."' class='' data-question-type='". $question_type . "'><hr />";
			echo "\r\n   <div><span class='question_number'></span> &nbsp;<span class='question_text question_style'>" . htmlspecialchars($question_text) ."</span> <span style='float: right;'>&nbsp;<span class='question_weight' >". $question_weight ."</span> Point(s)</span></div>";

			echo "\r\n    <div class='rightAlignInDiv'  style='display: inline-block; max-width: 50%;'>";
			echo "\r\n	    <img src='images/edit.png' class='clickable_img clickable_img_circular' title='Edit Question' href='#' style='width: 31px; height: 31px;' onclick='open_question_editor(this.parentElement.parentElement)'>";
			echo "\r\n	    <img src='images/delete.png' class='clickable_img clickable_img_circular' title='Delete Question' style='width: 31px; height: 31x;' onclick='delete_question(this.parentElement.parentElement)' href='#'>";
			echo "\r\n<br />";
			echo "\r\n      <img src='images/arrowup.png' class='clickable_img clickable_img_circular' title='Move Up' onclick='raise_question(this.parentElement.parentElement)'>";
			echo "\r\n      <img src='images/arrowDown.png' class='clickable_img clickable_img_circular' title='Move Down' onclick='lower_question(this.parentElement.parentElement)'>";
			echo "\r\n    </div>";
		}
		else if($access_level == self::STUDENT){
			echo "\r\n<li id='".$question_id."' class='question_item' data-question-type='". $question_type . "' style='margin-top: 8px'><hr />";
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
	
	public function set_user_type($user_type) {
		$this->user_type = $user_type;
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
				echo "\r\n<br />";
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
	
	public function print_finished_students(){

		$statement = $this->db->prepare("SELECT student_test_id, student_id, student_fname, student_lname
										   FROM completed_tests
										  WHERE test_id = ?") or die($db->error);
											  
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($student_test_id, $student_id, $student_fname, $student_lname);
		
		if($statement->num_rows > 0){
			while($statement->fetch()){
				echo'<div class="area_finished_students">
						'. $student_lname .', '. $student_fname .'<button id="'. $student_test_id .'" class="alt button special view_test_button" data-student-id="'.$student_id.'" data-student-name="'.$student_fname.'">View</button>
					 </div>';
			}
		}
		else {
			echo "<div>No students have completed the test.</div>";
		}
			
	}
	public function print_finished_ungraded_students(){
		
		$statement = $this->db->prepare("SELECT student_test_id, student_id, student_fname, student_lname
										   FROM completed_ungraded_tests
										  WHERE test_id = ?") or die($db->error);
											  
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($student_test_id, $student_id, $student_fname, $student_lname);
		
		if($statement->num_rows > 0){
			while($statement->fetch()){
				echo'<div class="gradeTestDiv">
						'. $student_lname .', '. $student_fname .'<button id="'. $student_test_id .'" class="alt button special gradeTestButton" data-student-id="'.$student_id.'" data-student-name="'.$student_fname.'">Grade</button>
					 </div>';
			}
		}
		else {
			echo "<div> No completed tests are waiting to be graded.</div>";
		}
			
	}
	
	public function get_time_limit() {
		$statement = $this->db->prepare('SELECT time_limit
		                                   FROM test
										  WHERE test_id = ?');
		
		$statement->bind_param('i', $this->test_id);
		$statement->bind_result($time_limit);
		$statement->execute();
		$statement->fetch();
		
		return $time_limit;
	}
	
	public function is_active() {
		$statement = $this->db->prepare('SELECT date_active
		                                   FROM test
										  WHERE test_id = ?');
		
		$statement->bind_param('i', $this->test_id);
		$statement->bind_result($date_active);
		$statement->execute();
		$statement->fetch();
		
		if ($date_active == null)
			$is_active = false;
		else
		    $is_active = (time() - strtotime($date_active)) >= 0 ? true : false;
		
		return $is_active;
	}
	
/*********************************************************************************************/
/*                                      MATCHING SECTION                                     */
/*********************************************************************************************/
	public function print_matching_sections($u_type){
		$this->user_type = $u_type;
		$statement = $this->db->prepare("SELECT matching_section_id, matching_section_description
									     FROM matching_section 
									     WHERE test_id = ? ORDER BY section_number") or die($db->error);
		$statement->bind_param("i", $this->test_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($matching_section_id, $matching_section_description);
		
		if($statement->num_rows > 0){
			echo "<div class='my-form-builder' id='".Test::MATCHING_QUESTION_TYPE."'>";
			echo "\r\n  <h4> Matching Sections <br /> Answers may be used once, more than once, or not at all.</h4>";
			echo "\r\n  <ul class='section_list'>";
			while($statement->fetch()){
				$this->print_section($matching_section_id, $matching_section_description);
			}
			echo "\r\n  </ul>";
		}
		else {
			echo "<div class='my-form-builder' id='".Test::MATCHING_QUESTION_TYPE."' style='display:none;'>";
			echo "\r\n  <h4> Matching Sections </h4>";
			echo "\r\n  <ul class='section_list'>";
			echo "\r\n  </ul>";
		}
		echo "\r\n</div>";
	}
	
	public function print_section($matching_section_id, $matching_section_description){
		$statement = $this->db->prepare("SELECT sum(mq.question_weight), round((sum(mq.question_weight) / count(mq.matching_question_id)), 1)
		                                 FROM   matching_section ms JOIN matching_question mq 
										 ON     ms.matching_section_id = mq.matching_section_id 
										 WHERE  mq.matching_section_id = ?") or die($db->error);
		$statement->bind_param("i", $matching_section_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($section_points_total, $section_points_per);
		$statement->fetch();
		
		echo "\r\n<li data-section-id='". $matching_section_id ."' class='' data-question-type='". self::MATCHING_QUESTION_TYPE ."'><hr />";
		echo "\r\n<div><span class='section_desc question_style'>". htmlspecialchars($matching_section_description) ."</span> <span style='float:right'> ". $section_points_total ." Point(s) Total </span></div>";
		echo "<div><span style='float:right'> (". $section_points_per ." pts each) </span></div><br />";
		if($this->user_type == self::TEACHER) {
			echo "\r\n<div class='rightAlignInDiv' style='display: inline-block; max-width: 50%;'>
				  \r\n<img src='images/edit.png' class='clickable_img clickable_img_circular' title='Edit Question' style='width: 31px; height: 31px;' href='#' onclick='open_matching_section_editor(this.parentElement.parentElement)'>
				  \r\n<img src='images/delete.png' class='clickable_img clickable_img_circular' title='Delete Question' style='width: 31px; height: 31px;' onclick='delete_matching_section(this.parentElement.parentElement)' href='#'>
				  \r\n<br />
				  \r\n<img src='images/arrowup.png' class='clickable_img clickable_img_circular' title='Move Up' onclick='raise_section(this.parentElement.parentElement)'>
				  \r\n<img src='images/arrowDown.png' class='clickable_img clickable_img_circular' title='Move Down' onclick='lower_section(this.parentElement.parentElement)'>
			  \r\n</div>";
		}
		$this->print_matching_answers($matching_section_id);
		$this->print_matching_questions($matching_section_id);
		
		echo "\r\n";
		// Loop to print whitespace depending on how many items there are
		for($count = 0; $count < ($this->answer_count - $this->question_count); $count++)
		{
			echo "<br />";
		}
		echo "</li>";
	}

	private function print_matching_questions($matching_section_id){
		$this->question_count = 0;
		if ($this->user_type == self::TEACHER) {
			$question_statement = $this->db->prepare("SELECT matching_question_id, question_text, question_weight, matching_answer_id
												  FROM matching_question 
												  WHERE matching_section_id = ?
												  ORDER BY question_number") or die($db->error);
			$question_statement->bind_param("i", $matching_section_id);
			$question_statement->bind_result($matching_question_id, $question_text, $question_weight, $matching_answer_id);
		}
		else {
			$question_statement = $this->db->prepare("SELECT mq.matching_question_id, mq.question_text, mq.question_weight, get_student_answer(mq.matching_question_id) as answer_given
													    FROM matching_question mq
													   WHERE mq.matching_section_id = ?
													   ORDER BY mq.question_number") or die($db->error);
			$question_statement->bind_param("i", $matching_section_id);
			$question_statement->bind_result($matching_question_id, $question_text, $question_weight, $answer_given);
			
		}
		
		$question_statement->execute();
		$question_statement->store_result();
		
		echo "\r\n <ol class='matching_questions' data-section-id='". $matching_section_id ."' >";
		
		while($question_statement->fetch()){
			$matching_answer_tag = ($this->user_type == self::TEACHER ? "data-matching-answer-id='". $matching_answer_id ."'" : "");
			echo "\r\n <li class='question_item question_list' data-question-type='". self::MATCHING_QUESTION_TYPE . "' data-question-id='". $matching_question_id ."' ". $matching_answer_tag ." data-weight='".$question_weight."'>";
			if ($this->question_count > 0) {
				echo "\r\n<hr style='margin-top: 8px !important; margin-bottom: 3px !important;' />";
			}
			echo "\r\n   <span class='question_number' > </span> <span class='question_text' >". htmlspecialchars($question_text) ."</span>";
			if($this->user_type == self::STUDENT){
				echo "\r\n  <br /> <select class='matching_input_box' style='display: inline-block; width: 120px;'>";
				echo "\r\n       <option value='null'></option>";
				for($count = 0; $count < $this->answer_count; $count++){
					echo "\r\n <option value='". $this->matching_answers_list[$count]["id"]."'";
					if ($answer_given == $this->matching_answers_list[$count]["id"])
						echo "selected";
					echo ">". $this->alphabet[$count] . ") " . $this->matching_answers_list[$count]["text"] . "</option>";
				}
				echo "\r\n   </select>";
			}
			else {
				for($count = 0; $count < $this->answer_count; $count++){
					if ($matching_answer_id == $this->matching_answers_list[$count]["id"])
						echo "\r\n <br /><span style='margin-left: 27px; color:#47CC7A;'>". $this->matching_answers_list[$count]["text"] . "</span>";
				}
			} 
			echo "\r\n </li>";
			$this->question_count++;
		}
		echo "\r\n </ol>";
	}
	
	private function print_matching_answers($matching_section_id){
		$this->matching_answers_list = array();
		$this->answer_count = 0;
		$answer_statement = $this->db->prepare("SELECT matching_answer_id, answer_content
												FROM matching_answer 
												WHERE matching_section_id = ?") or die($db->error);
		$answer_statement->bind_param("i", $matching_section_id);
		$answer_statement->execute();
		$answer_statement->store_result();
		$answer_statement->bind_result($matching_answer_id, $answer_content);
		
		echo "\r\n <ol class='matching_answers' data-section-id='". $matching_section_id ."' >";
		while($answer_statement->fetch()){
			$this->matching_answers_list[$this->answer_count]["id"]   = $matching_answer_id;
			$this->matching_answers_list[$this->answer_count]["text"] = htmlspecialchars($answer_content);
			echo "\r\n <li class='answer_item' data-answer-id='". $matching_answer_id ."'>";
			echo "\r\n   <span class='answer_text'>". htmlspecialchars($answer_content) ."</span>";
			echo "\r\n </li>";
			$this->answer_count++;
		}
		echo "\r\n </ol>";
	}
}
?>