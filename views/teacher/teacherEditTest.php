<?php
require_once('model/Teacher.php');

if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		// PUT HTML HERE!
		echo '
		<section id="main" class="wrapper style1">
		
		    <script language="javascript">
			var test_id = ' . $_REQUEST['test_id']; . ';
			
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
				<h2> Test Creation</h2>
				<p>Create and Manage Tests</p>
			</header>
		
			<div class="testContainer">
				<div id="sidebar" style="text-align:center">
					
					<section style="text-align:center">
							<button class="show_hide button small fit" rel="#slidingQ_1" >M/C</button>
							<button class="show_hide button small fit" rel="#slidingQ_2" >T/F</button>
							<button class="show_hide button small fit" rel="#slidingQ_3" >Essay</button><br />
					</section>
					
					<h4 style="color:white;">Time Limit on test: </h4>
					<input type="number" name="timeLimit" style="text-align: center; align:center">	
					<br /><br /><br /><br /><br /><br /><br /><br />
					
					<button id="btn_finalize_test" class="show_hide button small fit">Finalize</button>
					<br />
				</div>
				
				<div id="slidingQ_0" class="toggleDiv" style="display:inline-block; min-width: 30%; float: left;"> 
					<section id="essayQuestion">
						<div id="my-form-builder" align="left">
							<h4>Use links to the left to add a question</h4>
							<br />
						</div>
					</section>
				</div>
				
				<div id="slidingQ_1" class="toggleDiv" style="display:none; min-width: 30%; float: left;"> 
					<section id="MultipleChoice">
						<div id="my-form-builder"  align="left">
							<form>
								<h4>Multiple Choice</h4>
								<textarea id="txt_mcq_entry" rows="2" placeholder="Enter a Multiple Choice Question"
									name="txt_mcq_entry" class="questionStyle"></textarea>
								<br/>
								<label for="mcAnswer1" class="questionLabel"> Choice 1</label>
								<input id="mcAnswer1" type="text" name="mcAnswer1" class="questionStyle">
								<br/>
								
								<label for="mcAnswer2" class="questionLabel"> Choice 2</label>
								<input id="mcAnswer2" type="text" name="mcAnswer2" class="questionStyle">
								<br/>
								
								<label for="mcAnswer3" class="questionLabel"> Choice 3</label>
								<input id="mcAnswer3" type="text" name="mcAnswer3" class="questionStyle">
								<br/>
								
								<label for="mcAnswer4" class="questionLabel"> Choice 4</label>
								<input id="mcAnswer4" type="text" name="mcAnswer4" class="questionStyle">
								<br/><br />
										
								<ul class="actions">
									<li><input id="btn_add_mc" type="button" value="Submit Question" /></li>
									<li><input type="reset" value="Reset" class="alt" /></li>
								</ul>
							</form>
						</div>
					</section>
				</div>
				
				<div id="slidingQ_2" class="toggleDiv" style="display:none; min-width: 30%; float: left;"> 
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
									<li><input id="btn_add_tf" type="button" value="Submit Question" /></li>
									<li><input type="reset" value="Reset" class="alt" /></li>
								</ul>
							</form>
					</section>
				</div>
				
				<div id="slidingQ_3" class="toggleDiv" style="display:none; min-width: 30%; float: left;"> 
					<section id="essayQuestion">
						<div id="my-form-builder" align="left">
							<form>
								<h4>Essay Question</h4>
								<textarea id="txt_eq_entry" rows="4" placeholder="Enter an Essay Question"
								name="txt_eq_entry" class="questionStyle"></textarea>
								<br /><br />

								<ul class="actions">
									<li><input id="btn_add_essay" type="button" value="Submit Question" /></li>
									<li><input type="reset" value="Reset" class="alt" /></li>
								</ul>
							</form>
						</div>
					</section>
				</div>
				
				<div style="float:right; inline-block; min-width: 60%;"> 
					<section id="testView">
						<div id="my-form-builder" align="left">
							<h4>Test Goes Here Yo!</h4>
								
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








