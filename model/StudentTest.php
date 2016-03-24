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
		        // Because there are echo statements, we should call this "print_test".
		private get_test($u_type){
			$/*Do you want to change all of these to $this->????*/db                 = prepare_connection();
			$question_statement       = $db->prepare("SELECT question_id, question_text FROM question WHERE test_id = ? and question_type = ?") or die($db->error);
			$answer_statement   	  = $db->prepare("SELECT answer_id, answer_content, is_correct FROM answer WHERE question_id = ?") or die($db->error);
			$student_answer_statement = $db->prepare("SELECT answer_given FROM student_test_answers WHERE student_id = ? AND test_id = ? AND question_id = ?");
			$question_type            = Test::TRUE_FALSE_QUESTION_TYPE;
			$user_type                = $u_type;
			$question_statement->bind_param("is", $test_id, $question_type);
			
			/*********************************************************************************************/
			/*                                     TRUE/FALSE SECTION                                    */
			/*********************************************************************************************/
			// Get the true false questions.
			$question_statement->execute();
			$question_statement->store_result();
			$question_statement->bind_result($question_id, $question_text);
			
			// Print the questions and answers.
			if($question_statement->num_rows > 0){
				echo "\r\n<div class='my-form-builder' id='".Test::TRUE_FALSE_QUESTION_TYPE."'>";
				echo "\r\n  <h4> T/F Questions </h4>";
				echo "\r\n  <ul class='question_list'>";
				while($question_statement->fetch()){
					$this->print_question($question_id, $question_text, $user_type, $question_type);
					
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
			$question_statement->bind_result($question_id, $question_text);
			
			if($question_statement->num_rows > 0){
				echo "\r\n<div class='my-form-builder' id='".Test::MULTIPLE_CHOICE_QUESTION_TYPE."'>";
				echo "\r\n  <h4> Multiple Choice Questions </h4>";
				echo "\r\n  <ul class='question_list'>";
				while($question_statement->fetch()){
					$this->print_question($question_id, $question_text, $user_type, $question_type);

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
			$question_statement->bind_result($question_id, $question_text);
			
			// Print the questions and answers.
			if($question_statement->num_rows > 0){
				echo "\r\n<div class='my-form-builder' id='".Test::ESSAY_QUESTION_TYPE."'>";
				echo "\r\n  <h4> Essay Questions </h4>";
				echo "\r\n  <ul class='question_list'>";
				while($question_statement->fetch()){
					$this->print_question($question_id, $question_text, $user_type, $question_type);
					
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
	}
?>