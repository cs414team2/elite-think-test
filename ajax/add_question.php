<?php
	// Make sure these constants match up with controllers/test_editor.js !
	const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
	const TRUE_FALSE_QUESTION_TYPE = 'TF';
	const ESSAY_QUESTION_TYPE = 'ESSAY';

	if(isset($_REQUEST['test_id'], $_REQUEST['question_type'], $_REQUEST['question_text'], $_REQUEST['question_weight'], $_REQUEST['answers'])) {

		$test_id         = $_REQUEST['test_id'];
		$question_type   = $_REQUEST['question_type'];
		$question_text   = ucfirst(trim($_REQUEST['question_text']));
		$question_weight = $_REQUEST['question_weight'];
		
		$eliteConnection = new mysqli("csweb.studentnet.int", "team2_cs414", "t2CS414", "cs414_team2");

		$eliteConnection->query("SET @question_id = 0")                                      or die($eliteConnection->error);
				
		$addStatement = $eliteConnection->prepare("CALL add_question(?, ?, ?, ?, @question_id)") or die($eliteConnection->error);
		$addStatement->bind_param("ssii", $question_text, $question_type, $test_id, $question_weight) 			   or die($addStatement->error);
		$addStatement->execute()                                                                                   or die($addStatement->error);

		$addResult = $eliteConnection->query("SELECT @question_id as question_id");
		$questionInfo = $addResult->fetch_assoc();
		
		echo "\r\n<div id='".$questionInfo['question_id']."'style='font-weight: bold; padding: 5px; border: 1px solid black;'>";
		echo "\r\n   <div><span class='question_number'></span> &nbsp;" . $question_text ."</div>";
		
		echo "\r\n    <div class='rightAlignInDiv'  style='display: inline-block; max-width: 50%;'>";
		echo "\r\n	    <button style='padding: 0.5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Edit</button>";
		echo "\r\n	    <button onclick='delete_question(this.parentElement.parentElement)' style='padding: 0.5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Delete</button>";
		echo "\r\n    </div>";
		
		// Make these work properly after pulling in answers as well.
		if ($question_type == TRUE_FALSE_QUESTION_TYPE) {
			echo "\r\n<div> True or false</div>";
		}
		elseif ($question_type == MULTIPLE_CHOICE_QUESTION_TYPE) {
			echo "\r\n
			          <div style='display: inline-block; max-width: 50%; float:left;'> This is a possible answer </div> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
				      <div style='display: inline-block; max-width: 50%;'>    This is a possible answer   </div>	<br/>
				      <div style='display: inline-block; max-width: 50%; float:left;'>    This is a possible answer   </div>  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
				      <div style='display: inline-block; max-width: 50%;'>    This is a possible answer </div>";														
		}
			
		echo "\r\n</div>";
		//foreach($_REQUEST['answers'] as $answer) {
		//	echo "bob";//$answer['content'] . $answer['is_correct'];
		//}
	}
?>