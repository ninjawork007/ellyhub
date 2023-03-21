<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Contact form enquiry</h2>

<div class=" table-responsive abondoned">
	Hello,
You received a message from : {{ $data['name'] }}
<table class="table table-striped table-hover">

	<tbody>
	<tr>
	<td><strong>Name</strong></td>
	<td>{{ $data['name'] }}</td>
	</tr>
	<tr>
	<td><strong>Email</strong></td>
	<td> {{ $data['email'] }}</td>
	</tr>
	<tr>
	<td><strong>Tel</strong></td>
	<td>{{ $data['tel'] }}</td>
	</tr>
	<td><strong>Message</strong></td>
	<td>{{ $data['message'] }}</td>
	</tr>
	</tbody>

</table>
 <p>Thanks,<br></p>
	{{ config('app.name') }}
</div>

</body>
</html>