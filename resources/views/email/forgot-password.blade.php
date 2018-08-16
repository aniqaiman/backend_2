<html>
<head>
	<body>
		<h1>Reminder</h1>
		<p>Hi. Click <a href="{{route('resetPasswordFromEmail',['email'=>$email,'resetCode'=>$token])}}">here</a> to reset your password</p>
	</body>
</head>
</html>
