<?php
require_once('model/Teacher.php');
include_once('model/Test.php');

if (isset($_SESSION['credentials'], $_REQUEST['test_id'])) {
	$test_id = $_REQUEST['test_id'];
	$test = new Test($test_id);
	
	if ($_SESSION['credentials']->is_teacher() && $test->verify_test_access($_SESSION['credentials']->get_user_id(), $_SESSION['credentials']->get_access_level())) {
		// PUT HTML HERE!
		echo '
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="controllers/test_editor.js"></script>
		
		<section id="main" class="wrapper style1">
		
		    <script language="javascript">
			var test_id = ' . $test_id . ';
			function setRadio(obj)
			{
				if(obj.checked == true)
					obj.checked = false;
				else
					obj.checked = true
			}
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
						</p>
						<p style="color:white;">
							Date Due: 
							<input type="text" style="color: black;" id="datepicker">
						</p>
						<button id="btn_open_TFDialog"class="show_hide button small fit" style="padding: 0 .5em; height: 2em; line-height: 0em;" rel="#slidingQ_2" >True / False</button>
						<button id="btn_open_MCDialog" class="show_hide button small fit" style="padding: 0 .5em; height: 2em; line-height: 0em;" rel="#slidingQ_1" >Multiple Choice</button>
						<button id="btn_open_EssayDialog" class="show_hide button small fit" style="padding: 0 .5em; height: 2em; line-height: 0em;" rel="#slidingQ_3" >Essay</button>
						<br />
						<button id="submitTest "class="show_hide button small fit" style="padding: 0 .5em; height: 2em; line-height: 0em;" >Submit Test</button>
						
						
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
		
		<div id="dlg_tf" title="True/False Question Entry" style="background-color:white; text-align: center;">
			<form>
				<textarea id="txt_tfq_entry" rows="3" placeholder="Enter a True/False Question"
					name="txt_tfq_entry" class="questionStyle"></textarea>
				<p id="err_empty_tf" style="display: none; color: red;">
					Please fill in a question...
				</p>
				<br />
				
				<input type="radio" id="rb_answer_true" name="rb_answer_tf" checked>
				<label for="rb_answer_true" class="questionLabel">True</label>
									
				<input type="radio" id="rb_answer_false" name="rb_answer_tf" >
				<label for="rb_answer_false" class="questionLabel">False</label>
				<br /><br />
				
				<ul class="actions">
					<li><input id="btn_add_tf" type="button" class="button special" value="Submit" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
					<li><input type="reset" value="Reset" class="alt button special reset" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
				</ul>
			</form>
		</div>
		
		<div id="dlg_mc" title="Multiple Choice Question Entry" style="background-color:white; text-align: center;">
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
				<br/><br />
				<p id="err_empty_mc" style="display: none; color: red;">
					Please fill in all fields...
				</p>
				<input id="btn_add_mc" type="button" class="button special" value="Submit" style="padding: 0 .5em; height: 2em; line-height: 0em;"/>
				<input type="reset" value="Reset" class="alt button special reset" style="padding: 0 .5em; height: 2em; line-height: 0em;"/>
			</form>
		</div>
		
		<div id="dlg_essay" title="Essay Question Entry" style="background-color:white; text-align: center;">
			<form>
				<textarea id="txt_eq_entry" rows="4" placeholder="Enter an Essay Question"
				name="txt_eq_entry" class="questionStyle"></textarea>
				<textarea id="txt_essay_answer" rows="4" placeholder="Enter an answer"
				name="txt_essay_answer" class="questionStyle"></textarea>
				<br />
				<p id="err_empty_eq" style="display: none; color: red;">
					Please fill in a question...
				</p>
				<ul class="actions">
					<li><input id="btn_add_essay" type="button" value="Submit" class="button special" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
					<li><input type="reset" value="Reset" class="alt button special reset" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
				</ul>
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









