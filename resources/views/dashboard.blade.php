<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

    @if(Auth::user()->role=='admin')
    
    
    @include('admin.admindashboard')
  
    @elseif(Auth::user()->role=='student')
    
        
    @include('student.studentdashboard')



@elseif(Auth::user()->role=='teacher')

@include('teacher.teacherdashboard')
    @endif

</body>
</html>
