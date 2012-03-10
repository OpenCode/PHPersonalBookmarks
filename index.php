<?php

	ob_start();

	function cutline($filename,$line_no=-1) {
		$strip_return=FALSE;
		$data=file($filename);
		$pipe=fopen($filename,'w');
		$size=count($data);
		if($line_no==-1){
			$skip=$size-1;
		}
		else {
			$skip=$line_no-1;
		}
		for ($line=0;$line<$size;$line++){
			if ($line!=$skip) {
				fputs($pipe,$data[$line]);
				}
			else {
				$strip_return=TRUE;
				}
			}
		return $strip_return;
		}

	function create_link($link, $text){
		return '<a target="_blank" href="' . $link . '">' . $text . '</a>';
		}

	function get_tag($lista_tags){
		$tags = explode(",", $lista_tags);
		$show_tags = '';
		for ($i = 0; $i <= count($tags); $i++){
			$show_tags .= ' ' . $tags[$i];
			}
		return $show_tags;
		}

	function create_delete_link($link_id){
		return 'index.php?del=' . ($link_id + 1);
		}

	function create_line($id, $link, $text, $description, $tags){
		return '<tr> 
			<td><input type="checkbox"></td> 
			<td>' . create_link($link, $text) . '</td> 
			<td>' . $description . '</td> 
			<td>' . get_tag($tags) . '</td> 
			<td>
				<a href="#"><img src="images/icn_edit.png" /></a>
				<a href="' . create_delete_link($id) . '"><img src="images/icn_trash.png" /></a>
				<a target="_blank" href="http://www.addthis.com/bookmark.php?url=' . $link . '&title=' . $text . '&description=' . $description . '"><img src="images/icn_jump_back.png" /></a>
			</td> 
		</tr>';
		}

	function show_template($content){
		// POPOLA IL TEMPLATE E LO MOSTRA
		$template = fopen('template.html', 'r');
		$dim = filesize('template.html');
		$complete_template = fread($template, $dim);
		$complete_template = str_replace('{{CONTENT}}', $content, $complete_template);
		fclose($template);
		return $complete_template;
		}

	function show_new_link_form(){
		$content = '<article class="module width_full">
			<form name="new_link" method="POST" action=".">
			<header><h3>New Link</h3></header>
				<div class="module_content">
							<fieldset>
								<label>URL</label>
								<input type="text" name="url">
							</fieldset>
							<fieldset>
								<label>Name</label>
								<input type="text" name="name">
							</fieldset>
							<fieldset>
								<label>Description</label>
								<textarea name="description" rows="12"></textarea>
							</fieldset>
							<fieldset>
								<label>Tags (Separated by comma)</label>
								<input type="text" name="tags">
							</fieldset>
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					<input type="submit" value="Save" class="alt_btn">
				</div>
			</footer>
			</form>
		</article>';
		return show_template($content);
		}

	function show_link_list($content_link, $message){
		$internal_content = $message;
		$internal_content .= '<article class="module width_full">
			<header><h3 class="tabs_involved">Links</h3>
			</header>
			<div class="tab_container">
				<div id="tab1" class="tab_content">
				<table class="tablesorter" cellspacing="0"> 
				<thead> 
					<tr> 
						<th></th> 
						<th>URL</th> 
						<th>Description</th> 
						<th>Tags</th> 
						<th>Action</th> 
					</tr> 
				</thead> 
				<tbody> ' . $content_link . '</tbody> 
				</table>
				</div><!-- end of #tab1 -->
			</div><!-- end of .tab_container -->
		</article><!-- end of content manager article -->';
		return show_template($internal_content);
		}

	include "class/password_protect.php";

	// Global content
	$content = '';
	// Used if there are messagges
	$message = '';

	if (isset($_GET['del'])){
		cutline('link.list', $_GET['del']);
		$message .= '<h4 class="alert_success">Link deleted</h4>';
		}

	// Show the new link form
	if (isset($_GET['new'])){
		$content .= show_new_link_form();
		echo $content;
		return;
		}

	// Create the new link line in link list
	if (isset($_POST) && $_POST['name'] != ''){
		$handle = fopen('link.list', 'a+');
		$data = "\n" . $_POST['url'] . '|' . $_POST['name'] . '|' . $_POST['description'] . '|' . $_POST['tags'];
		fwrite($handle, $data);
		fclose($handle);
		$message .= '<h4 class="alert_success">Link for ' . $_POST['name'] . ' created</h4>';
		unset($_POST);
		}

	if (file_exists('link.list')) {
		$linklist = fopen('link.list', 'r');
		$linklistdim = filesize('link.list');
		$complete_linklist = fread($linklist, $linklistdim);
		$links = explode("\n", $complete_linklist);
		$content_link = '';
		for ($i = 0; $i <= count($links); $i++) {
			$link = explode("|", $links[$i]);
			if ($link[0] != ''){
				$content_link .= create_line($i, $link[0], $link[1], $link[2], $link[3]);
				}
			}
		$content .= show_link_list($content_link, $message);
		echo $content;
		return;
	} else {
		$linklist = fopen('link.list', 'x');
		$content .= show_new_link_form();
		echo $content;
		return;
	}

	

?>
