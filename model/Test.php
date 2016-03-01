<?php
class Test{
	const CORRECT   = 'Y';
	const INCORRECT = 'N';
	const MULTIPLE_CHOICE_QUESTION_TYPE = 'MC';
	const TRUE_FALSE_QUESTION_TYPE = 'TF';
	const ESSAY_QUESTION_TYPE = 'ESSAY';
	
	private $alphabet;
	
	public function __construct(){
		$this->alphabet = range('a', 'z');
	}
	
	public function print_question($question_id, $question_text){
		echo "\r\n<div id='".$question_id."'style='font-weight: bold; padding: 5px; border: 1px solid black'>";
		echo "\r\n   <div><span class='question_number'></span> &nbsp;" . $question_text ."</div>";

		echo "\r\n    <div class='rightAlignInDiv'  style='display: inline-block; max-width: 50%;'>";
		echo "\r\n	    <button style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Edit</button>";
		echo "\r\n	    <button onclick='delete_question(this.parentElement.parentElement)' style='padding: 0 .5em; height: 2em; line-height: 0em;' href='#' class='button special small'>Delete</button>";
		echo "\r\n    </div>";
	}
	
	public function print_answer($is_correct, $count, $answer_content, $question_type){
		switch($question_type){
			case self::MULTIPLE_CHOICE_QUESTION_TYPE:
				if($is_correct == self::CORRECT)
					echo "\r\n<div style='color:#47CC7A'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$this->alphabet[$count]. ")&nbsp;".$answer_content."</div>";
				else
					echo "\r\n<div style='color:#CC1C11'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$this->alphabet[$count]. ")&nbsp;".$answer_content."</div>";
				break;
			case self::TRUE_FALSE_QUESTION_TYPE:
				echo "\r\n<p style='color:#47CC7A'>&nbsp;".$answer_content."</p>";
				break;
			case self::ESSAY_QUESTION_TYPE:
				echo "\r\n<div style='color:#47CC7A'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Essay Question</div>";
				break;
		}
	}
}
?>