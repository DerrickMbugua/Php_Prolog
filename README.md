How to Call SWI-Prolog from PHP 5
1) Requirements
1.a) Swi-Prolog installed on a Windows 7, 8, 10 PC.
1.b) Wamp server with php 5.4 or higher. You can also use Xampp server but you may express issues later on. We highly recommend Wamp server.
1.c) PHP must have the safe_mode turned off, this will allow calling programs that are not in the same folder as the php that calls them. In the php.ini there is a directive for this that must be Off but it may still not work, to make sure you must add this to the end of the httpd.conf and restart the server:
1.d) You must have added the binary folder of the Prolog installation incorporated in the Windows Path, for example in my case it is: C: \ Program Files \ swipl \ bin , if you don't know how to do this, here is a step by step tutorial for Windows 7.
1.e) Inside the www folder of the server, I will create a directory called "prolog" which of course can have any other name, inside this directory is where we will work.

2) The Prolog
Inside the server folder created previously, we will have an archvo called test.pl with a test functor:
Prolog code:

test : -  write ( 'Prolog \ nwas called \ nfrom PHP \ nsuccessfully.' ) .

3) The console pretest
3.a) Before messing with PHP for the first time, you should do a console test to make sure that all the previous steps were successful, especially since in case of error, php does not It does not explode or throw errors / warning / notices or anything, it continues as if nothing happened which can be very puzzling.
3.b) Open the Windows console (Command Prompt or cmd.exe) and there you go to the folder on your server by typing:
BAT code:
See original
cd C: \ server \ www \ prolog
 
replacing with the location where your wampserver is installed and the name of the folder that you created previously.
3.c) Now you write the following command to the console:
BAT code:
See original
swipl -s test.pl -g "test." -t halt.
 
3.d) If everything is ok, you will be seeing this message:
Appointment:

% C: /server/www/prolog/test.pl compiled 0.00 sec, 2 clauses
Prolog
was called
from PHP
successfully.

Otherwise, you should check that the previous steps are correct.

4) PHP
4.a) As a starting point, highlight that none of the program execution functions worked for me and when I say none, I mean none of the ones in the manual, they all failed, or rather, "no They did nothing "because failing implies an error and PHP did not throw a notice, instead of these functions, I had to resort to the inverted inverter operator which is why previously we had to deactivate the safe_mode with so much emphasis.
4.b) In the same prolog folder on the server, where we put test.pl we are going to create an index.php with the following content:
PHP code:
See original
<? php  
  $ output  = `swipl - s test. pl - g "test."  - t halt . ` ;
  var_dump ( $output ) ;
  system($output);
  echo "\n";

$cmd = exec( $output );
echo $cmd;
echo "\n";

exec( $output,$cmd );
print_r( $cmd );
echo "\n";

$cmd = shell_exec( $output );
echo $cmd;
echo "\n";
  ?>
 
with which we should have this output when entering through the browser:
Appointment:
string 'Prolog
was called
from PHP
successfully.' (length = 43)

Prolog was called from PHP successfully. successfully. 

Array ( [0] => Prolog [1] => was called [2] => from PHP [3] => successfully. ) 

Prolog was called from PHP successfully.

4.c) Sending parameters to Prolog is very simple, if you look at the command that we execute, we have this "test." in quotes, in there we can write what we want since that is a statement that is executed in Prolog directly, we can pass lists, variables, other functors, whatever you want.
4.d) The reception of responses is in text form, so we must make sure that our prolog returns its response in a format that we can later break down with string functions or regular expressions.

Calling SWI-Prolog with PHP 5's "system", "exec", and "shell_exec" functions
The "system" function runs the command and sends all its output to standard output. More information can be found from the PHP manual entries for these functions, linked from here.

The one-argument variant of the "exec" function runs the command and returns only the final line of its output as a string.

The two-argument variant of "exec" puts an array into its second argument. Each line is one line of the command's output. In my script, I displayed this array with the built-in print_r.

Finally, the "shell_exec" function runs the command and returns all its output as a string. This function is identical to PHP's backticks operator.

Which function should one use?
Given these ways of invoking Prolog, when are they appropriate? The "system" function is useful when you simply want to squirt all your program's output back at the Web browser. I do this in my science-fiction plot generator, as you can see from the source I've put up of its script.

The one-argument "exec" doesn't seem particularly useful, and I included it only to show how it differs from the two-argument variant. The latter is useful for the same reason that shell_exec is, namely that it allows one to manipulate the output rather than just flinging it all into a browser. Such manipulation, for preserving the Prolog program's state between transactions in a session, and for splitting off different chunks of output to display in different regions of the page.
