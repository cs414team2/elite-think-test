<?php
class StudentTest{
	const CORRECT                       = 'Y';     // Signifies that a question is correct
	const INCORRECT                     = 'N';     // Signifies that a question is incorrect
	const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
	const TRUE_FALSE_QUESTION_TYPE      = 'TF';
	const ESSAY_QUESTION_TYPE           = 'ESSAY';
	const MATCHING_QUESTION_TYPE        = 'MATCH';
	const RIGHT_COLOR                   = ' #47CC7A;';
	const WRONG_COLOR                   = ' #CC1C11;';
	const UNANSWERED_COLOR              = ' orange';
	const CHECK_MARK                    = ' &#10004;';
	const X_MARK                        = ' &#10006;';
	const LEFT_ARROW                    = ' &lArr;';
	const UNAUTHENTICATED               = 0;
	const AUTHENTICATED                 = 1;
	const ADMINISTRATOR                 = 1;
	const TEACHER                       = 2;
	const STUDENT                       = 3;
	
	private $test_id;
	private $student_id;
	private $db;
	private $alphabet;
	private $answer_count;
	private $question_count;
	private $user_type;
	private $matching_answers_list;
	
	public function __construct($test_id, $student_id){
		$this->test_id    = $test_id;
		$this->student_id = $student_id;
		$this->alphabet   = range('a', 'z');
		$this->db         = $this->prepare_connection();
	}
	
	private function prepare_connection(){
		return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
	}
	
	public function get_letter_grade() {
		$grade = $this->get_number_grade();
		
		if($grade >= 98) {
			$letter_grade = 'A+';
		}
		elseif($grade >= 93) {
			$letter_grade = 'A';
		}
		elseif($grade >= 90) {
			$letter_grade = 'A-';
		}
		elseif($grade >= 88) {
			$letter_grade = 'B+';
		}
		elseif($grade >= 83) {
			$letter_grade = 'B';
		}
		elseif($grade >= 80) {
			$letter_grade = 'B-';
		}
		elseif($grade >= 78) {
			$letter_grade = 'C+';
		}
		elseif($grade >= 73) {
			$letter_grade = 'C';
		}
		elseif($grade >= 70) {
			$letter_grade = 'C-';
		}
		elseif($grade >= 68) {
			$letter_grade = 'D+';
		}
		elseif($grade >= 63) {
			$letter_grade = 'D';
		}
		elseif($grade >= 60) {
			$letter_grade = 'D-';
		}
		else {
			$letter_grade = 'F';
		}
		
		return $letter_grade;
	}
	
	public function get_number_grade() {
		$grade_statement = $this->db->prepare('SELECT grade
		                                         FROM student_test
											    WHERE test_id = ?
												  AND student_id = ?');
		$grade_statement->bind_param('ii', $this->test_id, $this->student_id);
		$grade_statement->bind_result($grade);
		$grade_statement->execute();
		$grade_statement->fetch();
		return $grade;
	}
	
	// Print the student's results of taking the test.
	public function print_test($user_type){
		$question_statement       = $this->db->prepare("SELECT question_id, question_text, question_weight FROM question WHERE test_id = ? AND question_type = ? ORDER BY question_number") or die($this->db->error);
		$answer_statement   	  = $this->db->prepare("SELECT answer_id, answer_content, is_correct FROM answer WHERE question_id = ?") or die($this->db->error);
		$student_answer_statement = $this->db->prepare("SELECT answer_given, points_received, student_answer_id FROM student_test_answers WHERE student_id = ? AND test_id = ? AND question_id = ?") or die($this->db->error);
		$question_type            = self::TRUE_FALSE_QUESTION_TYPE;
		$question_statement->bind_param("is", $this->test_id, $question_type);
		
		/*********************************************************************************************/
		/*                                     TRUE/FALSE SECTION                                    */
		/*********************************************************************************************/
		// Get the true false questions.
		$question_statement->execute();
		$question_statement->store_result();
		$question_statement->bind_result($question_id, $question_text, $question_weight);
		
		// Print the questions and answers.
		if($question_statement->num_rows > 0){
			echo "\r\n<div class='my-form-builder' id='".self::TRUE_FALSE_QUESTION_TYPE."'>";
			echo "\r\n  <h4> T/F Questions </h4>";
			echo "\r\n  <ul class='question_list'>";
			while($question_statement->fetch()){					
				// Load all possible answers
				$answer_statement->bind_param("i", $question_id);
				$answer_statement->execute();
				$answer_statement->store_result();
				$answer_statement->bind_result($answer_id, $answer_content, $is_correct);
				
				// Load student answers to questions
				$student_answer_statement->bind_param("iii", $this->student_id, $this->test_id, $question_id);
				$student_answer_statement->execute() or die($student_answer_statement->error);
				$student_answer_statement->store_result();
				$student_answer_statement->bind_result($answer_given, $points_received, $student_answer_id);
				$student_answer_statement->fetch();
				
				// Print the question
				$this->print_question($question_id, $question_text, $user_type, $question_type, $question_weight, $points_received, $student_answer_id);
				
				while($answer_statement->fetch())
					$this->print_answer($is_correct, $answer_content, $question_type, $user_type, $question_id, $answer_id, $answer_given);
				echo "\r\n</li>";
			}
		}
		else{
			echo "\r\n<div class='my-form-builder' id='".self::TRUE_FALSE_QUESTION_TYPE."' style='display:none;'>";
			echo "\r\n  <h4> T/F Questions </h4>";
			echo "\r\n	<ul class='question_list'>";
		}
		echo "\r\n   </ul>\r\n</div>";
		
		/*********************************************************************************************/
		/*                                MULTIPLE CHOICE SECTION                                    */
		/*********************************************************************************************/
		// Get the multiple choice questions.
		$question_type = self::MULTIPLE_CHOICE_QUESTION_TYPE;
		$question_statement->execute();
		$question_statement->store_result();
		$question_statement->bind_result($question_id, $question_text, $question_weight);
		
		if($question_statement->num_rows > 0){
			echo "\r\n<div class='my-form-builder' id='".self::MULTIPLE_CHOICE_QUESTION_TYPE."'>";
			echo "\r\n  <h4> Multiple Choice Questions </h4>";
			echo "\r\n  <ul class='question_list'>";
			while($question_statement->fetch()){
				// Load all answer options
				$answer_statement->bind_param("i", $question_id);
				$answer_statement->execute();
				$answer_statement->store_result();
				$answer_statement->bind_result($answer_id, $answer_content, $is_correct);
				
				// Load student answers to questions
				$student_answer_statement->bind_param("iii", $this->student_id, $this->test_id, $question_id);
				$student_answer_statement->execute();
				$student_answer_statement->store_result();
				$student_answer_statement->bind_result($answer_given, $points_received, $student_answer_id);
				$student_answer_statement->fetch();
				
				// Print the question
				$this->print_question($question_id, $question_text, $user_type, $question_type, $question_weight, $points_received, $student_answer_id);
				
				echo "<ol style='list-style-type:lower-alpha; margin-left: 20px; margin-bottom: 1px; font-family Segoe UI Light;'>";
				while($answer_statement->fetch())
					$this->print_answer($is_correct, $answer_content, $question_type, $user_type, $question_id, $answer_id, $answer_given);
				echo "</ol>";
				echo "\r\n</li>";
			}
		}
		else {
			echo "\r\n  <div class='my-form-builder' id='".self::MULTIPLE_CHOICE_QUESTION_TYPE."' style='display:none;'>";
			echo "\r\n  <h4> Multiple Choice Questions </h4>";
			echo "\r\n  <ul class='question_list'>";
		}
		echo "\r\n   </ul>\r\n</div>";

		/*********************************************************************************************/
		/*                                        ESSAY SECTION                                      */
		/*********************************************************************************************/
		// Get the essay questions.
		$question_type = self::ESSAY_QUESTION_TYPE;
		$question_statement->execute();
		$question_statement->store_result();
		$question_statement->bind_result($question_id, $question_text, $question_weight);
		
		// Print the questions and answers.
		if($question_statement->num_rows > 0){
			echo "\r\n<div class='my-form-builder' id='".self::ESSAY_QUESTION_TYPE."'>";
			echo "\r\n  <h4> Essay Questions </h4>";
			echo "\r\n  <ul class='question_list'>";
			while($question_statement->fetch()){	
				// Load student answer options
				$answer_statement->bind_param("i", $question_id);
				$answer_statement->execute();
				$answer_statement->store_result();
				$answer_statement->bind_result($answer_id, $answer_content, $is_correct);
				
				// Load student answers to questions
				$student_answer_statement->bind_param("iii", $this->student_id, $this->test_id, $question_id);
				$student_answer_statement->execute();
				$student_answer_statement->store_result();
				$student_answer_statement->bind_result($answer_given, $points_received, $student_answer_id);
				$student_answer_statement->fetch();
				
				// Print the question
				$this->print_question($question_id, $question_text, $user_type, $question_type, $question_weight, $points_received, $student_answer_id);
				
				while($answer_statement->fetch())
					$this->print_answer($is_correct, $answer_content, $question_type, $user_type, $question_id, $answer_id, $answer_given);
				echo "\r\n</li>";
			}
		}
		else {
			echo "<div class='my-form-builder' id='".self::ESSAY_QUESTION_TYPE."' style='display:none;'>";
			echo "\r\n  <h4> Essay Questions </h4>";
			echo "\r\n  <ul class='question_list'>";
		}
		echo "\r\n   </ul>\r\n</div>";
		$this->print_matching_sections(self::STUDENT);
	}
	
	// Print the question
	public function print_question($question_id, $question_text, $user_type, $question_type, $question_weight, $points_received, $student_answer_id){
		if($question_type == self::ESSAY_QUESTION_TYPE){
			echo "\r\n<li id='".$question_id."' style='margin-top: 8px' data-question-type='". $question_type . "' data-points-received='". $points_received ."' data-student-answer-id='". $student_answer_id ."'><hr />";
			if ($user_type == self::TEACHER) 
				echo "\r\n   <div><span class='question_number'></span> &nbsp;<span class='question_text'>" . htmlspecialchars($question_text) ."</span><span style='float: right;'> <input type='number' id='txt_essay_points_" . $question_id . "' value='". $question_weight ."' min='0' max='". $question_weight ."' style='width:3.5em; margin-bottom:1em; margin-top:1em;' onFocus=(this.name=this.value)><label for='txt_essay_points_" . $question_id . "' class='question_weight'> / ". $question_weight ." " . ($question_weight > 1 ? "Points" : "Point") . "</label></span></div>";
			else
				echo "\r\n   <div><span class='question_number'></span> &nbsp;<span class='question_text'>" . htmlspecialchars($question_text) ."</span><span style='float: right;'> " . $points_received . " / ". $question_weight ." " . ($question_weight > 1 ? "Points" : "Point") . "</span></div>";
		}
		else{
			echo "\r\n<li id='".$question_id."' style='margin-top: 8px' data-question-type='". $question_type . "' data-points-received='". $points_received ."'><hr />";
			echo "\r\n   <div><span class='question_number'></span> &nbsp;<span class='question_text'>" . htmlspecialchars($question_text) ."</span><span style='float: right;'> ". $points_received . " / ". $question_weight ." " . ($question_weight > 1 ? "Points" : "Point") . "</span></div>";
		}
	}
	
	// Print the answer formatted based off of the question type
	public function print_answer($is_correct, $answer_content, $question_type, $user_type, $question_id, $answer_id, $answer_given){
			switch($question_type){
				case self::MULTIPLE_CHOICE_QUESTION_TYPE:
					if($answer_given != null)
						if($answer_given == $answer_id){
							$color  = ($is_correct == 'Y' ? self::RIGHT_COLOR : self::WRONG_COLOR);
							$symbol = ($color == self::RIGHT_COLOR ? self::CHECK_MARK : self::X_MARK);
						}
						else{
							$color  = ($is_correct == 'Y' ? self::RIGHT_COLOR : " ");
							$symbol = ($color == self::RIGHT_COLOR ? self::CHECK_MARK : " ");
						}
					else{
						$color = ($is_correct == 'Y' ? self::UNANSWERED_COLOR : " ");
						$symbol = ($color == self::UNANSWERED_COLOR ? self::LEFT_ARROW : " ");
					}
					
					echo "\r\n<li>
								<input type='radio' disabled='disabled' id='answer_". $answer_id ."' name='". $question_id ."' value='". $answer_id ."' class='answer' ". ($answer_given == $answer_id ? "checked" : " ") . ">
								<label for='answer_". $answer_id ."' style='color:". $color ."'>". htmlspecialchars($answer_content) . $symbol . "</label>
							  </li>";
					break;
				case self::TRUE_FALSE_QUESTION_TYPE:
					if($answer_content == 'T'){
						if($answer_given == $answer_content){
							$true_color  = self::RIGHT_COLOR;
							$false_color = ' ';
							$true_symbol = self::CHECK_MARK;
							$false_symbol = ' ';
						}
						elseif($answer_given == null){
							$true_color  = self::UNANSWERED_COLOR;
							$false_color = ' ';
							$true_symbol = self::LEFT_ARROW;
							$false_symbol = ' ';
						}
						else{
							$true_color = self::RIGHT_COLOR;
							$false_color = self::WRONG_COLOR;
							$true_symbol = self::CHECK_MARK;
							$false_symbol = self::X_MARK;
						}
					}
					elseif($answer_given == $answer_content){
						$false_color = self::RIGHT_COLOR;
						$true_color = ' ';
						$false_symbol = self::CHECK_MARK;
						$true_symbol = ' ';
					}
					elseif($answer_given == null){
						$false_color = self::UNANSWERED_COLOR;
						$true_color = ' ';
						$false_symbol = self::LEFT_ARROW;
						$true_symbol = ' ';
					}
					else{
						$false_color = self::RIGHT_COLOR;
						$true_color = self::WRONG_COLOR;
						$true_symbol = self::X_MARK;
						$false_symbol = self::CHECK_MARK;
					}
					echo "\r\n
						  <input type='radio' disabled='disabled' id='answer_". $answer_id ."_true' name='". $question_id ."' value='T' class='answer' ". ($answer_given == 'T' ? "checked" : " ") . ">" 
					   . "<label for='answer_" . $answer_id . "_true' style='margin-left: 5px; color:". $true_color ."'>True ". $true_symbol ."</label>
						  \r\n<input type='radio' disabled='disabled' id='answer_". $answer_id ."_false' name='". $question_id ."' value='F' class='answer' ". ($answer_given == 'F' ? "checked" : " ") . ">"
					   . "<label for='answer_" . $answer_id . "_false' style='margin-left: 5px; color:". $false_color ."'>False ". $false_symbol ."</label>";
					break;
				case self::ESSAY_QUESTION_TYPE:
					echo "\r\n<textarea id='txt_eq_entry' rows='4' name='" . htmlspecialchars($question_id) . "' style='text-align:left;' class='studentEssayQuestion' disabled='true'>". $answer_given ."</textarea>";
					break;
			}
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
			echo "<div class='my-form-builder' id='".self::MATCHING_QUESTION_TYPE."'>";
			echo "\r\n  <h4> Matching Sections </h4>";
			echo "\r\n  <ul class='question_list'>";
			while($statement->fetch()){
				$this->print_section($matching_section_id, $matching_section_description);
			}
			echo "\r\n  </ul>";
		}
		else {
			echo "<div class='my-form-builder' id='".self::MATCHING_QUESTION_TYPE."' style='display:none;'>";
			echo "\r\n  <h4> Matching Sections </h4>";
		}
		echo "\r\n</div>";
	}
	
	public function print_section($matching_section_id, $matching_section_description){
		$statement = $this->db->prepare("SELECT SUM(section_points_received), SUM(section_points_total), section_points_total
										 FROM student_matching_section_points
										 WHERE student_id = ? AND matching_section_id = ?") or die($db->error);
		$statement->bind_param("ii", $this->student_id, $matching_section_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($section_points_received, $section_points_total, $section_points_per);
		$statement->fetch();
		echo "\r\n<li data-section_id='". $matching_section_id ."' class='' data-question-type='". self::MATCHING_QUESTION_TYPE ."'><hr />";
		echo "<div><span>". $matching_section_description ."</span> <span style='float:right' data-points-received='". $section_points_received ."'> ". $section_points_received ." / ". $section_points_total ." pts </span></div>";
		echo "<div><span style='float:right'> (". $section_points_per ." pts each) </span></div>";
		
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

	public function print_matching_questions($matching_section_id){
		$this->question_count = 0;
		$question_type = self::MATCHING_QUESTION_TYPE;
		$question_statement = $this->db->prepare("SELECT mq.matching_question_id, mq.question_text, mq.question_weight, mq.matching_answer_id, ma.matching_answer_id, ma.answer_content, sa.answer_given,
		                                                 (SELECT answer_content
														    FROM matching_answer
														   WHERE matching_answer_id = sa.answer_given) as answer_given_content
												    FROM matching_question mq
												    JOIN matching_answer ma on ma.matching_answer_id = mq.matching_answer_id
												    JOIN student_answer sa on sa.question_id = mq.matching_question_id
												   WHERE mq.matching_section_id = ?
												     AND sa.question_type = ?
												     AND sa.student_id = ?
												   ORDER BY mq.question_number") or die($this->db->error);
		$question_statement->bind_param("isi", $matching_section_id, $question_type, $this->student_id);
		$question_statement->execute();
		$question_statement->store_result();
		$question_statement->bind_result($matching_question_id, $question_text, $question_weight, $matching_answer_id, $correct_answer, $answer_content, $answer_given, $answer_given_content);
		
		echo "\r\n <ol class='matching_questions' data-section-id='". $matching_section_id ."'>";
		while($question_statement->fetch()){
			echo "\r\n <li class='question_item question_list' >";
			echo "\r\n   <span class='question_number'> </span> <span class='question_text' style='display: inline-block;' data-question-id='". $matching_question_id ."' data-matching-answer-id='". $matching_answer_id ."'>". htmlspecialchars($question_text) ."</span>";
			
			$symbol = self::CHECK_MARK;
			if ($answer_given == null) {
				$symbol = self::LEFT_ARROW;
			}
			else if ($answer_given == $correct_answer) {
				$symbol = self::CHECK_MARK;
			}
			else {
				echo "\r\n <span style='color:". self::WRONG_COLOR ."'>". htmlspecialchars($answer_given_content) . " ".self::X_MARK."</span> ";
			}
			echo "\r\n <span style='color:". self::RIGHT_COLOR ."'>". htmlspecialchars($answer_content) . " ". $symbol."</span>";
			echo "\r\n</li>";
			$this->question_count++;
		}
		echo "\r\n </ol>";
		
	}
	
	public function print_matching_answers($matching_section_id){
		$this->answer_count = 0;
		$answer_statement = $this->db->prepare("SELECT matching_answer_id, answer_content
												FROM matching_answer 
												WHERE matching_section_id = ?") or die($db->error);
		$answer_statement->bind_param("i", $matching_section_id);
		$answer_statement->execute();
		$answer_statement->store_result();
		$answer_statement->bind_result($matching_answer_id, $answer_content);
		
		echo "\r\n <ol class='matching_answers' data-section-id='". $matching_section_id ."'>";
		while($answer_statement->fetch()){
			echo "\r\n <li class='answer_item'>";
			echo "\r\n   <span class='answer_text' data-question-id='". $matching_answer_id ."'>". htmlspecialchars($answer_content) ."</span>";
			echo "\r\n </li>";
			$this->answer_count++;
		}
		echo "\r\n </ol>";
	}
}
?>