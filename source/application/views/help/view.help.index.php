<?php IncludeJS('form'); ?>

<script>
	$(document).ready( function() {
		var form = new Form($("#help-form"));
		
		form.submitFunction = function() {
			form.request();
		};
		
		form.applyValidation(validators = [
			new Validator($("#subject"), {
				name: "question subject",
				required: true,
				minLenght: 5,
				maxLenght: 100,
				filter: /^[a-zA-Z0-9 \.,-\/#!?$%\^&\*;:{}=\-_`~()''""]+$/,
				description: "May contain only latin letters, punctuation marks and whitespaces"
			}),
			new Validator($("#question"), {
				name: "question text",
				required: true,
				minLenght: 10,
				maxLenght: 5000,
				filter: /^[a-zA-Z0-9 \.,-\/#!?$%\^&\*;:{}=\-_`~()''""\n]+$/,
				description: "May contain only latin letters, punctuation marks and whitespaces"
			})
		]);
	});
</script>

<style>	
	.label-wrapper
	{
		clear: both;
		
		margin: 0px;
		padding: 0px 0px 2px 10px;
	}
	
	.input-wrapper
	{
		margin: 0px;
	}
	
	.error-wrapper
	{
		width: auto;
	}
	
	#standard-type-input-block
	{
		margin: 5px 90px;
	}
	
	#subject-input-block,
	#question-input-block
	{
		width: 470px;
	}
	
	#subject
	{
		width: 448px;
	}
	
	#question
	{
		height: 130px;
	}
	
	#submit-input-block
	{
		width: 140px;
		margin: 15px 170px 0px 170px;
	}
	
	#result-input-block
	{
		width: 470px;
		text-align: center;
	}
</style>

<div class="headline">
	<p>Ask a Question</p>
</div>
<div class="content">
	<form id="help-form" class="dark-form" action="<?php LinkToAction('help') ?>" method="post" autocomplete="on">
		<div id="standard-type-input-block" class="input-block">
			<div class="label-wrapper">
				<label for="standard-type">Type of Standard<span class="required_mark">*</span></label>
			</div>
			<div class="input-wrapper">
				<select id="standard-type" name="standard">
					<option value="FSC">FSC</option>
					<option value="PEFC">PEFC</option>
				</select>
			</div>
		</div>
		<div id="subject-input-block" class="input-block">
			<div class="label-wrapper">
				<label for="subject">Subject<span class="required_mark">*</span></label>
			</div>
			<div class="input-wrapper">
				<input id="subject" name="subject" type="text" placeholder="Question Subject..." maxlength="100">
			</div>
		</div>
		<div id="question-input-block" class="input-block">
			<div class="label-wrapper">
				<label for="question">Question<span class="required_mark">*</span></label>
			</div>
			<div class="input-wrapper">
				<textarea id="question" name="question" placeholder="Your Question..." maxlength="5000"></textarea>
			</div>
		</div>
		<div id="submit-input-block" class="input-block">
			<input type="submit" value="Ask Question">
		</div>
	</form>
</div>