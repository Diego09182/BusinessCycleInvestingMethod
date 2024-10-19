<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0"/>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>景氣循環投資策略決策工具</title>
	@vite(['resources/js/app.js','resources/css/app.css'])
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="{{ asset('images/BusinessCycle.ico') }}" type="image/x-icon" />
</head>
<body>
<div id="app">
    
	@include('components.navigation')

    @yield('content')

	@include('components.footers')

</div>
</body>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
@yield('scripts')
</html>