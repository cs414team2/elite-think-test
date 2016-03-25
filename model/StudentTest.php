<?php
	class StudentTest{
		const CORRECT                       = 'Y';     // Signifies that a question is correct
		const INCORRECT                     = 'N';     // Signifies that a question is incorrect
		const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
		const TRUE_FALSE_QUESTION_TYPE      = 'TF';
		const ESSAY_QUESTION_TYPE           = 'ESSAY';
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
		
		private print_test($user_type){
			$this->db                       = prepare_connection();
			$question_statement       = $this->db->prepare("SELECT question_id, question_text, question_weight FROM question WHERE test_id = ? and question_type = ?") or die($this->db->error);
			$answer_statement   	  = $this->db->prepare("SELECT answer_id, answer_content, is_correct FROM answer WHERE question_id = ?") or die($this->db->error);
			$student_answer_statement = $this->db->prepare("SELECT answer_given FROM student_test_answers WHERE student_id = ? AND test_id = ? AND question_id = ?");
			$question_type            = Test::TRUE_FALSE_QUESTION_TYPE;
			$question_statement->bind_param("is", $test_id, $question_type);
			
			/*********************************************************************************************/
			/*                                     TRUE/FALSE SECTION                                    */
			/*********************************************************************************************/
			// Get the true false questions.
			$question_statement->execute();
			$question_statement->store_result();
			$question_statement->bind_result($question_id, $question_text, $question_weight);
			
			// Print the questions and answers.
			if($question_statement->num_rows > 0){
				echo "\r\n<div class='my-form-builder' id='".Test::TRUE_FALSE_QUESTION_TYPE."'>";
				echo "\r\n  <h4> T/F Questions </h4>";
				echo "\r\n  <ul class='question_list'>";
				while($question_statement->fetch()){
					$this->print_question($question_id, $question_text, $user_type, $question_type, $question_weight);
					
					// Load all possible answers
					$answer_statement->bind_param("i", $question_id);
					$answer_statement->execute();
					$answer_statement->store_result();
					$answer_statement->bind_result($answer_id, $answer_content, $is_correct);
					
					// Load student answers to questions
					$student_answer_statement->bind_param("iii", $user_id, $test_id, $question_id);
					$student_answer_statement->execute();
					$student_answer_statement->store_result();
					$student_answer_statement->bind_result($answer_given);
					$student_answer_statement->fetch();
					
					while($answer_statement->fetch())
						$this->print_answer($is_correct, $answer_content, $question_type, $user_type, $question_id, $answer_id, $answer_given);
					echo "\r\n</li>";
				}
			}
			else{
				echo "\r\n<div class='my-form-builder' id='".Test::TRUE_FALSE_QUESTION_TYPE."' style='display:none;'>";
				echo "\r\n  <h4> T/F Questions </h4>";
				echo "\r\n	<ul class='question_list'>";
			}
			echo "\r\n   </ul>\r\n</div>";
			
			/*********************************************************************************************/
			/*                                MULTIPLE CHOICE SECTION                                    */
			/*********************************************************************************************/
			// Get the multiple choice questions.
			$question_type = Test::MULTIPLE_CHOICE_QUESTION_TYPE;
			$question_statement->execute();
			$question_statement->store_result();
			$question_statement->bind_result($question_id, $question_text, $question_weight);
			
			if($question_statement->num_rows > 0){
				echo "\r\n<div class='my-form-builder' id='".Test::MULTIPLE_CHOICE_QUESTION_TYPE."'>";
				echo "\r\n  <h4> Multiple Choice Questions </h4>";
				echo "\r\n  <ul class='question_list'>";
				while($question_statement->fetch()){
					$this->print_question($question_id, $question_text, $user_type, $question_type, $question_weight);

					// Load all answer options
					$answer_statement->bind_param("i", $question_id);
					$answer_statement->execute();
					$answer_statement->store_result();
					$answer_statement->bind_result($answer_id, $answer_content, $is_correct);
					
					// Load student answers to questions
					$student_answer_statement->bind_param("iii", $user_id, $test_id, $question_id);
					$student_answer_statement->execute();
					$student_answer_statement->store_result();
					$student_answer_statement->bind_result($answer_given);
					$student_answer_statement->fetch();
					
					echo "<ol style='list-style-type:lower-alpha; margin-left: 20px; margin-bottom: 1px; font-family Segoe UI Light;'>";
					while($answer_statement->fetch())
						$this->print_answer($is_correct, $answer_content, $question_type, $user_type, $question_id, $answer_id, $answer_given);
					echo "</ol>";
					echo "\r\n</li>";
				}
			}
			else {
				echo "\r\n  <div class='my-form-builder' id='".Test::MULTIPLE_CHOICE_QUESTION_TYPE."' style='display:none;'>";
				echo "\r\n  <h4> Multiple Choice Questions </h4>";
				echo "\r\n  <ul class='question_list'>";
			}
			echo "\r\n   </ul>\r\n</div>";

			/*********************************************************************************************/
			/*                                        ESSAY SECTION                                      */
			/*********************************************************************************************/
			// Get the essay questions.
			$question_type = Test::ESSAY_QUESTION_TYPE;
			$question_statement->execute();
			$question_statement->store_result();
			$question_statement->bind_result($question_id, $question_text, $question_weight);
			
			// Print the questions and answers.
			if($question_statement->num_rows > 0){
				echo "\r\n<div class='my-form-builder' id='".Test::ESSAY_QUESTION_TYPE."'>";
				echo "\r\n  <h4> Essay Questions </h4>";
				echo "\r\n  <ul class='question_list'>";
				while($question_statement->fetch()){
					$this->print_question($question_id, $question_text, $user_type, $question_type, $question_weight);
					
					// Load student answer options
					$answer_statement->bind_param("i", $question_id);
					$answer_statement->execute();
					$answer_statement->store_result();
					$answer_statement->bind_result($answer_id, $answer_content, $is_correct);
					
					// Load student answers to questions
					$student_answer_statement->bind_param("iii", $user_id, $test_id, $question_id);
					$student_answer_statement->execute();
					$student_answer_statement->store_result();
					$student_answer_statement->bind_result($answer_given);
					$student_answer_statement->fetch();
					
					while($answer_statement->fetch())
						$this->print_answer($is_correct, $answer_content, $question_type, $user_type, $question_id, $answer_id, $answer_given);
					echo "\r\n</li>";
				}
			}
			else {
				echo "<div class='my-form-builder' id='".Test::ESSAY_QUESTION_TYPE."' style='display:none;'>";
				echo "\r\n  <h4> Essay Questions </h4>";
				echo "\r\n  <ul class='question_list'>";
			}
			echo "\r\n   </ul>\r\n</div>";
		}
		
		public function print_question($question_id, $question_text, $user_type, $question_type, $question_weight){
			echo "\r\n<li id='".$question_id."' style='font-weight: bold; padding: 5px; border: 1px solid black; margin-top: 8px' data-question-type='". $question_type . "'>";
			echo "\r\n   <div><span class='question_number'></span> &nbsp;<span class='question_text'>" . htmlspecialchars($question_text) ."</span></div>";
		}
		
		public function print_answer($is_correct, $answer_content, $question_type, $user_type, $question_id, $answer_id, $answer_given){
			switch($question_type){
			case self::MULTIPLE_CHOICE_QUESTION_TYPE:
				
				if($answer_given != null)
					if($answer_given == $answer_id)
						$color = ($is_correct == 'Y' ? ' color:#47CC7A;' : ' color:CC1C11;');
					else
						$color = ($is_correct == 'Y' ? ' color:#47CC7A;' : " ");
				else
					$color = ($is_correct == 'Y' ? ' color:#47CC7A;' : " ");
				
				echo "\r\n<li>
							<input type='radio' id='answer_". $answer_id ."' name='". $question_id ."' value='". $answer_id ."' class='answer' ". ($answer_given == $answer_id ? "checked" : " ") . "'>
							<label for='answer_". $answer_id ."' style='". $color ."'>". htmlspecialchars($answer_content) ."</label>
						  </li>";
				break;
			case self::TRUE_FALSE_QUESTION_TYPE:
				if($answer_content = 'T')
					if($answer_given == $answer_content){
						$true_color = ' color:#47CC7A;';
						$false_color = ' ';
					}
					else{
						$true_color = ' color:#47CC7A;';
						$false_color = ' color:#CC1C11;';
					}
				else{
					if($answer_given == $answer_content){
						$false_color = ' color:#47CC7A;';
						$true_color = ' ';
					}
					else{
						$false_color = ' color:#47CC7A;';
						$true_color = ' color:#CC1C11;';
					}
				}
				echo "\r\n
					  <input type='radio' id='answer_". $answer_id ."_true' name='". $question_id ."' value='T' class='answer' ". ($answer_given == 'T' ? "checked" : " ") . ">" 
				   . "<label for='answer_" . $answer_id . "_true' style='margin-left: 5px;". $true_color ."'>True</label>
					  \r\n<input type='radio' id='answer_". $answer_id ."_false' name='". $question_id ."' value='F' class='answer' ". ($answer_given == 'F' ? "checked" : " ") . ">"
				   . "<label for='answer_" . $answer_id . "_false' style='margin-left: 5px;". $false_color ."'>False</label>";
				break;
			case self::ESSAY_QUESTION_TYPE:
				echo "\r\n<textarea id='txt_eq_entry' rows='4' name='" . htmlspecialchars($question_id) . "' style='text-align:left;' class='studentEssayQuestion'>". $answer_given ."</textarea>";
				break;
		}
		}
	}
?>