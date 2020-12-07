<div class="js-cookie-consent cookie-consent fixed bottom-0 left-0 p-3 sm:p-6 w-full">

	<div class="cookie-consent__inner py-3 px-3 bg-white rounded-md justify-between shadow-lg clearfix flex items-center">
	    <p class="cookie-consent__message inline-block pl-2 pr-3 sm:p-3 flex-grow">
	        {!! trans('cookieConsent::texts.message') !!}
	    </p>

	    <button class="js-cookie-consent-agree cookie-consent__agree uppercase bg-yellow-500 text-xs font-bold tracking-wide shadow-sm rounded-md px-6 py-4 duration-200 transition-colors hover:bg-yellow-400 flex-initial">
	        {{ trans('cookieConsent::texts.agree') }}
	    </button>
    </div>

</div>
