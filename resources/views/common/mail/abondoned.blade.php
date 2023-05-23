<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Abondoned Items In your Cart</h2>

<div class="table-responsive abondoned">
<table class="table table-striped table-hover" style="border: 1px solid #000;">
  @foreach($data as $item)
	<tbody>
	<tr>
	<td><strong>Name</strong></td>
	<td>{{ $item['productName'] }}</td>
	</tr>
	<tr>
	<td><strong>Price</strong></td>
	<td> {{ $item['productPrice'] }}</td>
	</tr>
	<tr>
	<td><strong>Qty</strong></td>
	<td>{{ $item['productQty'] }}</td>
	</tr>
	<tr>
	<td><strong>Image</strong></td>
	<td>{{ $item['productImg'] }}</td>
	</tr>
	<tr>
	<td><strong>Message</strong></td>
	<td>{{ $item['message'] }}</td>
	</tr>
	</tbody>
	    @endforeach
</table>
 <p>Thanks,<br></p>
	{{ config('app.name') }}
</div>


<!--<div>
  @foreach($data as $item)
    <p>
      Name: {{ $item['productName'] }}
    </p>
    <p>
      Price: {{ $item['productPrice'] }}
    </p>
    <p>
      Qty: {{ $item['productQty'] }}
    </p>
    <p>
      Image: {{ $item['productImg'] }}
    </p>
    <p>
      Message: {{ $item['message'] }}
    </p>
    @endforeach
    <p>Thanks,<br></p>
	{{ config('app.name') }}
</div>-->

</body>
</html>