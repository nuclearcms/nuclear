@extends('layout.app')

@isset($content) @include('utilities.seo') @endisset

@section('content')
<div class="min-h-screen bg-stone-950 flex text-white items-center justify-center">
	<div class="p-8 text-center w-full">

		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="28" height="32" viewBox="0 0 28 32" class="mx-auto mb-4 reveal">
			<path d="M20,26.636l-.011-.008a14,14,0,1,0-11.978,0L8,26.636V28H0v4H12V23.8a10,10,0,1,1,4,0V32H28V28H20ZM18,14a4,4,0,1,1-4-4,4,4,0,0,1,4,4" transform="translate(0 0)" fill="#fff"/>
		</svg>
		<h1 class="text-3xl reveal">Welcome to Nuclear.</h1>
	</div>
</div>
@endsection