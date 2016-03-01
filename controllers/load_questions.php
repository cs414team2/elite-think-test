<?php
	function prepare_connection(){
		return new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");
	}
	
	if(isset $_REQUEST["test_id"]){
		$test_id = $_REQUEST["test_id"];
		
		$db = $this->prepare_connection();
		$statement = $db->prepare("SELECT question_id, question_text FROM question WHERE test_id = ?");
		$statement->bind_param("i", $test_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($question_id, $question_text);
		
		if($statement->num_rows > 0){
			while($statement->fetch()){
				echo "\r\n<div id='".$question_id."'style='font-weight: bold; padding: 5px'>";
				echo "\r\n   <div><span class='question_number'></span> &nbsp;" . $question_text ."</div>";

				// Make these work properly after pulling in answers as well.
				/*if ($question_type == TRUE_FALSE_QUESTION_TYPE) {
					echo "\r\n<div> True or false</div>";
				}
				elseif ($question_type == MULTIPLE_CHOICE_QUESTION_TYPE) {
					echo "\r\n
							  <div style='display: inline-block; max-width: 50%; float:left;'> This is a possible answer </div> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
							  <div style='display: inline-block; max-width: 50%;'>    This is a possible answer   </div>	<br/>
							  <div style='display: inline-block; max-width: 50%; float:left;'>    This is a possible answer   </div>  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
							  <div style='display: inline-block; max-width: 50%;'>    This is a possible answer </div>";														
				}*/
					
				echo "\r\n    <div class='rightAlignInDiv'  style='display: inline-block; max-width: 50%;'>";
				echo "\r\n	    <button style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Edit</button>";
				echo "\r\n	    <button onclick='delete_question(this.parentElement)' style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Delete</button>";
				echo "\r\n    </div>";
				echo "\r\n</div>";
			}
		}
	}
?>