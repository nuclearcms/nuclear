<div class="js-cookie-consent cookie-consent fixed bottom-0 right-0 p-2 w-full flex justify-center z-50">

	<div class="cookie-consent__inner p-1 bg-white rounded-md justify-between shadow-lg flex items-center sm:max-w-md gap-4">
	    <p class="cookie-consent__message inline-block text-sm leading-tight pl-2">
	        {!! trans('cookie-consent::texts.message') !!}
	    </p>

	    <button class="js-cookie-consent-agree cookie-consent__agree uppercase bg-yellow-500 text-xs font-bold tracking-widest text-2xs shadow-sm rounded-md p-2 duration-300 transition-colors hover:bg-yellow-300 flex-initial cursor-pointer">
	        {{ trans('cookie-consent::texts.agree') }}
	    </button>
    </div>

</div>
