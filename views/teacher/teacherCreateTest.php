<?php
require_once('model/Teacher.php');

if (isset($_SESSION['credentials'])) {
	if ($_SESSION['credentials']->is_teacher()) {
		// PUT HTML HERE!
		echo '
		<section id="main" class="wrapper style1">
		
		    <script language="javascript">
			function setRadio(obj) 
			{
				if(obj.checked == true)
					obj.checked = false;
				else
					obj.checked = true
			}
			</script>
			<header class="major">
				<h2> Test Creation</h2>
				<p>Create and Manage Tests</p>
			</header>
		
		<div class="testContainer">
			<div id="sidebar" style="text-align:center">
				
				<section style="text-align:center">
						<button class="show_hide button small fit" rel="#slidingDiv_1" >M/C</button>
						<button class="show_hide button small fit" rel="#slidingDiv_2" >T/F</button>
						<button class="show_hide button small fit" rel="#slidingDiv_3" >Essay</button><br />
				</section>
				
				<h4 style="color:white;">Time Limit on test: </h4>
					<input type="number" name="timeLimit" style="text-align: center; align:center">	
			</div>
		    
			<div id="slidingDiv_1" class="toggleDiv" style="display:none; max-height:500px;" > 
			<section id="MultipleChoice">
				<div id="my-form-builder"  align="left">
					<h4>Multiple Choice</h4>
					<input id="mcqEntry" type="text" placeholder="Enter a Multiple Choice Question" name="mcqEntry" class="questionStyle"><br/>
					<br/>
					<label for="mcAnswer1" class="questionLabel"> Choice 1</label>
					<input id="mcAnswer1" type="text" name="mcAnswer1" class="questionStyle"><br/>
					
					<label for="mcAnswer2" class="questionLabel"> Choice 2</label>
					<input id="mcAnswer2" type="text" name="mcAnswer2" class="questionStyle"><br/>
					
					<label for="mcAnswer3" class="questionLabel"> Choice 3</label>
					<input id="mcAnswer3" type="text" name="mcAnswer3" class="questionStyle"><br/>
					
					
					<label for="mcAnswer4" class="questionLabel"> Choice 4</label>
					<input id="mcAnswer4" type="text" name="mcAnswer4" class="questionStyle"><br/>
					
					
					<button type="button">Submit Question</button>
					<hr>
				</div>
			</section>
			</div>
			
			<div id="slidingDiv_2" class="toggleDiv" style="display:none"> 
				<section id="TorF">
					
					<div id="my-form-builder"  align="left" >
						<h4>T/F Question</h4>
						<form class="4u 12u(2)">
							<input id="tfqEntry" type="text" placeholder="Enter a T/F Question" name="mfqEntry" class="questionStyle"><br />
							
							
								<input type="radio" id="answerTrue" name="tfButton"  checked>
								<label for="answerTrue" class="questionLabel">True</label>
							
							
								<input type="radio" id="answerFalse" name="tfButton" >
								<label for="answerFalse" class="questionLabel">False</label>
								<br>
								<button type="button">Submit Question</button>
							
						</form>
				</section>
			</div>
			
			
			<div id="slidingDiv_3" class="toggleDiv" style="display:none"> 
			<section id="essayQuestion">
				<div id="my-form-builder" align="left">
					<h4>Essay Question</h4>
					<input id="eqEntry" type="text" placeholder="Enter a Essay Question" name="mcqEntry" class="questionStyle"><br />

					<button type="button">Submit Question</button>
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









