<?php
	function prepare_connection(){
		return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
	}
	
	if(isset($_REQUEST["test_id"])){
		$test_id = $_REQUEST["test_id"];
		$alphabet = range('a', 'z');
		
		$db = prepare_connection();
		$question_statement = $db->prepare("SELECT question_id, question_text, question_type FROM question WHERE test_id = ?");
		$question_statement->bind_param("i", $test_id);
		$question_statement->execute();
		$question_statement->store_result();
		$question_statement->bind_result($question_id, $question_text, $question_type);
		
		if($question_statement->num_rows > 0){
			while($question_statement->fetch()){
				// Counts number of answers printed for the question
				$count = 0;
				
				echo "\r\n<div id='".$question_id."'style='font-weight: bold; padding: 5px; border: 1px solid black'>";
				echo "\r\n   <div><span class='question_number'></span> &nbsp;" . $question_text ."</div>";

				echo "\r\n    <div class='rightAlignInDiv'  style='display: inline-block; max-width: 50%;'>";
				echo "\r\n	    <button style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Edit</button>";
				echo "\r\n	    <button onclick='delete_question(this.parentElement)' style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Delete</button>";
				echo "\r\n    </div>";
				
				$answer_statement = $db->prepare("SELECT answer_id, answer_content, is_correct FROM answer WHERE question_id = ?");
				$answer_statement->bind_param("i", $question_id);
				$answer_statement->execute();
				$answer_statement->store_result();
				$answer_statement->bind_result($answer_id, $answer_content, $is_correct);
				if($answer_statement->num_rows > 0){
					while($answer_statement->fetch()){
						// Make these work properly after pulling in answers as well.
						//if ($question_type == TRUE_FALSE_QUESTION_TYPE) {
							echo "\r\n<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$alphabet[$count]. ")&nbsp;".$answer_content."</div>";
						//}
						/*elseif ($question_type == MULTIPLE_CHOICE_QUESTION_TYPE) {
							echo "\r\n
									  <div style='display: inline-block; max-width: 50%; float:left;'> This is a possible answer </div> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
									  <div style='display: inline-block; max-width: 50%;'>    This is a possible answer   </div>	<br/>
									  <div style='display: inline-block; max-width: 50%; float:left;'>    This is a possible answer   </div>  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
									  <div style='display: inline-block; max-width: 50%;'>    This is a possible answer </div>";														
						}*/
						$count++;
					}
				}
				echo "\r\n</div> </br>";
			}
		}
	}
?>