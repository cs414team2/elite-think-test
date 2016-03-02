<?php
require_once('model/Teacher.php');
include_once('model/Test.php');

if (isset($_SESSION['credentials'], $_REQUEST['test_id'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		// PUT HTML HERE!
		$test = new Test();
		$test_id = $_REQUEST['test_id'];
		echo '
		<section id="main" class="wrapper style1">
		
		    <script language="javascript">
			var test_id = ' . $_REQUEST['test_id'] . ';
			
			function setRadio(obj) 
			{
				if(obj.checked == true)
					obj.checked = false;
				else
					obj.checked = true
			}
			</script>
			<script src="controllers/test_editor.js"></script>
			
			<header class="major">
				
			</header>
		
			<div class="testContainer">
				<div id="sidebar" style="text-align:center">
					
					<section style="text-align:center">
						<h2>'; $test->get_class_name($test_id); echo '</h2>
						<p style="color:white;">
							<input type="number" name="timeLimit" style="text-align: center; width: 60px;" min="0">	
							min(s) to take test
						</p>
						
							<button class="show_hide button small fit" style="padding: 0 .5em; height: 2em; line-height: 0em;" rel="#slidingQ_1" >M/C</button>
							
							<button class="show_hide button small fit" style="padding: 0 .5em; height: 2em; line-height: 0em;" rel="#slidingQ_2" >T/F</button>

							<button class="show_hide button small fit" style="padding: 0 .5em; height: 2em; line-height: 0em;" rel="#slidingQ_3" >Essay</button>

							<div id="slidingQ_1" class="toggleDiv"> 
								<section id="MultipleChoice">
									<div id="my-form-builder"  align="left">
										<form>
											<h4>Multiple Choice</h4>
											<textarea id="txt_mcq_entry" rows="2" placeholder="Enter a Multiple Choice Question"
											
											name="txt_mcq_entry" class="questionStyle"></textarea>
											<label for="mcAnswer1" class="questionLabel"> A)</label>
											<input id="mcAnswer1" type="text" name="mcAnswer1" class="questionStyle mc_answer">
											<input type="radio" id="rb_is_answer_a" name="rb_is_answer" >
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
											<input type="radio" id="rb_is_answer_d" name="rb_is_answer" >
											<label for="rb_is_answer_d" class="questionLabel">Answer</label>
											<br/><br />
													
											<ul class="actions" >
												<li><input id="btn_add_mc" type="button" class="button special"value="Submit" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
												<li><input type="reset" value="Reset" class="alt button special" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
											</ul>
										</form>
									</div>
								</section>
							</div>
							
							<div id="slidingQ_2" class="toggleDiv"> 
								<section id="TorF">
									
									<div id="my-form-builder"  align="left" >
										<h4>T/F Question</h4>
										<form>
											<textarea id="txt_tfq_entry" rows="2" placeholder="Enter a True/False Question"
												name="txt_tfq_entry" class="questionStyle"></textarea>
											<br />
											
											
											<input type="radio" id="rb_answer_true" name="rb_answer_tf"  checked>
											<label for="rb_answer_true" class="questionLabel">True</label>
																
											<input type="radio" id="rb_answer_false" name="rb_answer_tf" >
											<label for="rb_answer_false" class="questionLabel">False</label>
											<br /><br />
											
											<ul class="actions">
												<li><input id="btn_add_tf" type="button" class="button special" value="Submit" style="padding: 0 0 .5em 0; height: 2em; line-height: 0em;"/></li>
												<li><input type="reset" value="Reset" class="alt button special" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
											</ul>
										</form>
									</div>
								</section>
							</div>
										
							<div id="slidingQ_3" class="toggleDiv"> 
								<section id="essayQuestion">
									<div id="my-form-builder" align="left">
										<form>
											<h4>Essay Question</h4>
											<textarea id="txt_eq_entry" rows="4" placeholder="Enter an Essay Question"
											name="txt_eq_entry" class="questionStyle"></textarea>
											<br /><br />

											<ul class="actions">
												<li><input id="btn_add_essay" type="button" value="Submit" class="button special" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
												<li><input type="reset" value="Reset" class="alt button special" style="padding: 0 .5em; height: 2em; line-height: 0em;"/></li>
											</ul>
										</form>
									</div>
								</section>
							</div>
						</section>
					</div>

				<div class="smallScreenTestDiv" style="float:right;"> 
					<section id="testView">
						<div id="my-form-builder" align="left">
							<h4>'; $test->get_test_number($test_id); echo '</h4>
								
								<div id="test_content">';
									require_once('controllers/load_questions.php');
						echo   '</div>
							<br />
							
						</div>
					</section>
				</div>
			</div>
		</section>
		
			
	
		';
	}
}
else {
	header('Location: ./');
}
?>









