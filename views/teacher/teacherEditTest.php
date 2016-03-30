<?php
require_once('model/Teacher.php');
include_once('model/Test.php');

if (isset($_SESSION['credentials'], $_REQUEST['test_id'])) {
	$test_id = $_REQUEST['test_id'];
	$test = new Test($test_id);
	
	if ($_SESSION['credentials']->is_teacher() && $test->verify_test_access($_SESSION['credentials']->get_user_id(), $_SESSION['credentials']->get_access_level())) {
		echo '
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="controllers/test_editor.js"></script>
		
		<section id="main" class="wrapper style1">
		
		    <script language="javascript">
				var test_id = ' . $test_id . ';
			</script>
			
			<script>
				$(function() {
					var dateIsSet = '.$test->active_date_is_set().'
					$( "#activeDatepicker" ).datepicker({
						onSelect: update_time_info
					});
					if(dateIsSet == true){
						$( "#activeDatepicker" ).datepicker("setDate",new Date("'.$test->get_date_active().'"));
					}
					else{
						// Defaults to be active the next day
						$( "#activeDatepicker" ).datepicker({ minDate: 0, defaultDate: +1 });
						$( "#activeDatepicker" ).datepicker("setDate", new Date().getDay+1);
					}
				});
			</script>
			
			<script>
				$(function() {
					var dateIsSet = '.$test->due_date_is_set().'
					$( "#datepicker" ).datepicker({
						onSelect: update_time_info
					});
					if(dateIsSet == true){
						$( "#datepicker" ).datepicker("setDate",new Date("'.$test->get_date_due().'"));
					}
					else{
						// Defaults to being due 7 days after date making
						$( "#datepicker" ).datepicker({ minDate: 0, defaultDate: +7 });
						$( "#datepicker" ).datepicker("setDate", new Date().getDay+7);
					}
				});
			</script>
			
			<header class="major">
			</header>
			<div class="testContainer">
				<div id="sidebar" style="text-align:center">
					<section style="text-align:center">
						<img id="testpageIconImage" src="images/eliteicon.png" width="100" height="110" alt="elite logo"/>
						<br /><br />
						<h5>Time Limit:</h5>
						<p style="color:white;">
							<input id="txt_time_limit" type="number" name="timeLimit" value="50" style="text-align: center; width: 60px;" min="0">
							minutes
						</p>
						<p style="color:white;">
							Active Date: 
							<input type="text" style="color: black;" id="activeDatepicker">
						<button id="btn_activate" class="show_hide button small" style="padding: 0 .5em; height: 2em; line-height: 0em; margin-top: 5px;" >Activate Now</button>
						</p>
						<p style="color:white;">
							Date Due: 
							<input type="text" style="color: black;" id="datepicker">
						</p>
						<button id="btn_open_TFDialog"class="show_hide button small fit" style="padding: 0 .5em; height: 2em; line-height: 0em;" rel="#slidingQ_2" >True / False</button>
						<button id="btn_open_MCDialog" class="show_hide button small fit" style="padding: 0 .5em; height: 2em; line-height: 0em;" rel="#slidingQ_1" >Multiple Choice</button>
						<button id="btn_open_EssayDialog" class="show_hide button small fit" style="padding: 0 .5em; height: 2em; line-height: 0em;" rel="#slidingQ_3" >Essay</button>
						<button id="btn_open_MatchDialog" class="show_hide button small fit" style="padding: 0 .5em; height: 2em; line-height: 0em;" rel="#slidingQ_3" >Matching</button>
						<br />
						
						
					</section>
				</div>

				<div class="smallScreenTestDiv" style="float:right;">
					<h2 style="padding:10px;">'. $test->get_class_name() . ' - Test ' . $test->get_test_number() . '</h2>
					<section id="testView">
						<div id="test_content" align="left">
							<div class="my-form-builder">
								<div class="loader">Loading...</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</section>
		
		<div id="dlg_tf" class="dialog_box" title="True/False Question Entry" style="background-color:white; text-align: center;">
			<form>
				<textarea id="txt_tfq_entry" rows="3" placeholder="Enter a True/False Question"
					name="txt_tfq_entry" class="questionStyle"></textarea>
				<br />
				<input type="radio" id="rb_answer_true" name="rb_answer_tf" checked>
				<label for="rb_answer_true" class="questionLabel">True</label>
									
				<input type="radio" id="rb_answer_false" name="rb_answer_tf" >
				<label for="rb_answer_false" class="questionLabel">False</label>
				<br />
				<br />
				<input type="number" id="txt_tf_weight" value="1" min="1" max="999" style="width: 70px; text-align: center;" class="weight_entry">
				<label for="txt_tf_weight">Point(s)</label>
				<br />
				<p id="err_empty_tf" style="display: none; color: red;">
					Please fill in all fields...
				</p>
				<br />
				
				<ul class="actions">
					<li><input id="btn_add_tf" type="button" class="button special" value="Submit" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
					<li><input type="reset" value="Reset" class="alt button special reset" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
				</ul>
			</form>
		</div>
		
		<div id="dlg_mc" class="dialog_box" title="Multiple Choice Question Entry" style="background-color:white; text-align: center;">
			<form>
				<textarea id="txt_mcq_entry" rows="2" placeholder="Enter a Multiple Choice Question"
					name="txt_mcq_entry" class="questionStyle" ></textarea>
				<br />
				
				<label for="mcAnswer1" class="questionLabel"> A)</label>
				<input id="mcAnswer1" type="text" name="mcAnswer1" class="questionStyle mc_answer">
				<input type="radio" id="rb_is_answer_a" name="rb_is_answer" checked>
				<label for="rb_is_answer_a" class="questionLabel">Answer</label>
				<br/><br />
				
				<label for="mcAnswer2" class="questionLabel"> B)</label>
				<input id="mcAnswer2" type="text" name="mcAnswer2" class="questionStyle mc_answer">
				<input type="radio" id="rb_is_answer_b" name="rb_is_answer" >
				<label for="rb_is_answer_b" class="questionLabel">Answer</label>
				<br/><br />
				
				<label for="mcAnswer3" class="questionLabel"> C)</label>
				<input id="mcAnswer3" type="text" name="mcAnswer3" class="questionStyle mc_answer">
				<input type="radio" id="rb_is_answer_c" name="rb_is_answer" >
				<label for="rb_is_answer_c" class="questionLabel">Answer</label>
				<br/><br />
				
				<label for="mcAnswer4" class="questionLabel"> D)</label>
				<input id="mcAnswer4" type="text" name="mcAnswer4" class="questionStyle mc_answer">
				<input type="radio" id="rb_is_answer_d" name="rb_is_answer">
				<label for="rb_is_answer_d" class="questionLabel">Answer</label>
				<br/>
				<br />
				<input type="number" id="txt_mc_weight" value="1" min="1" max="999" style="width: 70px; text-align: center;" class="weight_entry">
				<label for="txt_mc_weight">Point(s)</label>
				<br />
				<br />
				<p id="err_empty_mc" style="display: none; color: red;">
					Please fill in all fields...
				</p>
				<input id="btn_add_mc" type="button" class="button special" value="Submit" style="padding: 0 .5em; height: 2em; line-height: 0em;"/>
				<input type="reset" value="Reset" class="alt button special reset" style="padding: 0 .5em; height: 2em; line-height: 0em;"/>
			</form>
		</div>
		<div id="dlg_essay" class="dialog_box" title="Essay Question Entry" style="background-color:white; text-align: center;">
			<form>
				<textarea id="txt_eq_entry" rows="4" placeholder="Enter an Essay Question"
				name="txt_eq_entry" class="questionStyle"></textarea>
				<textarea id="txt_essay_answer" rows="4" placeholder="Enter an answer"
				name="txt_essay_answer" class="questionStyle"></textarea>
				<br />
				<input type="number" id="txt_essay_weight" value="1" min="1" max="999" style="width: 70px; text-align: center;" class="weight_entry">
				<label for="txt_essay_weight">Point(s)</label>
				<br />
				<br />
				<p id="err_empty_eq" style="display: none; color: red;">
					Please fill in all fields...
				</p>
				<ul class="actions">
					<li><input id="btn_add_essay" type="button" value="Submit" class="button special" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
					<li><input type="reset" value="Reset" class="alt button special reset" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
				</ul>
			</form>
		</div>
		<div id="dlg_match" class="dialog_box" title="Matching Section Entry" style="background-color:white; text-align: center;">
			<form>
				<textarea id="txt_matchq_entry" rows="2" placeholder="Enter a Matching Section Description"
					name="txt_matchq_entry" class="questionStyle" style="margin-bottom: 5px; width: 100%;"></textarea>
				<div style="display: inline-block; ">
					Questions
					<div id="area_matching_questions">
						<div><input class="txt_match_question" type="text" style="display: inline;"/><select class="ddl_matched_answer" style="width: 30px; display: inline; "></select></div>
						<div><input class="txt_match_question" type="text" style="display: inline;"/><select class="ddl_matched_answer"  style="width: 30px; display: inline; "></select></div>
						<div><input class="txt_match_question" type="text" style="display: inline;"/><select class="ddl_matched_answer"  style="width: 30px; display: inline; "></select></div>
						<div><input class="txt_match_question" type="text" style="display: inline;"/><select class="ddl_matched_answer"  style="width: 30px; display: inline; "></select></div>
						<div><input class="txt_match_question" type="text" style="display: inline;"/><select class="ddl_matched_answer"  style="width: 30px; display: inline; "></select></div>
						<div><input class="txt_match_question" type="text" style="display: inline;"/><select class="ddl_matched_answer"  style="width: 30px; display: inline; "></select></div>
						<div><input class="txt_match_question" type="text" style="display: inline;"/><select class="ddl_matched_answer"  style="width: 30px; display: inline; "></select></div>
						<div><input class="txt_match_question" type="text" style="display: inline;"/><select class="ddl_matched_answer"  style="width: 30px; display: inline; "></select></div>
						<div><input class="txt_match_question" type="text" style="display: inline;"/><select class="ddl_matched_answer"  style="width: 30px; display: inline; "></select></div>
						<div><input class="txt_match_question" type="text" style="display: inline;"/><select class="ddl_matched_answer"  style="width: 30px; display: inline; "></select></div>
					</div>
					<p id="err_empty_match_question" style="display: none; color: red;">
						Please enter a question...
					</p>
					<p id="err_unlinked_match_question" style="display: none; color: red;">
						Each question must link to an answer...
					</p>
				</div>
				<div style="display: inline-block; ">
					Answers
					<div id="area_matching_answers">
						<div> 1<input class="txt_match_answer" type="text" style="display: inline;"/></div>
						<div> 2<input class="txt_match_answer" type="text" style="display: inline;"/></div>
						<div> 3<input class="txt_match_answer" type="text" style="display: inline;"/></div>
						<div> 4<input class="txt_match_answer" type="text" style="display: inline;"/></div>
						<div> 5<input class="txt_match_answer" type="text" style="display: inline;"/></div>
						<div> 6<input class="txt_match_answer" type="text" style="display: inline;"/></div>
						<div> 7<input class="txt_match_answer" type="text" style="display: inline;"/></div>
						<div> 8<input class="txt_match_answer" type="text" style="display: inline;"/></div>
						<div> 9<input class="txt_match_answer" type="text" style="display: inline;"/></div>
						<div>10<input class="txt_match_answer" type="text" style="display: inline;"/></div>
					</div>
					<p id="err_empty_match_answer" style="display: none; color: red;">
						Please enter an answer...
					</p>
				</div>
				<br/>
				<br />
				<input type="number" id="txt_match_weight" value="1" min="1" max="999" style="width: 70px; text-align: center;" class="weight_entry">
				<label for="txt_match_weight">Point(s) per question</label>
				<br />
				<br />
				<p id="err_empty_match" style="display: none; color: red;">
					Please fill in all fields...
				</p>
				<input id="btn_add_match_section" type="button" class="button special" value="Submit" style="padding: 0 .5em; height: 2em; line-height: 0em;"/>
				<input type="reset" value="Reset" class="alt button special reset" style="padding: 0 .5em; height: 2em; line-height: 0em;"/>
			</form>
		</div>
	
		';
	}
	else {
		echo "<script>window.location = './404.php'; </script>";
	}
}
else {
	echo "<script>window.location = './404.php'; </script>";
}
?>









