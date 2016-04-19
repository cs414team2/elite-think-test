<?php
require_once('model/Teacher.php');
include_once('model/Test.php');

if (isset($_SESSION['credentials'], $_REQUEST['test_id'])) {
	$test_id = $_REQUEST['test_id'];
	$test = new Test($test_id);
	
	if ($_SESSION['credentials']->is_teacher() && $test->verify_test_access($_SESSION['credentials']->get_user_id(), $_SESSION['credentials']->get_access_level())) {
		echo '
		<link rel="stylesheet" href="css/jquery-ui-1.11.4.custom/jquery-ui.css">
		<script src="controllers/test_editor.js"></script>
		
		<section id="main" class="wrapper style1">
		
		    <script language="javascript">
				var test_id = ' . $test_id . ';
			</script>
			
			<script>
				$(function() {
					var dateIsSet = '.$test->active_date_is_set().'
					$( "#activeDatepicker" ).datepicker({
						minDate: 0,
						defaultDate: "+1d",
						onSelect: update_time_info
					});
					if(dateIsSet == true){
						$( "#activeDatepicker" ).datepicker("setDate",new Date("'.$test->get_date_active().'"));
					}
					else{
						$("#activeDatepicker").datepicker("setDate", null);
					}
					
					
				});
			</script>
			
			<script>
				$(function() {
					var dateIsSet = '.$test->due_date_is_set().'
					$( "#datepicker" ).datepicker({
						minDate: 0,
						defaultDate: "+7d",
						onSelect: update_time_info
					});
					if(dateIsSet == true){
						$( "#datepicker" ).datepicker("setDate",new Date("'.$test->get_date_due().'"));
					}
					else{
						// Defaults to being due 7 days after date making
						$( "#datepicker" ).datepicker("setDate", new Date().getDay+7);
					}
				});
			</script>
			
			<header class="major">
			</header>
			<div class="testContainer">
				<div id="sidebar" class="sidebar" style="text-align:center">
					<section style="text-align:center">
			<!--		<img id="testpageIconImage" src="images/eliteicon.png" width="100" height="110" alt="elite logo"/> -->
						
						<h5>Time Limit:</h5>
						<p style="color:white;">
							<input id="txt_time_limit" type="number" name="50" value="' . $test->get_time_limit() . '" style="text-align: center; width: 60px;" min="0"
							  onFocus=(this.name=this.value)>
							minutes
						</p>
						<p style="color:white;">
							Active Date: 
							<input type="text" style="color: black;" id="activeDatepicker" onFocus=(this.name=this.value)>
						
						<p style="color:white;">
							Date Due: 
							<input type="text" style="color: black;" id="datepicker" onFocus=(this.name=this.value)>
							
						</p>

						<button id="btn_open_TFDialog"class="show_hide button small fit smallButton" rel="#slidingQ_2" >True / False</button>
						<button id="btn_open_MCDialog" class="show_hide button small fit smallButton" rel="#slidingQ_1" >Multiple Choice</button>
						<button id="btn_open_EssayDialog" class="show_hide button small fit smallButton" rel="#slidingQ_3" >Essay</button>
						<button id="btn_open_MatchDialog" class="show_hide button small fit smallButton" rel="#slidingQ_3" >Matching</button>	
						<br />
						<img src="images/saveImage.png" width="85em" height="85em" id="saveTest"  class="clickable_img" title="Save As Draft" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<img src="images/post_test.png" width="85em" height="85em" id="postTest"  class="clickable_img" title="Post This Test" style="padding-left: 10px; padding-right: 10px;"/><br />
						<h1> &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp Save and Close&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  &nbsp&nbsp&nbsp&nbsp&nbsp  Post Test&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</h1>
						
					</section>
				</div>
				
				<div id="testDiv" class="smallScreenTestDiv" style="float:right;">
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
					<li><input id="btn_add_tf" type="button" class="button special smallButton" value="Submit" /></li>
					<li><input type="reset" value="Reset" class="alt button special smallButton" /></li>
				</ul>
			</form>
		</div>
		
		<div id="dlg_mc" class="dialog_box" title="Multiple Choice Question Entry" style="background-color:white; text-align: center;">
			<form>
				<textarea id="txt_mcq_entry" rows="2" placeholder="Enter a Multiple Choice Question"
					name="txt_mcq_entry" class="questionStyle" ></textarea>

				<div id="area_mc_answers">
					<div class="mc_answer">
						<br />
						<label for="txt_mc_answer_1" class="questionLabel letter_label"> A)</label>
						<input id="txt_mc_answer_1" type="text" name="txt_mc_answer_1" class="questionStyle answer_text">
						<input type="radio" id="rb_is_answer_a" name="rb_is_answer" checked>
						<label for="rb_is_answer_a" class="questionLabel radio_label">Answer</label>
						<img src="images/delete.png" class="clickable_img clickable_img_circular" title="Delete Answer" style="width: 29px; height: 29x;" onclick="delete_multiple_choice_answer(this.parentElement)"/>
					</div>
					
					<div class="mc_answer">
						<br />
						<label for="txt_mc_answer_2" class="questionLabel letter_label"> B)</label>
						<input id="txt_mc_answer_2" type="text" name="txt_mc_answer_2" class="questionStyle answer_text">
						<input type="radio" id="rb_is_answer_b" name="rb_is_answer" >
						<label for="rb_is_answer_b" class="questionLabel radio_label">Answer</label>
						<img src="images/delete.png" class="clickable_img clickable_img_circular" title="Delete Answer" style="width: 29px; height: 29x;" onclick="delete_multiple_choice_answer(this.parentElement)"/>
					</div>
					
					<div class="mc_answer">
						<br />
						<label for="txt_mc_answer_3" class="questionLabel letter_label"> C)</label>
						<input id="txt_mc_answer_3" type="text" name="txt_mc_answer_3" class="questionStyle answer_text">
						<input type="radio" id="rb_is_answer_c" name="rb_is_answer" >
						<label for="rb_is_answer_c" class="questionLabel radio_label">Answer</label>
						<img src="images/delete.png" class="clickable_img clickable_img_circular" title="Delete Answer" style="width: 29px; height: 29x;" onclick="delete_multiple_choice_answer(this.parentElement)"/>
					</div>
					
					<div class="mc_answer">
						<br />
						<label for="txt_mc_answer_4" class="questionLabel letter_label"> D)</label>
						<input id="txt_mc_answer_4" type="text" name="txt_mc_answer_4" class="questionStyle answer_text">
						<input type="radio" id="rb_is_answer_d" name="rb_is_answer">
						<label for="rb_is_answer_d" class="questionLabel radio_label">Answer</label>
						<img src="images/delete.png" class="clickable_img clickable_img_circular" title="Delete Answer" style="width: 29px; height: 29x;" onclick="delete_multiple_choice_answer(this.parentElement)"/>
					</div>
				</div>
				
				<label style="float:left;">
					<img src="images/add-icon.png" alt="(+)" class="clickable_img" style="width: 32px; padding-top: 5px;" onclick="add_mc_answer(\'\', false)" />
					Add Answer
				</label>
				<br />
				<br />
				
				<input type="number" id="txt_mc_weight" value="1" min="1" max="999" style="width: 70px; text-align: center;" class="weight_entry">
				<label for="txt_mc_weight">Point(s)</label>
				<br />
				<br />
				<p id="err_empty_mc" style="display: none; color: red;">
					Please fill in all fields...
				</p>
				<p id="err_unanswered_mc" style="display: none; color: red;">
					The answer cannot be deleted. Please change the answer first...
				</p>
				<input id="btn_add_mc" type="button" class="button special smallButton" value="Submit" />
				<input type="reset" value="Reset" class="alt button special reset smallButton"/>
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
					<li><input id="btn_add_essay" type="button" value="Submit" class="button special smallButton"/></li>
					<li><input type="reset" value="Reset" class="alt button special smallButton"/></li>
				</ul>
			</form>
		</div>
		
		<div id="dlg_match" class="dialog_box" title="Matching Section Entry" style="background-color:white; text-align: center;">
			<form>
				<textarea id="txt_matchq_entry" rows="1" placeholder="Enter a Matching Section Description"
					name="txt_matchq_entry" class="questionStyle" style="margin-bottom: 5px; width: 100%;" tabindex="1"></textarea>
				<div style="display: inline-block; ">
					Questions & Match
					<div id="area_matching_questions">
						<div class="match_question"> <input class="txt_match_question matching_input_box" type="text" style="width: 260px;" tabindex="2"/><select class="ddl_matched_answer matching_input_box" style="width: 50px;"></select></div>
						<div class="match_question"> <input class="txt_match_question matching_input_box" type="text" style="width: 260px;" tabindex="4"/><select class="ddl_matched_answer matching_input_box" style="width: 50px;"></select></div>
						<div class="match_question"> <input class="txt_match_question matching_input_box" type="text" style="width: 260px;" tabindex="6"/><select class="ddl_matched_answer matching_input_box" style="width: 50px"></select></div>
						<div class="match_question"> <input class="txt_match_question matching_input_box" type="text" style="width: 260px;" tabindex="8"/><select class="ddl_matched_answer matching_input_box" style="width: 50px;"></select></div>
						<div class="match_question"> <input class="txt_match_question matching_input_box" type="text" style="width: 260px;" tabindex="10"/><select class="ddl_matched_answer matching_input_box" style="width: 50px;"></select></div>
						<div class="match_question"> <input class="txt_match_question matching_input_box" type="text" style="width: 260px;" tabindex="12"/><select class="ddl_matched_answer matching_input_box" style="width: 50px;"></select></div>
						<div class="match_question"> <input class="txt_match_question matching_input_box" type="text" style="width: 260px;" tabindex="14"/><select class="ddl_matched_answer matching_input_box" style="width: 50px;"></select></div>
						<div class="match_question"> <input class="txt_match_question matching_input_box" type="text" style="width: 260px;" tabindex="16"/><select class="ddl_matched_answer matching_input_box" style="width: 50px;"></select></div>
						<div class="match_question"> <input class="txt_match_question matching_input_box" type="text" style="width: 260px;" tabindex="18"/><select class="ddl_matched_answer matching_input_box" style="width: 50px;"></select></div>
						<div class="match_question"> <input class="txt_match_question matching_input_box" type="text" style="width: 260px;" tabindex="20"/><select class="ddl_matched_answer matching_input_box" style="width: 50px;"></select></div>
					</div>
					<p id="err_empty_match_question" style="display: none; color: red;">
						Please enter at least one question...
					</p>
					<p id="err_unlinked_match_question" style="display: none; color: red;">
						Each question must link to an answer...
					</p>
				</div>
				<div style="display: inline-block; ">
					Answers
					<div id="area_matching_answers">
						<div> a<input class="txt_match_answer matching_input_box" type="text" tabindex="3"/></div>
						<div> b<input class="txt_match_answer matching_input_box" type="text" tabindex="5"/></div>
						<div> c<input class="txt_match_answer matching_input_box" type="text" tabindex="7"/></div>
						<div> d<input class="txt_match_answer matching_input_box" type="text" tabindex="9"/></div>
						<div> e<input class="txt_match_answer matching_input_box" type="text" tabindex="11"/></div>
						<div> f<input class="txt_match_answer matching_input_box" type="text" tabindex="13"/></div>
						<div> g<input class="txt_match_answer matching_input_box" type="text" tabindex="15"/></div>
						<div> h<input class="txt_match_answer matching_input_box" type="text" tabindex="17"/></div>
						<div> i<input class="txt_match_answer matching_input_box" type="text" tabindex="19"/></div>
						<div> j<input class="txt_match_answer matching_input_box" type="text" tabindex="21"/></div>
					</div>
					<p id="err_empty_match_answer" style="display: none; color: red;">
						Please enter at least one answer...
					</p>
				</div>
				<br />
				<br />
				<input type="number" id="txt_match_weight" value="1" min="1" max="999" style="width: 70px; text-align: center;" class="weight_entry" tabindex="22">
				<label for="txt_match_weight">Point(s) per question</label>
				<br />
				<br />
				<p id="err_empty_match" style="display: none; color: red;">
					Please enter a description...
				</p>
				<input id="btn_add_match_section" type="button" class="button special smallButton" value="Submit" tabindex="23"/>
				<input type="reset" value="Reset" class="alt button special smallButton" tabindex="24"/>
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









