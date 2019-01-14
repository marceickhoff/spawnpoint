<?php
	try {
		require_once("libraries/TeamSpeak3/TeamSpeak3.php");
		// connect to local server, authenticate and spawn an object for the virtual server on port 9987
		$ts3_VirtualServer = TeamSpeak3::factory("serverquery://serveradmin:ieSeipheuloh0yoh@188.68.50.155:10011");
		// build and display HTML treeview using custom image paths (remote icons will be embedded using data URI sheme)
		error_reporting(E_ALL);
		$html = $ts3_VirtualServer->getViewer(new TeamSpeak3_Viewer_Html());
		$html = str_replace('<img src=\'ts3/images/viewer/client_talk.png\' title=\'\' alt=\'\' align=\'top\' />', '<span class="tsviewer-signal tsviewer-signal-active"></span>', $html);
		$html = preg_replace('/img src=\'ts3\/images\/viewer\/client_[a-z_]+\.png\' title=\'\' alt=\'\' align=\'top\' \//i', 'span class="tsviewer-signal"></span', $html); //Ugly but works good enough
		echo $html;
	}
	catch (Exception $e) { ?>
		<div class="font-size-m">
			<p class="danger"><strong>Error <?=$e->getCode()?>:</strong> <?=$e->getMessage()?></p>
			<p>Because of the internal error seen above, the TeamSpeak Viewer can unfortunately not be displayed. Our actual TeamSpeak server might still be running, though.</p>
			<p><strong>We're working on a solution. Stay tuned!</strong></p>
		</div>
	<?php }
?>
