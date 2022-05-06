<?php 
/*
Plugin Name: Magic Translations
Description: This plugin provides the ability to add a language translations 
Version: 1.0.0
Author: Muhammad Bilal ( <a href="mailto:bilal.scientist@gmail.com">bilal.scientist@gmail.com</a> )
*/



// Dashboard Part




if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'MBK_Magic_Translate_0234');


	
	 
    function MBK_Magic_Translate_0234() {
            //add_options_page('Language Translation', 'Language Translation', 'administrator',
            //'Language Translation', 'MBK_Magic_Translate_XYZ_4545');
			
			add_submenu_page(
                     'edit.php', //$parent_slug
                     'Magic Translations',  //$page_title
                     'Magic Translations',        //$menu_title
                     'administrator',           //$capability
                     'mbk_magic_translation',//$menu_slug
                     'MBK_Magic_Translate_XYZ_4545'//$function
     );
    }
	
	

    function MBK_Magic_Translate_XYZ_4545(){
		echo "
			<style>
			
			</style>
		";
		echo '
			<link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
     
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
	<style>
		#add-para-div,
		#edit-para-div {
			text-align: center;
		}
		
		#add-para-div textarea,
		#edit-para-div textarea {
			width: 350px;
			height: 100px;
			margin: 10px;
		}
		
		#add-para-div input,
		#edit-para-div input {
			width: 250px;
			margin: 10px;
		}
	</style>
		';
		$dropdown = "
			<div class='table-responsive' style='padding-right: 20px'>
			<table class='table table striped table-bordered wp-list-table widefat fixed striped table-view-list pages'>
			<tr class='thead-light'>
				<th>ShortCode</th>
				<th>Actions</th>
				<th style='display: none; border-left: 0; border-bottom: 0' id='third-column'>Preview</th>
			</tr>
		";
		global $wpdb;
		$id = -1;
		echo '<div id="add-para-btn"><br><button class="btn button btn-primary" onclick="tdlshowAddPara()">Add a Paragraph</button></div>';
		
		echo "
			<script>
				function tdlshowAddPara() {
					document.getElementById('add-para-div').style.display = 'block';
					document.getElementById('edit-para-div').style.display = 'none';
					document.getElementById('edit-para-div').innerHTML = '';
				}
			</script>
		";
		
		echo '<h1>Magic Translations</h1>';
		
    	$table1 = $wpdb->prefix . "language_translator_paragraphs";
		
		$query = 'SELECT * FROM '.$table1;
		$rows = $wpdb->get_results($query);
		$max = -1;
		$iterCount = 0;
		$rowCount = 0;
		foreach($rows as $row) {
			$iterCount = 0;
			if($row->id != $id or $id == -1) {
			$dropdown .= "<tr style='cursor: pointer' class='lists' data-id='".$row->id."'>";
			$dropdown .= "<td>[mypara id=" . $row->id . "]</td>";
			$dropdown .= "<td><button onclick='tdleditTodoPara(".$row->id.")' class='btn button btn-secondary edit-btn'>Edit</button><button style='margin-left: 10px' onclick='tdldeleteTodoPara(".$row->id.")' class='button btn btn-danger'>Delete</button><button class='button' id='show-para-btn-".$rowCount."' onclick='tdltogglePara(".$row->id.", ".$rowCount.")' style='margin-left: 10px'>Show</button></td>";
			$dropdown .= "<td style='display: none; border: 0' class='class-".$row->id."'><table style='border: 0'  class='table table striped table-bordered wp-list-table widefat fixed striped table-view-list pages'>";
				foreach($rows as $r) {
					if($r->id == $row->id) {
						if($iterCount == 0) {
						$dropdown .= "<tr style='border-left: 0;'><td style='border-left: 0; text-align: left !important;'>". str_replace('&&&', '. ', $r->paragraph_content) ."</td></tr>";
						$iterCount += 1;
						$rowCount += 1;
					}
				}
				}
			$dropdown .= "</table></td></tr>";
			$id = $row->id;
			
		}
		}
		$dropdown .= "</table></div>";
		echo $dropdown;
		
		echo "<script>
		
				function tdldeleteTodoPara(pid) {
					var form_data = {'id': pid, 'action': 'delete_paragraph'};
					let isConfirm = confirm('Are You Sure?');
					
					if (isConfirm) {		
					
						jQuery.ajax({
								url: '"  .  admin_url( 'admin-ajax.php' ) .  "',
								type:'POST',
								dataType:'text',
								data : form_data,
								success: function( response ) {
									console.log(response);
									window.location.reload();
								},
								error: function( response ) {
									console.log(response);
								}
						});
						
					}
				}
			
				function tdltogglePara(pid, count) {
					let btnText = document.getElementById('show-para-btn-' + count).innerHTML;
					if (btnText == 'Show') {
						document.getElementById('show-para-btn-' + count).innerHTML = 'Hide';
						document.querySelector('.class-' + pid).style.display = 'table-row';
						document.getElementById('third-column').style.display = '';
					}
					else {
						document.getElementById('show-para-btn-' + count).innerHTML = 'Show';
						document.querySelector('.class-' + pid).style.display = 'none';
						document.getElementById('third-column').style.display = 'none';
					}
				}
				
				function createAddEditFields() {
					let languageInput = document.createElement('input');
					languageInput.setAttribute('placeholder', 'Enter Language');
					let translation = document.createElement('textarea');
					translation.value = 'Enter Translation';
					document.getElementById('add-fields').append(document.createElement('br'));
					document.getElementById('add-fields').append(languageInput);
					document.getElementById('add-fields').append(document.createElement('br'));
					document.getElementById('add-fields').append(translation);
				}
				
				function tdleditTodoPara(pid) {
					var form_data = {'id': pid, 'action': 'edit_paragraph'};
					document.getElementById('add-para-div').style.display = 'none';
					document.getElementById('paragraph-fields').innerHTML = '';
					
					
					jQuery.ajax({
							url: '"  .  admin_url( 'admin-ajax.php' ) .  "',
							type:'POST',
							dataType:'text',
							data : form_data,
							success: function( response ) {
								console.log(response);
								let obj = JSON.parse(response);
								let editDiv = document.getElementById('edit-para-div');
								editDiv.style.display = 'block';
								document.getElementById('add-para-div').style.display = 'none';
								let paragraph = document.createElement('textarea');
								paragraph.value = obj[0]['paragraph_content'].replaceAll('&&&', '\\r\\n');
								paragraph.setAttribute('id', 'para-textarea');
								editDiv.append(paragraph);
								var label = document.createElement('h3');
								label.innerHTML = 'Translations';
								editDiv.append(label);
								let addTransBtn = document.createElement('button');
								addTransBtn.innerHTML = 'Add a Translation';
								addTransBtn.setAttribute('class', 'btn btn-primary');
								addTransBtn.setAttribute('onclick', 'createAddEditFields()');
								editDiv.append(addTransBtn);
								let addFields = document.createElement('div');
								addFields.setAttribute('id', 'add-fields');
								editDiv.append(addFields);
								let fields =  document.createElement('div');
								fields.setAttribute('id', 'edit-fields');
								editDiv.append(fields);
							},
							error: function( response ) {
								console.log(response);
							}
						});
						
					var form_data2 = {'id': pid, 'action': 'edit_translations'};					
						
					setTimeout(() => {
						jQuery.ajax({
							url: '"  .  admin_url( 'admin-ajax.php' ) .  "',
							type:'POST',
							dataType:'text',
							data : form_data2,
							success: function( response ) {
								console.log(response);
								let obj = JSON.parse(response);

								let editDiv = document.getElementById('edit-para-div');
								let fields = document.getElementById('edit-fields');
								
								
								obj.forEach(o => {
									var input = document.createElement('input');
									input.setAttribute('placeholder', 'Language');
									input.setAttribute('id', o['id']);
									input.value = o['language'];
									var textarea = document.createElement('textarea');
									textarea.value = o['translation'].replaceAll('&&&', '\\r\\n');
									textarea.setAttribute('id', o['id']);
									fields.append(document.createElement('br'));
									fields.append(input);
									fields.append(document.createElement('br'));
									fields.append(textarea);
									fields.append(document.createElement('br'));
								})
								let button = document.createElement('button');
								button.innerHTML = 'Save Changes';
								button.setAttribute('class', 'btn btn-primary');
								let id = JSON.parse(response)[0]['paragraph_id'];
								button.setAttribute('data-id', id);
								button.setAttribute('id', 'save-edit');
								button.setAttribute('onclick', 'saveChanges()');
								document.getElementById('edit-para-div').append(button);
							},
							error: function( response ) {
								console.log(response);
							}
						});
					}, 500)
					
				}
				
				
				function saveChanges() {
					let id = document.getElementById('save-edit').getAttribute('data-id');
					let paragraph = document.getElementById('para-textarea').value.replaceAll(/\\n/g, '&&&')||[];
					let langs = [];
					document.querySelectorAll('#edit-fields input').forEach(input => {
						langs.push(input.value);
					})
					let ids = [];
					let textareas = [];
					document.querySelectorAll('#edit-fields textarea').forEach(textarea => {
						let value = textarea.value;
						textareas.push(value.replaceAll(/\\n/g, '&&&')||[]);
						ids.push(textarea.getAttribute('id'));
					})
					
					let newLanguages = [];
					document.querySelectorAll('#add-fields input').forEach(input => {
						newLanguages.push(input.value);
					})
					let newTranslations = [];
					document.querySelectorAll('#add-fields textarea').forEach(textarea => {
						newTranslations.push(textarea.value.replaceAll(/\\n/g, '&&&')||[]);
					})
					
					var form_data = {'id': id, 'paragraph': paragraph, 'action': 'save_paragraph'};
						
						
					jQuery.ajax({
							url: '"  .  admin_url( 'admin-ajax.php' ) .  "',
							type:'POST',
							dataType:'text',
							data : form_data,
							success: function( response ) {
								console.log(response);
							},
							error: function( response ) {
								console.log(response);
							}
						});
						
						var form_data2 = {'ids': ids, 'langs': langs, 'textareas': textareas, 'action': 'save_trans'};
						
						jQuery.ajax({
							url: '"  .  admin_url( 'admin-ajax.php' ) .  "',
							type:'POST',
							dataType:'text',
							data : form_data2,
							success: function( response ) {
								console.log(response);
								if (newLanguages.length == 0) {
									window.location.reload();
								}
							},
							error: function( response ) {
								console.log(response);
								if (newLanguages.length == 0) {
									window.location.reload();
								}
							}
						});
						
						if (newLanguages.length != 0) {
							var form_data3 = {'id': id, 'new_languages': newLanguages, 'new_translations': newTranslations, 'action': 'new_trans_edit'};
							
							setTimeout(() => {
								
								jQuery.ajax({
									url: '"  .  admin_url( 'admin-ajax.php' ) .  "',
									type:'POST',
									dataType:'text',
									data : form_data3,
									success: function( response ) {
										console.log(response);
										window.location.reload();
									},
									error: function( response ) {
										console.log(response);
										window.location.reload();
									}
								});
								
							}, 500);
						}
					
				}
			
			
			</script>";
		
		$postIds = array();
		foreach($rows as $row) {
			array_push($postIds, $row->id);
		}
		
		if(count($postIds) > 0) {
			$max = max($postIds);
			$max += 1;
		}
		else {
			$max = 1;
		}

		
		
		
		echo "
			<div style='display: none; text-align: center' id='add-para-div'>
				<textarea id='paragraph-textarea' rows=6>Enter Paragraph Here</textarea>
				<br>
				<button onclick='tdlcreateFieldsPara()' id='add-trans-btn'>Add a Translation</button>
				<div id='paragraph-fields'></div><br>
				<div style='text-align: center'><button onclick='tdladdPara(".$max.")' style='margin: auto' class='btn button button btn-primary'>Save Paragraph</button></div>
				
				<script>
				
				function tdladdPara(Id) {
					let paragraph = document.getElementById('paragraph-textarea').value;
					
					paragraph = (paragraph.replaceAll(/\\n/g, '&&&')||[]);
					
					
					let languageInputs = [];
					document.querySelectorAll('.lang-input').forEach(input => {
						languageInputs.push(input.value);
					})
					let textareas = [];
					document.querySelectorAll('#paragraph-fields textarea').forEach(textarea => {
						textareas.push((textarea.value.replaceAll(/\\n/g, '&&&')||[]));
					})
					
					let form_data = {'id': Id, 'paragraph_content': paragraph, 'action': 'add_paragraph', 'language_inputs': languageInputs, 'textareas': textareas};
					
					jQuery.ajax({
 								url: '"  .  admin_url( 'admin-ajax.php' ) .  "',
 								type:'POST',
 								dataType:'text',
 								data : form_data,
 								success: function( response ) {
 									console.log(response);
 									window.location.reload();
 								},
 								error: function( response ) {
 									console.log(response);
 								}
 						});
 					
				}
				
 					function tdlcreateFieldsPara() {
 						let langInput = document.createElement('input');
 						langInput.setAttribute('placeholder', 'Language');
 						langInput.setAttribute('class', 'lang-input');
 						let paraTrans = document.createElement('textarea');
 						paraTrans.value = 'Enter Translation';
 						paraTrans.setAttribute('class', 'para-trans');
						document.getElementById('paragraph-fields').append(document.createElement('br'));
 						document.getElementById('paragraph-fields').append(langInput);
 						document.getElementById('paragraph-fields').append(document.createElement('br'));
 						document.getElementById('paragraph-fields').append(document.createElement('br'));
 						document.getElementById('paragraph-fields').append(paraTrans);
 						document.getElementById('paragraph-fields').append(document.createElement('br'));
 						document.getElementById('paragraph-fields').append(document.createElement('br'));
						
 					}
 				</script>
				
 			</div>
 		";
		
 		echo "
 			<div id='edit-para-div' style='display: none'>
 			<br>
 			</div>
 		";
	
	}
}


// Dashboard Part Ends 



add_action( 'wp_ajax_save_trans', 'save_trans' );
function save_trans() {
	global $wpdb;
	$table = $wpdb->prefix . "language_translator_paragraph_translations";
	$ids = $_POST['ids'];
	$langs = $_POST['langs'];
	$textareas = $_POST['textareas'];
	$query = "";
	$content = "";
	for($x = 0; $x < count($ids); $x += 1) {
		$query = "UPDATE " . $table . " SET translation='" . $textareas[$x] . "', language='" . $langs[$x] . "' WHERE id=$ids[$x]";	
		$success = $wpdb->query($query);
		$content .= $query;
		
	}
	if ($success) {
		$content .= "Updated";	
	}
	else {
		$content .= "Not Updated";
	}
	echo $content;
	die();
}

add_action( 'wp_ajax_new_trans_edit', 'new_trans_edit' );
function new_trans_edit() {
	global $wpdb;
	$content = "";
	$table = $wpdb->prefix . "language_translator_paragraph_translations";
	$id = $_POST['id'];
	$languages = $_POST['new_languages'];
	$translations = $_POST['new_translations'];
	for($x = 0; $x < count($languages); $x += 1) {
		$query = "INSERT INTO " . $table . " (paragraph_id, language, translation) VALUES ('$id', '$languages[$x]', '$translations[$x]')";
		$success = $wpdb->query($query);
	}
	if ($success) {
		$content .= "Successful";
	}
	echo $content;
	die();
}

add_action( 'wp_ajax_save_paragraph', 'save_paragraph' );
function save_paragraph() {
	global $wpdb;
	$table = $wpdb->prefix . "language_translator_paragraphs";
	$id = $_POST['id'];
	$paragraph = $_POST['paragraph'];
	$query = "UPDATE " . $table . " SET `paragraph_content`='$paragraph' WHERE `id`='$id'";
	$content .= $query;
	$wpdb->query($query);

	if($success){
		$content .= 'Content Updated!' ; 
	} else {
		$content .= 'Error Updating Paragraph';
	}
	echo $content;
	die();
}



add_action( 'wp_ajax_delete_paragraph', 'delete_paragraph' );
function delete_paragraph() {
	global $wpdb;
	$content = "";
	$table = $wpdb->prefix . "language_translator_paragraphs";
	$table2 = $wpdb->prefix . "language_translator_paragraph_translations";
	$post_id = $_POST['id'];
	
	$query = "DELETE FROM " . $table ." WHERE id=" . $post_id;
	$success = $wpdb->query($query);
	$query = "DELETE FROM " . $table2 ." WHERE paragraph_id=" . $post_id;
	$wpdb->query($query);

	if($success){
		$content .= 'Content Deleted!' ; 
	} else {
		$content .= 'Error Deleting Paragraph';
	}
	echo $content;
	die();
}





add_action( 'wp_ajax_data_getter_para', 'data_getter_para' );
function data_getter_para($nitems){
	global $post;
	setup_postdata( $post );
    global $wpdb;
	$postID = $nitems;
    $table = $wpdb->prefix . "language_translator_paragraphs";
	$table2 = $wpdb->prefix . "language_translator_paragraph_translations";
	$query = 'SELECT * FROM '.$table.' where id=' . $postID;
	$query2 = 'SELECT * FROM '.$table2.' where paragraph_id=' . $postID;
	
	$rows = $wpdb->get_results($query);
	$rows2 = $wpdb->get_results($query2);

	if ( $rows ) {
		$count = 0;
	   $list = json_encode($rows, JSON_FORCE_OBJECT );
		$list = '<div style="text-align: center; padding: 20px;"><p style="font-size: 20px;">' . str_replace('&&&', '<br>', $rows[0]->paragraph_content) . '</p>';
		$list .= '<select id="language_dropdown" style="margin-bottom: 20px;">';
// 		$list .= '<option value="null">Select a Language</option>';
		foreach($rows2 as $r) {
			$list .= '<option value="'.$count.'">'.$r->language.'</option>';	
			$count += 1;
		}
		$list .= '</select>';
		$list .= "
			<style>
				#language-container {
					border-radius: 10px;
				}
				#container-head {
					border-bottom: 5px solid black;
					display: flex;
					justify-content: flex-end;
					padding: 5px;
				}
				#container-title {
					margin-right: 47%;
				}
				#container-main {
					text-align: left;
					padding: 5px;
				}
				#container-settings {
					padding: 5px;
				}
				#text-position {
					display: flex;
					justify-content: center
				}
				#text-positions {
					display: flex;
					margin-left: 10px;
				}
				#text-positions div {
					margin-left: 5px;
					margin-right: 5px;
				}
				#text-colour,
				#text-size {
					display: flex;
					justify-content: center;
				}
				#container-menu-btn,
				#text-position-left,
				#text-position-center,
				#text-position-right {
					cursor: pointer;
				}
				#text-colour div,
				#text-size div {
					margin-left: 10px;
				}
			</style>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
			<div id='language-container' style='display: none; border: 5px solid black'>
				<div id='container-head'>
					<h3 id='container-title'>Title</h3>
					<div id='container-menu-btn'><i class='fas fa-bars'></i></div>
				</div>
				<div id='container-settings' style='display: none'>
					<div id='text-position'>
						<h5>Text Position</h5>
						<div id='text-positions'>
							<div id='text-position-left'><i class='fas fa-align-left'></i></div>
							<div id='text-position-center'><i class=\"fas fa-align-center\"></i></div>
							<div id='text-position-right'><i class=\"fas fa-align-right\"></i></div>
						</div>
					</div>
					<div id='text-size'>
						<h5>Text Size</h5>
						<div><input type='range' min='10' max='25' default='15' /></div>
					</div>
					<div id='text-colour'>
						<h5>Text Colour</h5>
						<div><input type='color' /></div>
					</div>
				</div>
				<div id='container-main'>
					Main Area
				</div>
			</div>
		";
		$count = 0;
		foreach($rows2 as $rr) {
			$paragraphs = explode('&&&', $rows[0]->paragraph_content);
			$translations = explode('&&&', $rr->translation);
			$list .= '<div style="display: none; font-size: 20px;" id="'.$count.'" class="paras">';		
			for ($x=0; $x<count($paragraphs); $x += 1) {
				$list .= '<p><b><span>'.$paragraphs[$x].'</span></b><br><span>'.$translations[$x].'</span></p>';
			}
			$list .= '</div>';
			$count += 1;
		}
		$list .= '</div>';
		$list .= '
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
			<script>
			
				function alphabetizeList(listField) {
					var sel = $(listField);
					var selected = sel.val(); 
					var opts_list = sel.find("option");
					opts_list.sort(function (a, b) {
						return $(a).text().toLowerCase() > $(b).text().toLowerCase() ? 1 : -1;
					});
					sel.html("");
					let option = document.createElement("option");
					option.setAttribute("value", "null");
					option.innerHTML = "Select a Language";
					sel.append(option);
					sel.append(opts_list);
					sel.val("null"); 
				}
			
				document.addEventListener("DOMContentLoaded", function() {
				
					document.querySelector("#text-colour input").onchange = function() {
						document.getElementById("container-main").style.color = document.querySelector("#text-colour input").value;
					}
				
					let rangeValue = document.querySelector("#text-size input").value;
					document.getElementById("container-main").style.fontSize = rangeValue + "px";
				
					document.querySelector("#text-size input").onchange = function() {
						rangeValue = document.querySelector("#text-size input").value;
						document.getElementById("container-main").style.fontSize = rangeValue + "px";
					}
				
					if (document.getElementById("language_dropdown")) {
						
						alphabetizeList("#language_dropdown");
					
					}
					
					document.getElementById("text-position-left").onclick = function() {
						document.getElementById("container-main").style.textAlign = "left";
					}
					
					document.getElementById("text-position-center").onclick = function() {
						document.getElementById("container-main").style.textAlign = "center";
					}
					
					document.getElementById("text-position-right").onclick = function() {
						document.getElementById("container-main").style.textAlign = "right";
					}
					
					if (document.getElementById("container-menu-btn")) {
						document.getElementById("container-menu-btn").onclick = function() {
							if (document.getElementById("container-settings").style.display == "none") {
								document.getElementById("container-settings").style.display = "block";
								document.getElementById("container-main").style.display = "none";
								document.getElementById("container-menu-btn").innerHTML = "<i class=\"fas fa-times\"></i>";
							}
							else {
								document.getElementById("container-menu-btn").innerHTML = "<i class=\"fas fa-bars\"></i>";
								document.getElementById("container-settings").style.display = "none";
								document.getElementById("container-main").style.display = "block";
							}
						}
					}
				})
			</script>
		';
    } 
    else {
		$list = "No Data Found!";
	}
	return $list;
}












add_shortcode('mypara', 'my_custom_para_MB');
function my_custom_para_MB($atts){
	global $post;
	setup_postdata( $post );
	$data = "";
	if(isset($atts["id"])){
          $data .= data_getter_para($atts["id"]);
		  $data .= "
		  	<script>
				document.addEventListener('DOMContentLoaded', function() {
					document.getElementById('language_dropdown').onchange = function() {
						let value = document.getElementById('language_dropdown').value;
						document.querySelectorAll('.paras').forEach(para => {
							para.style.display = 'none';
							document.getElementById('language-container').style.display = 'none';
						})
						if (value != 'null') {
							document.getElementById('language-container').style.display = 'block';
							var e = document.getElementById('language_dropdown');
							var text = e.options[e.selectedIndex].text;
							document.getElementById('container-title').innerHTML = text;
							document.getElementById('container-main').innerHTML = document.getElementById(value).innerHTML;
						}
					}
				})
			</script>
		  ";
	}else{
		$data .= "<h2>No Todo List Found!</h2>";
	}

    return $data;
}

add_action( 'wp_ajax_edit_translations', 'edit_translations' );
function edit_translations() {
	global $wpdb;
	$table = $wpdb->prefix . "language_translator_paragraph_translations";
	$id = $_POST['id'];
	$query = "SELECT * FROM " . $table ." WHERE paragraph_id=" . $id;
	$rows = $wpdb->get_results($query);
	echo json_encode($rows);
	die();
}

add_action( 'wp_ajax_edit_paragraph', 'edit_paragraph' );
function edit_paragraph() {
	global $wpdb;
	$table = $wpdb->prefix . "language_translator_paragraphs";
	$id = $_POST['id'];
	$query = "SELECT * FROM " . $table ." WHERE id=" . $id;
	$rows = $wpdb->get_results($query);
	echo json_encode($rows);
	die();
}


add_action( 'wp_ajax_add_paragraph', 'add_paragraph' );
function add_paragraph() {
	global $wpdb;
	$table = $wpdb->prefix . "language_translator_paragraphs";
	$table2 = $wpdb->prefix . "language_translator_paragraph_translations";
	$id = $_POST['id'];
	$content = $_POST['paragraph_content'];
	$language = $_POST['language_inputs'];
	$textareas = $_POST['textareas'];
	$query = "INSERT INTO " . $table . " (id, paragraph_content) VALUES ('".$id."', '".$content."');";
	$success = $wpdb->query($query);
	if($success){
		$content .= 'Content Added!' ; 
	} else {
		$content .= 'Error Adding Content. ';
	}
	for ($x=0; $x<count($textareas); $x += 1) {
		$query = "INSERT INTO " . $table2 . " (paragraph_id, language, translation) VALUES ('".$id."', '".$language[$x]."', '".$textareas[$x]."');";
		$successes = $wpdb->query($query);
	}
	echo $content;
	die();
}




// Check initial table 
function Language_Translation_Table_Check(){
    global $wpdb;
    
    $my_products_db_version = '1.0.0';
    $charset_collate = $wpdb->get_charset_collate();
        
    $table_name = $wpdb->prefix . "language_translator_paragraphs";
    if ( $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name ) {
        $sql = "CREATE TABLE  $table_name ( 
            `id`  int NOT NULL AUTO_INCREMENT,
            `paragraph_content`  varchar(10000)   NOT NULL,
            PRIMARY KEY  (id)
            ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option('my_db_version', $my_products_db_version);
        }

    $table_name = $wpdb->prefix . "language_translator_paragraph_translations";
    if ( $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name ) {
        $sql = "CREATE TABLE  $table_name ( 
            `id`  int NOT NULL AUTO_INCREMENT,
            `paragraph_id` int NOT NULL,
			`language`  varchar(256)   NOT NULL,
            `translation`  varchar(10000)   NOT NULL,
            PRIMARY KEY  (id)
            ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option('my_db_version', $my_products_db_version);
    }
}

register_activation_hook( __FILE__, 'Language_Translation_Table_Check' );

?>