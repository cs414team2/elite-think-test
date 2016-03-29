<?php
	class StudentTest{
		const CORRECT                       = 'Y';     // Signifies that a question is correct
		const INCORRECT                     = 'N';     // Signifies that a question is incorrect
		const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
		const TRUE_FALSE_QUESTION_TYPE      = 'TF';
		const ESSAY_QUESTION_TYPE           = 'ESSAY';
		const RIGHT_COLOR                   = ' color:#47CC7A;';
		const WRONG_COLOR                   = ' color:#CC1C11;';
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
		
		public function __construct($test_id, $student_id){
			$this->test_id = $test_id;
			$this->student_id = $student_id;
			$this->db = $this->prepare_connection();
		}
		
		private function prepare_connection(){
			return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
		}
		
		public function print_test($user_type){
			$question_statement       = $this->db->prepare("SELECT question_id, question_text, question_weight FROM question WHERE test_id = ? and question_type = ?") or die($this->db->error);
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
		}
		
		// Print the question
		public function print_question($question_id, $question_text, $user_type, $question_type, $question_weight, $points_received, $student_answer_id){
			if($question_type == self::ESSAY_QUESTION_TYPE){
				echo "\r\n<li id='".$question_id."' style='font-weight: bold; padding: 5px; border: 1px solid black; margin-top: 8px' data-question-type='". $question_type . "' data-points-received='". $points_received ."' data-student-answer-id='". $student_answer_id ."'>";
				echo "\r\n   <div><span class='question_number'></span> &nbsp;<span class='question_text'>" . htmlspecialchars($question_text) ."</span><span style='float: right;'> <input type='number' id='txt_essay_points_" . $question_id . "' value='". $question_weight ."' min='0' max='". $question_weight ."' style='width:3.5em; margin-bottom:1em; margin-top:1em;'><label for='txt_essay_points_" . $question_id . "' class='question_weight'> / ". $question_weight ." Pt(s)</label></span></div>";
			}
			else{
				echo "\r\n<li id='".$question_id."' style='font-weight: bold; padding: 5px; border: 1px solid black; margin-top: 8px' data-question-type='". $question_type . "' data-points-received='". $points_received ."'>";
				echo "\r\n   <div><span class='question_number'></span> &nbsp;<span class='question_text'>" . htmlspecialchars($question_text) ."</span><span style='float: right;'>&nbsp;<span class='question_weight' >". $points_received ."</span> Point(s)</span></div>";
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
					$color = ($is_correct == 'Y' ? self::RIGHT_COLOR : " ");
					$symbol = ($color == self::RIGHT_COLOR ? self::LEFT_ARROW : " ");
				}
				
				echo "\r\n<li>
							<input type='radio' id='answer_". $answer_id ."' name='". $question_id ."' value='". $answer_id ."' class='answer' ". ($answer_given == $answer_id ? "checked" : " ") . ">
							<label for='answer_". $answer_id ."' style='". $color ."'>". htmlspecialchars($answer_content) . $symbol . "</label>
						  </li>";
				break;
			case self::TRUE_FALSE_QUESTION_TYPE:
				
				if($answer_content == 'T')
					if($answer_given == $answer_content){
						$true_color  = self::RIGHT_COLOR;
						$false_color = ' ';
						$true_symbol = self::CHECK_MARK;
						$false_symbol = ' ';
					}
					elseif($answer_given == null){
						$true_color  = self::RIGHT_COLOR;
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
				else{
					if($answer_given == $answer_content){
						$false_color = self::RIGHT_COLOR;
						$true_color = ' ';
						$false_symbol = self::CHECK_MARK;
						$true_symbol = ' ';
					}
					elseif($answer_given == null){
						$false_color = self::RIGHT_COLOR;
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
				}
				echo "\r\n
					  <input type='radio' id='answer_". $answer_id ."_true' name='". $question_id ."' value='T' class='answer' ". ($answer_given == 'T' ? "checked" : " ") . ">" 
				   . "<label for='answer_" . $answer_id . "_true' style='margin-left: 5px;". $true_color ."'>True ". $true_symbol ."</label>
					  \r\n<input type='radio' id='answer_". $answer_id ."_false' name='". $question_id ."' value='F' class='answer' ". ($answer_given == 'F' ? "checked" : " ") . ">"
				   . "<label for='answer_" . $answer_id . "_false' style='margin-left: 5px;". $false_color ."'>False ". $false_symbol ."</label>";
				break;
			case self::ESSAY_QUESTION_TYPE:
				echo "\r\n<textarea id='txt_eq_entry' rows='4' name='" . htmlspecialchars($question_id) . "' style='text-align:left;' class='studentEssayQuestion'>". $answer_given ."</textarea>";
				break;
		}
		}
	}
?>