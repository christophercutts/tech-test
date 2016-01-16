<?php include 'header.php'; ?>
<div id="main">
	<form method="post">
		<table>
			<thead>
				<tr>
					<th>First name</th>
					<th>Last name</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($people as $person) { ?>
					<tr>
						<td><input type="text" name="people[][firstname]" class="firstname" value="<?php echo htmlentities($person->getFirstname()); ?>" /></td>
						<td><input type="text" name="people[][surname]" class="surname" value="<?php echo htmlentities($person->getSurname()); ?>" /></td>
						<td>
							<input type="hidden" name="people[][id]" class="id" value="<?php echo htmlentities($person->getId()); ?>" />
							<input type="button" value="Update" class="update" />
							<input type="button" value="Delete" class="delete" />
						</td>
					</tr>
				<?php } ?>
				<tr class="hid prototype">
					<td><input type="text" name="people[][firstname]" class="firstname" /></td>
					<td><input type="text" name="people[][surname]" class="surname" /></td>
					<td>
						<input type="hidden" name="people[][id]" class="id" />
						<input type="button" value="Update" class="update" />
						<input type="button" value="Delete" class="delete" />
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td><input type="text" name="people[][firstname]" class="firstname" /></td>
					<td><input type="text" name="people[][surname]" class="surname" /></td>
					<td>
						<input type="hidden" name="csrf" id="csrf" value="<?php echo $csrf; ?>"/>
						<input type="button" value="Add" class="add" />
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
</div>
<?php include 'footer.php';