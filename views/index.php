<h1>PHP Test Application</h1>

<h2>Users</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>E-mail</th>
			<th>City</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $user){?>
		<tr>
			<td><?=$user->getName()?></td>
			<td><?=$user->getEmail()?></td>
			<td><?=$user->getCity()?></td>
		</tr>
		<?php }?>
	</tbody>
</table>


<h2>Add user</h2>
<form method="post" action="create.php" class="form-horizontal">

  <div class="form-group">
 <label for="name" class="col-sm-1 control-label">Name:</label>
    <div class="col-sm-11">
   <input name="name" input="text" id="name" class="form-control"/>
    </div>
  </div>

  <div class="form-group">
 <label for="email" class="col-sm-1 control-label">E&#8209;mail:</label>
    <div class="col-sm-11">
      <input name="email" input="text" id="email" class="form-control"/>
    </div>
  </div>

  <div class="form-group">
  <label for="city" class="col-sm-1 control-label">City:</label>
    <div class="col-sm-11">
   <input name="city" input="text" id="city" class="form-control"/>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-1 col-sm-11">
   <button class="btn btn-primary btn-lg">Create new row</button>
    </div>
  </div>
</form>
