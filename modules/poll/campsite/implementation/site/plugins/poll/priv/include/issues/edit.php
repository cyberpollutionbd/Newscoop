<?php
$issue_language_id = $issueObj->getLanguageId();
$issue_nr = $issueObj->getIssueNumber();
$publication_id = $issueObj->getPublicationId();
?>

<P>
<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="6" class="table_input" width="100%">
<TR>
	<TD>
		<B><?php  putGS("Polls"); ?></B>
	</TD>
    <?php if ($g_user->hasPermission('ManagePoll')) {  ?>

    	<TD align="right">
    		<IMG src="<?php p($Campsite["ADMIN_IMAGE_BASE_URL"]);?>/configure.png" border="0">
    		<A href="javascript: void(0);" onclick="window.open('<?php p("/$ADMIN/poll/assign_popup.php?f_target=issue&amp;f_issue_nr=$issue_nr&amp;f_issue_language_id=$issue_language_id&amp;f_publication_id=$publication_id"); ?>', 'assign_poll', 'scrollbars=yes, resizable=yes, menubar=no, toolbar=no, width=500, height=400, top=200, left=100');"><?php putGS("Edit"); ?></A>
    	</TD>
    	<?php } ?>
</TR>
<TR><TD colspan="2"><HR NOSHADE SIZE="1" COLOR="BLACK"></TD></TR>
<TR>
	<TD colspan="2">
    	<div style="overflow: auto; max-height: 50px">  
        <?php
        foreach (PollIssue::getAssignments(null, null, $issueObj->getLanguageId(), $issueObj->getIssueNumber(), $issueObj->getPublicationId()) as $pollIssue) {
            $poll = $pollIssue->getPoll();	
            p($poll->getName());
    		p("&nbsp;({$poll->getLanguageName()})<br>");
    	} 
    	?>
    	</div>
	</TD>
</TR>
</TABLE>
</FORM>
