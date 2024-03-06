## Setup

To setup, simply run:
`npm install`

Then serve using artisan:
`php artisan serve`

Navigate to `127.0.0.1:8000` to view the application.



Notes:

 - Could have implemented more currencies
 - Better error handling by way of a custom exception and or const codes to identify known issues that may occur
 - I was hoping to use a preg_match, however this streippen trailing zeros from some matches, even with flags used, e.g. PREG_OFFSET_CAPTURE
 - I hope this simple setup is okay? I had contemplated creatinng a docker env, but thought my time was better used on other aspects.
 - UNIT TESTS - I didn't want to use more than the 3 hours allotted, and as such, my unit tests require some finesse, but the basics are there, and you can see where I was going at least!

 Any queries, please let me know!

 Many thanks,
 Patrick