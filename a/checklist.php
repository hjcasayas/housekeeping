<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/
?>
<div class="container-checklist">
	<form action="checklistHandler.php" method="POST">
		<table class="table-checklist">
			<tbody>

				<tr>
					<th colspan="3"><h3>Checklists</h3></th>
					<th><h3>Yes</h3></th>
					<th class="members-column"><h3>Members</h3></th>
					<th class="comments-column"><h3>Comments</h3></th>
				</tr>

				<?php include "generateReport.php"; ?>

			</tbody>
		</table>
		<br>
	</form>
		<input type="Submit" name="submitChecklist" value="Submit Housekeeping" id="submit-checklist">
</div>